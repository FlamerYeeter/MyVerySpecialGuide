<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class GuardianReviewController extends Controller
{
    // List applications from Firestore, optionally filtered by job_id
    public function list(Request $request)
    {
        $jobId = $request->query('job_id');
        try {
            $accessToken = $this->getServiceAccessToken();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'no_service_account', 'message' => $e->getMessage()], 500);
        }

        $sa = $this->getServiceAccount();
        $projectId = $sa['project_id'];

        $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/applications";
        $resp = Http::withToken($accessToken)->get($url);
        if (!$resp->successful()) {
            return response()->json(['error' => 'firestore_list_failed', 'body' => $resp->body()], 500);
        }
        $json = $resp->json();
        $docs = $json['documents'] ?? [];
        // build CSV index once (server-side enrichment)
        $csvIndex = $this->buildCsvIndex();

        $out = [];
        foreach ($docs as $doc) {
            $parsed = $this->docToPhp($doc);
            // normalize application shape (merge payload if present and create human-friendly timestamps)
            $parsed = $this->normalizeApplication($parsed);
            // doc name and id
            $name = $doc['name'] ?? null;
            $id = $name ? basename($name) : null;
            $parsed['_docName'] = $name;
            $parsed['_docId'] = $id;
            // If jobId provided, filter: check common places
            if ($jobId) {
                $found = false;
                // check top-level job_id
                if (isset($parsed['job_id']) && (string)$parsed['job_id'] === (string)$jobId) $found = true;
                // check nested job.raw.job_id
                if (!$found && isset($parsed['job']) && is_array($parsed['job'])) {
                    if (isset($parsed['job']['raw']) && is_array($parsed['job']['raw']) && isset($parsed['job']['raw']['job_id']) && (string)$parsed['job']['raw']['job_id'] === (string)$jobId) $found = true;
                }
                // check payload nesting (client fallback)
                if (!$found && isset($parsed['payload']) && is_array($parsed['payload'])) {
                    if (isset($parsed['payload']['job_id']) && (string)$parsed['payload']['job_id'] === (string)$jobId) $found = true;
                    if (!$found && isset($parsed['payload']['job']) && isset($parsed['payload']['job']['raw']) && isset($parsed['payload']['job']['raw']['job_id']) && (string)$parsed['payload']['job']['raw']['job_id'] === (string)$jobId) $found = true;
                }
                if (!$found) continue;
            }
            // attempt to enrich parsed application with CSV job data (server-side)
            $this->enrichApplicationWithCsv($parsed, $csvIndex);
            $out[] = $parsed;
        }


        return response()->json(['success' => true, 'applications' => $out]);
    }

    // Approve an application (sets guardian_status = 'approved')
    public function approve(Request $request, $docId)
    {
        return $this->setGuardianStatus($request, $docId, 'approved');
    }

    // Flag an application (sets guardian_status = 'flagged')
    public function flag(Request $request, $docId)
    {
        return $this->setGuardianStatus($request, $docId, 'flagged');
    }

    private function setGuardianStatus(Request $request, $docId, $status)
    {
        try {
            $accessToken = $this->getServiceAccessToken();
        } catch (\Throwable $e) {
            return response()->json(['error' => 'no_service_account', 'message' => $e->getMessage()], 500);
        }
        $sa = $this->getServiceAccount();
        $projectId = $sa['project_id'];
        $docName = "projects/{$projectId}/databases/(default)/documents/applications/{$docId}";

        $fields = [];
        $fields['guardian_status'] = ['stringValue' => $status];
        $fields['guardian_feedback'] = ['stringValue' => $request->input('feedback', '')];
        $fields['guardian_actioned_by'] = ['stringValue' => auth()->id() ? (string)auth()->id() : ''];
        $fields['guardian_actioned_at'] = ['timestampValue' => now()->toAtomString()];

        $url = "https://firestore.googleapis.com/v1/" . $docName . "?updateMask.fieldPaths=guardian_status&updateMask.fieldPaths=guardian_feedback&updateMask.fieldPaths=guardian_actioned_by&updateMask.fieldPaths=guardian_actioned_at";

        $resp = Http::withToken($accessToken)->patch($url, ['fields' => $fields]);
        if (!$resp->successful()) {
            return response()->json(['error' => 'firestore_update_failed', 'body' => $resp->body()], 500);
        }
        return response()->json(['success' => true]);
    }

    // Helpers
    private function getServiceAccount()
    {
        $serviceAccountPath = env('FIREBASE_SERVICE_ACCOUNT') ?: storage_path('app/firebase-service-account.json');
        if (!file_exists($serviceAccountPath)) throw new \RuntimeException('Service account missing');
        $sa = json_decode(file_get_contents($serviceAccountPath), true);
        if (!$sa) throw new \RuntimeException('Invalid service account');
        return $sa;
    }

    private function getServiceAccessToken()
    {
        $sa = $this->getServiceAccount();
        $clientEmail = $sa['client_email'];
        $privateKey = $sa['private_key'];
        $now = time();
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $scope = 'https://www.googleapis.com/auth/datastore https://www.googleapis.com/auth/cloud-platform';
        $assertion = [
            'iss' => $clientEmail,
            'scope' => $scope,
            'aud' => $tokenUrl,
            'exp' => $now + 3600,
            'iat' => $now,
        ];
        $jwt = $this->createSignedJwt($assertion, $privateKey);
        $resp = Http::asForm()->post($tokenUrl, [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $jwt,
        ]);
        if (!$resp->successful()) {
            throw new \RuntimeException('token request failed: ' . $resp->body());
        }
        $data = $resp->json();
        if (empty($data['access_token'])) throw new \RuntimeException('no access_token');
        return $data['access_token'];
    }

    private function createSignedJwt(array $payload, string $privateKeyPem): string
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $segments = [];
        $segments[] = $this->base64UrlEncode(json_encode($header));
        $segments[] = $this->base64UrlEncode(json_encode($payload));
        $signingInput = implode('.', $segments);
        $pkey = openssl_pkey_get_private($privateKeyPem);
        if ($pkey === false) throw new \RuntimeException('Invalid private key');
        $signature = '';
        $ok = openssl_sign($signingInput, $signature, $pkey, OPENSSL_ALGO_SHA256);
        openssl_free_key($pkey);
        if (!$ok) throw new \RuntimeException('OpenSSL signing failed');
        $segments[] = $this->base64UrlEncode($signature);
        return implode('.', $segments);
    }

    private function base64UrlEncode(string $input): string
    {
        return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
    }

    // Convert Firestore document REST response to simple PHP array
    private function docToPhp(array $doc)
    {
        $out = [];
        if (isset($doc['fields']) && is_array($doc['fields'])) {
            foreach ($doc['fields'] as $k => $v) {
                $out[$k] = $this->firestoreValueToPhp($v);
            }
        }
        return $out;
    }

    private function firestoreValueToPhp($v)
    {
        if (!is_array($v)) return $v;
        if (isset($v['stringValue'])) return $v['stringValue'];
        if (isset($v['integerValue'])) return (int)$v['integerValue'];
        if (isset($v['doubleValue'])) return (float)$v['doubleValue'];
        if (isset($v['booleanValue'])) return (bool)$v['booleanValue'];
        if (isset($v['timestampValue'])) return $v['timestampValue'];
        if (isset($v['nullValue'])) return null;
        if (isset($v['mapValue'])) {
            $fields = $v['mapValue']['fields'] ?? [];
            $out = [];
            foreach ($fields as $kk => $vv) $out[$kk] = $this->firestoreValueToPhp($vv);
            return $out;
        }
        if (isset($v['arrayValue'])) {
            $vals = $v['arrayValue']['values'] ?? [];
            $out = [];
            foreach ($vals as $vv) $out[] = $this->firestoreValueToPhp($vv);
            return $out;
        }
        return $v;
    }

    // Normalize application payloads for consistent rendering
    private function normalizeApplication(array $a)
    {
        // If there's a payload map (client fallback), merge it into top-level fields without overwriting existing values
        if (isset($a['payload']) && is_array($a['payload'])) {
            foreach ($a['payload'] as $k => $v) {
                if (!isset($a[$k])) $a[$k] = $v;
            }
        }

        // Normalize job object: prefer top-level job map, then payload.job, then individual fields
        $job = [];
        if (isset($a['job']) && is_array($a['job'])) $job = $a['job'];
        elseif (isset($a['payload']['job']) && is_array($a['payload']['job'])) $job = $a['payload']['job'];
        else {
            // build minimal job map from available fields
            $job['title'] = $a['job_title'] ?? ($a['payload']['job_title'] ?? null);
            $job['company'] = $a['company_employer'] ?? ($a['payload']['company_employer'] ?? null);
            $job['job_id'] = $a['job_id'] ?? ($a['payload']['job_id'] ?? null);
        }
        $a['job'] = $job;

        // Normalize submitted_at: prefer timestampValue if present, else use string
        $submitted = null;
        if (isset($a['submitted_at'])) $submitted = $a['submitted_at'];
        elseif (isset($a['payload']['submitted_at'])) $submitted = $a['payload']['submitted_at'];
        // if it's an iso string, parse and format; otherwise leave as-is
        if ($submitted) {
            try {
                $dt = Carbon::parse($submitted);
                $a['submitted_at_display'] = $dt->toDayDateTimeString();
                $a['submitted_at'] = $dt->toIso8601String();
            } catch (\Throwable $e) {
                $a['submitted_at_display'] = (string)$submitted;
            }
        } else {
            $a['submitted_at_display'] = '';
        }

        return $a;
    }

    // Build an in-memory CSV index: keyed by job_id (string) and by dataIndex (0-based)
    private function buildCsvIndex()
    {
    $path = public_path('postings.csv');
        $index = ['byId' => [], 'byDataIndex' => []];
        if (!file_exists($path)) return $index;
        if (($h = fopen($path, 'r')) === false) return $index;
        $header = fgetcsv($h);
        if ($header === false) { fclose($h); return $index; }
        $cols = array_map(function($x){ return trim($x); }, $header);
        $dataIndex = 0;
        while (($row = fgetcsv($h)) !== false) {
            // skip empty rows
            $allEmpty = true; foreach ($row as $c) { if (strlen(trim((string)$c))>0) { $allEmpty = false; break; } }
            if ($allEmpty) continue;
            $assoc = [];
            for ($i=0;$i<count($cols);$i++) $assoc[$cols[$i] ?? 'col_'.$i] = $row[$i] ?? '';
            // normalize keys to lower_snake for easier mapping
            $norm = [];
            foreach ($assoc as $k=>$v) { $nk = preg_replace('/[^a-z0-9_]+/i', '_', strtolower(trim($k))); $norm[$nk] = $v; }
            // canonical job id
            $jobid = $norm['job_id'] ?? ($norm['id'] ?? ($norm['jobid'] ?? null));
            if ($jobid !== null && strlen(trim((string)$jobid))>0) $index['byId'][ (string) $jobid ] = ['raw'=>$assoc, 'norm'=>$norm, '__dataIndex'=>$dataIndex];
            // always index by dataIndex
            $index['byDataIndex'][(string)$dataIndex] = ['raw'=>$assoc, 'norm'=>$norm, '__dataIndex'=>$dataIndex];
            $dataIndex++;
        }
        fclose($h);
        return $index;
    }

    // Enrich application array with CSV job data if possible
    private function enrichApplicationWithCsv(array &$app, array $csvIndex)
    {
        // check several spots for job id or data index
        // Use ONLY the application's stored job id(s) for lookup. Do NOT trust payload values from the client.
        $candidates = [];
        if (isset($app['job_id'])) $candidates[] = (string)$app['job_id'];
        if (isset($app['job']) && is_array($app['job']) && isset($app['job']['job_id'])) $candidates[] = (string)$app['job']['job_id'];
        // also allow numeric candidate which might be data index
        $found = null;
        foreach ($candidates as $cand) {
            if ($cand === '') continue;
            // exact byId
            if (isset($csvIndex['byId'][(string)$cand])) { $found = $csvIndex['byId'][(string)$cand]; break; }
            // numeric fallback to dataIndex
            if (is_numeric($cand) && isset($csvIndex['byDataIndex'][ (string)((int)$cand) ])) { $found = $csvIndex['byDataIndex'][ (string)((int)$cand) ]; break; }
        }
        // If not found, try job.job.raw.job_id (still from stored job map, not payload)
        if (!$found && isset($app['job']) && is_array($app['job']) && isset($app['job']['raw']) && is_array($app['job']['raw'])) {
            $raw = $app['job']['raw'];
            if (isset($raw['job_id']) && isset($csvIndex['byId'][(string)$raw['job_id']])) $found = $csvIndex['byId'][(string)$raw['job_id']];
        }
        if (!$found) return;
        // merge selected normalized fields into $app['job'] but do not overwrite existing job keys
        $norm = $found['norm'];
        $raw = $found['raw'];
    if (!isset($app['job']) || !is_array($app['job'])) $app['job'] = [];
    // FORCE title/company to come from CSV (do not trust client-provided values)
    $app['job']['title'] = trim((string)($raw['Title'] ?? $raw['jobpost'] ?? ($norm['title'] ?? ($norm['jobpost'] ?? ''))));
    $app['job']['company'] = trim((string)($raw['Company'] ?? $raw['AboutC'] ?? ($norm['company'] ?? '')));
    // populate/override location and hours/duration from CSV where available
    $app['job']['location'] = trim((string)($raw['Location'] ?? ($norm['location'] ?? '')));
    $app['job']['hours'] = trim((string)($raw['Duration'] ?? $raw['Term'] ?? ($norm['duration'] ?? ($norm['term'] ?? ''))));
    // include raw and indices for client use
    $app['job']['raw'] = $raw;
    $app['job']['__dataIndex'] = $found['__dataIndex'] ?? null;
    }
}
