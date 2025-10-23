<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

// JWT helper for signing service account assertions
use Firebase\JWT\JWT;

class JobApplicationController extends Controller
{
    /**
     * Submit a job application by writing to Firestore via the REST API.
     * Uses service account JWT OAuth2 flow to obtain an access token.
     * Requires: composer require firebase/php-jwt
     */
    public function submit(Request $request)
    {
        // Debug: log that submit was called and current Laravel auth state
        try {
            logger()->info('JobApplicationController: submit called', [
                'laravel_auth' => auth()->check() ? 'authenticated' : 'guest',
                'laravel_user_id' => auth()->id(),
                'wantsJson' => $request->wantsJson() || $request->isJson(),
                'remote_addr' => $request->getClientIp(),
            ]);
        } catch (\Throwable $e) {
            // ignore logging failures
        }

    $data = $request->all();
    // Treat JSON POSTs and fetch() calls as API clients even if Accept header isn't set.
    $isApi = $request->wantsJson() || $request->isJson() || str_contains((string)$request->header('Content-Type', ''), 'application/json') || $request->ajax();

        // Attempt to authenticate: prefer Laravel session, fallback to Firebase ID token
        $laravelUserId = auth()->id();
        $firebaseUid = null;
        try {
            $idToken = null;
            $authHeader = $request->header('Authorization', '') ?: $request->server('HTTP_AUTHORIZATION', '');
            if ($authHeader && preg_match('/Bearer\s+(.*)$/i', $authHeader, $m)) {
                $idToken = trim($m[1]);
            }
            if (!$idToken) $idToken = (string)$request->input('idToken', '');
            if ($idToken) {
                $firebaseUid = $this->verifyFirebaseIdToken($idToken);
            }
        } catch (\Throwable $e) {
            logger()->warning('JobApplicationController: firebase token verify failed: ' . $e->getMessage());
        }

        // If no Laravel session and no Firebase uid, return a JSON 401 for API clients
        if (empty($laravelUserId) && empty($firebaseUid)) {
            if ($isApi) {
                return response()->json(['success' => false, 'error' => 'unauthorized', 'message' => 'Authentication required (Laravel session or Firebase idToken).'], 401);
            }
            return redirect()->route('login')->with('error', 'You must be signed in to submit an application.');
        }

        // Debug: log auth headers and resolved identities
        try {
            logger()->info('JobApplicationController: auth resolution', [
                'laravel_user_id' => $laravelUserId,
                'firebase_uid' => $firebaseUid,
                'auth_header_present' => !empty($request->header('Authorization', '') ?: $request->server('HTTP_AUTHORIZATION', '')),
            ]);
        } catch (\Throwable $e) {}

        // If a job_id was provided, try to enrich the payload with job details from the CSV
        $jobId = $data['job_id'] ?? $request->query('job_id') ?? null;
        // Normalize 'p' prefixed ids (used by some client-side renderers) to numeric when possible
        if (is_string($jobId) && preg_match('/^p(\d+)$/i', $jobId, $m)) {
            $jobId = (int)$m[1];
        }

        if ($jobId !== null) {
            try {
                $job = $this->getJobFromCsv($jobId);
                if ($job) {
                    // nest under 'job' key to keep payload organized
                    $data['job'] = $job;
                }
            } catch (\Throwable $e) {
                logger()->warning('JobApplicationController: failed to load job details for job_id ' . $jobId . ': ' . $e->getMessage());
            }
        }

        // Debug: log whether job details were attached
        try {
            logger()->info('JobApplicationController: payload after enrichment', [
                'has_job' => isset($data['job']),
                'job_preview' => isset($data['job']) ? (is_array($data['job']) ? array_slice($data['job'], 0, 5) : $data['job']) : null,
                'job_id' => $jobId,
            ]);
        } catch (\Throwable $e) {}

        // If debugging requested, return the enriched payload immediately (skip Firestore write)
        // Accept either query param ?_debug_enriched=1 or JSON body field _debug_enriched: 1
        $debugEnriched = false;
        try {
            if ($request->query('_debug_enriched')) $debugEnriched = true;
            if (!$debugEnriched && is_array($data) && array_key_exists('_debug_enriched', $data) && $data['_debug_enriched']) $debugEnriched = true;
        } catch (\Throwable $e) {
            // ignore
        }

        if ($debugEnriched) {
            // Return JSON with the full payload and the enriched job (if present)
            if ($request->wantsJson() || $request->isJson() || true) {
                return response()->json(['debug' => true, 'payload' => $data, 'job' => $data['job'] ?? null]);
            }
        }

    // Load service account
    $serviceAccountPath = (getenv('FIREBASE_SERVICE_ACCOUNT') ?: '') ?: storage_path('app/firebase-service-account.json');
        if (!file_exists($serviceAccountPath)) {
            logger()->error('JobApplicationController: service account missing: ' . $serviceAccountPath);
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['error' => 'service_account_missing', 'message' => 'Server misconfiguration (service account missing).'], 500);
            }
            return redirect()->back()->with('error', 'Server misconfiguration (service account missing).');
        }

        $sa = json_decode(file_get_contents($serviceAccountPath), true);
        if (!$sa || empty($sa['client_email']) || empty($sa['private_key']) || empty($sa['project_id'])) {
            logger()->error('JobApplicationController: invalid service account JSON');
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['error' => 'service_account_invalid', 'message' => 'Server misconfiguration (invalid service account).'], 500);
            }
            return redirect()->back()->with('error', 'Server misconfiguration (invalid service account).');
        }

        $clientEmail = $sa['client_email'];
        $privateKey = $sa['private_key'];
        $projectId = $sa['project_id'];

        // Create JWT assertion for OAuth2
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

        try {
            $jwt = $this->createSignedJwt($assertion, $privateKey);
        } catch (\Throwable $e) {
            logger()->error('JobApplicationController: JWT encode failed: ' . $e->getMessage());
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['error' => 'jwt_sign_failed', 'message' => 'Server error creating auth token'], 500);
            }
            return redirect()->back()->with('error', 'Server error creating auth token');
        }

        // Exchange assertion for access token
        try {
            $resp = Http::asForm()->post($tokenUrl, [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $jwt,
            ]);
        } catch (\Throwable $e) {
            logger()->error('JobApplicationController: token request failed: ' . $e->getMessage());
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['error' => 'token_request_failed', 'message' => 'Server error requesting access token'], 500);
            }
            return redirect()->back()->with('error', 'Server error requesting access token');
        }

        if (!$resp->successful()) {
            logger()->error('JobApplicationController: token endpoint error: ' . $resp->body());
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['error' => 'token_endpoint_error', 'body' => $resp->body()], 500);
            }
            return redirect()->back()->with('error', 'Server error obtaining access token');
        }

        $tokenData = $resp->json();
        $accessToken = $tokenData['access_token'] ?? null;
        if (!$accessToken) {
            logger()->error('JobApplicationController: no access_token in response');
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['error' => 'no_access_token', 'message' => 'Server error obtaining access token'], 500);
            }
            return redirect()->back()->with('error', 'Server error obtaining access token');
        }

        // Prepare Firestore REST create document URL
        $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/applications";

        // Convert PHP array to Firestore fields
        $fields = $this->phpValueToFirestoreFields($data);

        $body = [
            'fields' => $fields,
        ];

        try {
            $writeResp = Http::withToken($accessToken)
                ->post($url, $body);
        } catch (\Throwable $e) {
            logger()->error('JobApplicationController: Firestore request failed: ' . $e->getMessage());
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['error' => 'firestore_request_failed', 'message' => $e->getMessage()], 500);
            }
            return redirect()->back()->with('error', 'Server error writing to Firestore');
        }

        if (!$writeResp->successful()) {
            $bodyText = $writeResp->body();
            logger()->error('JobApplicationController: Firestore API error: ' . $bodyText);
            // If permission error, surface a helpful message for debugging
            if (stripos($bodyText, 'permission') !== false || stripos($bodyText, 'PERMISSION_DENIED') !== false) {
                logger()->warning('JobApplicationController: permission error writing to Firestore. Check service account roles and Firestore rules.');
            }
            if ($request->wantsJson() || $request->isJson()) {
                return response()->json(['error' => 'firestore_api_error', 'body' => $bodyText], 500);
            }
            return redirect()->back()->with('error', 'Failed to submit application');
        }

        // On success, Firestore returns a document resource name like projects/{projectId}/databases/(default)/documents/applications/{docId}
        $respJson = $writeResp->json();
        $docName = $respJson['name'] ?? null;
        $docId = null;
        if ($docName) {
            $parts = explode('/', $docName);
            $docId = end($parts);
        }

        if ($request->wantsJson() || $request->isJson()) {
            return response()->json(['success' => true, 'id' => $docId, 'name' => $docName]);
        }

        return redirect()->route('job.application.submit')->with('success', 'Application submitted!');
    }

    // Convert PHP values to Firestore fields format
    private function phpValueToFirestoreFields($value)
    {
        // If associative array (object), map to mapValue
        if (is_array($value) && $this->isAssoc($value)) {
            return $this->phpArrayToFirestoreFieldsMap($value);
        }

        // Otherwise, treat as a single field named 'value'
        return ['value' => $this->phpValueToFirestoreField($value)];
    }

    private function phpValueToFirestoreField($v)
    {
        if (is_null($v)) return ['nullValue' => null];
        if (is_bool($v)) return ['booleanValue' => $v];
        if (is_int($v)) return ['integerValue' => (string)$v];
        if (is_float($v)) return ['doubleValue' => $v];
        if (is_array($v)) {
            // arrayValue with values
            $vals = [];
            // If associative, represent as mapValue
            if ($this->isAssoc($v)) {
                return ['mapValue' => ['fields' => $this->phpArrayToFirestoreFieldsMap($v)]];
            }
            foreach ($v as $item) {
                $vals[] = $this->phpValueToFirestoreField($item);
            }
            return ['arrayValue' => ['values' => $vals]];
        }
        // fallback to stringValue
        return ['stringValue' => (string)$v];
    }

    // Convert associative PHP array into Firestore fields map with sanitized keys
    private function phpArrayToFirestoreFieldsMap(array $arr): array
    {
        $map = [];
        foreach ($arr as $k => $v) {
            // sanitize keys to avoid problematic characters in Firestore field names
            $key = $this->sanitizeFirestoreFieldKey((string)$k);
            $map[$key] = $this->phpValueToFirestoreField($v);
        }
        return $map;
    }

    // Sanitize a string to use as a Firestore map field key: keep alphanumerics and underscores
    private function sanitizeFirestoreFieldKey(string $key): string
    {
        $k = trim($key);
        // replace sequences of non-alphanumeric/underscore characters with underscore
        $k = preg_replace('/[^A-Za-z0-9_]+/', '_', $k);
        // ensure it doesn't start with a digit (optional, but safer)
        if (preg_match('/^[0-9]/', $k)) {
            $k = '_' . $k;
        }
        return $k;
    }

    private function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
    
    // Create RS256-signed JWT without external libraries
    private function createSignedJwt(array $payload, string $privateKeyPem): string
    {
        $header = ['alg' => 'RS256', 'typ' => 'JWT'];
        $segments = [];
        $segments[] = $this->base64UrlEncode(json_encode($header));
        $segments[] = $this->base64UrlEncode(json_encode($payload));
        $signingInput = implode('.', $segments);

        $pkey = openssl_pkey_get_private($privateKeyPem);
        if ($pkey === false) {
            throw new \RuntimeException('Invalid private key for signing');
        }
        $signature = '';
        $ok = openssl_sign($signingInput, $signature, $pkey, OPENSSL_ALGO_SHA256);
        openssl_free_key($pkey);
        if (!$ok) {
            throw new \RuntimeException('OpenSSL signing failed');
        }
        $segments[] = $this->base64UrlEncode($signature);
        return implode('.', $segments);
    }

    private function base64UrlEncode(string $input): string
    {
        return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
    }

    // Helper: read the CSV and return a job array for given job id (numeric index or job_id column)
    private function getJobFromCsv($jobId)
    {
        // Prefer Laravel helper when available; fall back to project/public/postings.csv
        $csvPath = null;
        if (function_exists('public_path')) {
            try {
                $csvPath = public_path('postings.csv');
            } catch (\Throwable $e) {
                $csvPath = null;
            }
        }
        if (empty($csvPath)) {
            // controller is in app/Http/Controllers -> move up to project root
            $projectRoot = dirname(__DIR__, 3);
            $csvPath = $projectRoot . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'postings.csv';
        }
        if (!file_exists($csvPath)) return null;

        if (($handle = fopen($csvPath, 'r')) === false) return null;
        $headers = fgetcsv($handle);
        if (!$headers) { fclose($handle); return null; }

    $rows = [];
    while (($row = fgetcsv($handle)) !== false) $rows[] = $row;
        fclose($handle);

        // Attempt to find header named job_id
        $jobIdCol = null;
        foreach ($headers as $i => $h) {
            if (strtolower(trim($h)) === 'job_id') { $jobIdCol = $i; break; }
        }

        $rowFound = null;
        $rowIndex = null;
        foreach ($rows as $i => $r) {
            if ($jobIdCol !== null && isset($r[$jobIdCol]) && strval($r[$jobIdCol]) === strval($jobId)) { $rowFound = $r; $rowIndex = $i; break; }
            if (is_numeric($jobId) && intval($jobId) === $i) { $rowFound = $r; $rowIndex = $i; break; }
        }

        if (empty($rowFound)) return null;

        // Build a lookup map of lowercased header => column index. Guard if headers are malformed.
        $map = [];
        if (is_array($headers)) {
            $flipped = @array_flip($headers);
            if (is_array($flipped)) {
                $map = array_change_key_case($flipped);
            }
        }

        $get = function($names) use ($rowFound, $map) {
            foreach ((array)$names as $n) {
                $k = strtolower(trim($n));
                if (is_array($map) && array_key_exists($k, $map)) {
                    $idx = $map[$k];
                    if (is_array($rowFound) && array_key_exists($idx, $rowFound)) {
                        return $rowFound[$idx];
                    }
                }
            }
            return '';
        };

        // Build associative raw map of header->value
        $raw = [];
        foreach ($headers as $hi => $h) {
            $raw[$h] = (is_array($rowFound) && array_key_exists($hi, $rowFound)) ? $rowFound[$hi] : null;
        }

        return [
            'title' => $get(['title','jobtitle','job_title','position','job name']) ?: null,
            'company' => $get(['company','companyname','employer']) ?: null,
            'location' => $get(['location','address','city']) ?: null,
            'type' => $get(['type','jobtype','employment_type']) ?: null,
            'description' => $get(['jobdescription','job_requirment','job_requirement','description']) ?: null,
            'raw' => $raw,
            'row_index' => $rowIndex,
        ];
    }

    // Verify a Firebase ID token using Google's tokeninfo endpoint. Returns uid (sub) on success or null on failure.
    private function verifyFirebaseIdToken(string $idToken): ?string
    {
        try {
            $parts = explode('.', $idToken);
            if (count($parts) !== 3) return null;
            $b64Header = $parts[0];
            $b64Payload = $parts[1];
            $b64Sig = $parts[2];

            $header = json_decode($this->base64UrlDecode($b64Header), true) ?: [];
            $payload = json_decode($this->base64UrlDecode($b64Payload), true) ?: [];
            $kid = $header['kid'] ?? null;

            $svcPath = (getenv('FIREBASE_SERVICE_ACCOUNT') ?: '') ?: storage_path('app/firebase-service-account.json');
            $projectId = null;
            if (file_exists($svcPath)) {
                $j = json_decode(file_get_contents($svcPath), true);
                $projectId = $j['project_id'] ?? null;
            }

            // Try verifying signature with Google's certs if available
            $certsUrl = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';
            
            $certsRaw = @file_get_contents($certsUrl);
            if ($certsRaw !== false) {
                $certs = json_decode($certsRaw, true) ?: [];
                if ($kid && isset($certs[$kid])) {
                    $cert = $certs[$kid];
                    $sig = $this->base64UrlDecode($b64Sig);
                    $signed = $b64Header . '.' . $b64Payload;
                    $pub = openssl_pkey_get_public($cert);
                    if ($pub !== false) {
                        $ok = openssl_verify($signed, $sig, $pub, OPENSSL_ALGO_SHA256);
                        openssl_free_key($pub);
                    } else {
                        $ok = 0;
                    }
                    if ($ok === 1) {
                        $now = time();
                        if ($projectId && (!isset($payload['aud']) || $payload['aud'] !== $projectId)) {
                            logger()->warning('Firebase token aud mismatch');
                            return null;
                        }
                        if ($projectId && (!isset($payload['iss']) || $payload['iss'] !== 'https://securetoken.google.com/' . $projectId)) {
                            logger()->warning('Firebase token iss mismatch');
                            return null;
                        }
                        if (!isset($payload['sub']) || !is_string($payload['sub']) || $payload['sub'] === '') return null;
                        if (isset($payload['exp']) && $payload['exp'] < ($now - 5)) {
                            logger()->warning('Firebase token expired');
                            return null;
                        }
                        return $payload['sub'];
                    }
                }
            }

            // Fallback: tokeninfo endpoint
            $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken);
            $resp = @file_get_contents($url);
            if ($resp === false) return null;
            $data = json_decode($resp, true);
            if (empty($data) || empty($data['sub'])) return null;
            if ($projectId && !empty($data['aud']) && (string)$data['aud'] !== (string)$projectId && (string)$data['aud'] !== (string)(getenv('FIREBASE_API_KEY') ?: '')) {
                logger()->warning('Firebase token audience mismatch (fallback)');
                return null;
            }
            return $data['sub'] ?? null;
        } catch (\Throwable $e) {
            logger()->warning('verifyFirebaseIdToken failed: ' . $e->getMessage());
            return null;
        }
    }

    private function base64UrlDecode(string $input): string
    {
        $remainder = strlen($input) % 4;
        if ($remainder) {
            $padlen = 4 - $remainder;
            $input .= str_repeat('=', $padlen);
        }
        $safe = strtr($input, '-_', '+/');
        return base64_decode($safe);
    }

    // Obtain an OAuth2 access token using a service account private key (JWT assertion)
    private function getAccessTokenFromServiceAccount(string $clientEmail, string $privateKeyPem): string
    {
        $now = time();
        $tokenUrl = 'https://oauth2.googleapis.com/token';
        $scope = 'https://www.googleapis.com/auth/datastore https://www.googleapis.com/auth/cloud-platform';
        $jwtClaim = [
            'iss' => $clientEmail,
            'scope' => $scope,
            'aud' => $tokenUrl,
            'iat' => $now,
            'exp' => $now + 3600,
        ];
        $assertion = $this->createSignedJwt($jwtClaim, $privateKeyPem);
        $res = Http::asForm()->post($tokenUrl, [
            'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
            'assertion' => $assertion,
        ]);
        if (!$res->successful()) {
            throw new \RuntimeException('Token endpoint returned ' . $res->status() . ': ' . $res->body());
        }
        $json = $res->json();
        if (empty($json['access_token'])) throw new \RuntimeException('No access_token in response');
        return $json['access_token'];
    }
}

