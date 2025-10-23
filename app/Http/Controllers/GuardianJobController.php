<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;

class GuardianJobController extends Controller
{
    // Return the approvals map (for guardian UI). If ?uid= is provided, attempt to read from Firestore
    public function list(Request $request)
    {
        $uid = $request->query('uid');
        // try Firestore if uid is provided and service account exists
        if ($uid) {
            $fs = $this->fetchApprovalsFromFirestore($uid);
            if (is_array($fs)) {
                return response()->json(['success' => true, 'approvals' => $fs]);
            }
            // otherwise fall through to local file
        }

        $path = storage_path('app/guardian_job_approvals.json');
        $data = [];
        if (file_exists($path)) {
            $json = file_get_contents($path);
            $data = json_decode($json, true) ?: [];
        }
        return response()->json(['success' => true, 'approvals' => $data]);
    }

    // Approve a job by id (job_id or dataIndex). Stores feedback and metadata.
    public function approve(Request $request, $jobId)
    {
        return $this->setStatus($request, $jobId, 'approved');
    }

    // Flag a job as not suitable
    public function flag(Request $request, $jobId)
    {
        return $this->setStatus($request, $jobId, 'flagged');
    }

    private function setStatus(Request $request, $jobId, $status)
    {
        $key = (string)$jobId;
        $feedback = (string)$request->input('feedback', '');
        $aid = \Illuminate\Support\Facades\Auth::id();
        $actionedBy = $aid ? (string)$aid : '';
        $actionedAt = now()->toIso8601String();

        // Try to verify Firebase ID token if provided (Authorization: Bearer <idToken> or idToken param)
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
                if ($firebaseUid) {
                    // prefer Firebase identity when present
                    $actionedBy = 'firebase:' . $firebaseUid;
                }
            }
        } catch (\Throwable $e) {
            logger()->warning('Firebase token verify failed: ' . $e->getMessage());
        }

        // target user uid: prefer explicit 'uid' param, otherwise prefer firebase uid
        $targetUid = $request->input('uid');
        if (empty($targetUid) && !empty($firebaseUid)) {
            $targetUid = $firebaseUid;
        }

        // Authorization: require either a Laravel session auth OR a valid Firebase idToken
        if (empty($aid) && empty($firebaseUid)) {
            // no server session and no valid firebase identity
            return response()->json(['success' => false, 'error' => 'unauthorized', 'message' => 'Authentication required (Laravel session or Firebase idToken).'], 401);
        }

        // Attempt to write to Firestore under users/{uid}/guardian_approvals/{jobId}
        $written = false;
        try {
            $svcPath = env('FIREBASE_SERVICE_ACCOUNT') ?: storage_path('app/firebase-service-account.json');
            if (file_exists($svcPath)) {
                $json = json_decode(file_get_contents($svcPath), true);
                $projectId = $json['project_id'] ?? null;
                if ($projectId) {
                    $access = $this->getServiceAccessTokenForScope($json, 'https://www.googleapis.com/auth/datastore');
                    if ($access) {
                        // create or overwrite document in collection users/{uid}/guardian_approvals with documentId = jobId
                        $docUrl = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users/{$targetUid}/guardian_approvals/" . urlencode($key);
                        $body = [
                            'fields' => [
                                'status' => ['stringValue' => $status],
                                'feedback' => ['stringValue' => $feedback],
                                'actioned_by' => ['stringValue' => $actionedBy],
                                'actioned_at' => ['timestampValue' => $actionedAt],
                            ],
                        ];

                        // Try to write with PATCH which will create or update the document
                        $resp = Http::withToken($access)->patch($docUrl, $body);
                        if ($resp->successful()) {
                            $written = true;
                            $doc = $resp->json();
                            // Mirror to local JSON file so server-side pages that read the local map
                            // (backwards compatibility) see the approval immediately.
                            try {
                                $pathLocal = storage_path('app/guardian_job_approvals.json');
                                $mapLocal = [];
                                if (file_exists($pathLocal)) $mapLocal = json_decode(file_get_contents($pathLocal), true) ?: [];
                                $mapLocal[$key] = [
                                    'status' => $status,
                                    'feedback' => $feedback,
                                    'actioned_by' => $actionedBy,
                                    'actioned_at' => $actionedAt,
                                    'source' => 'firestore',
                                ];
                                @file_put_contents($pathLocal, json_encode($mapLocal, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                            } catch (\Throwable $__e) {
                                logger()->warning('Failed to mirror firestore approval to local file: ' . $__e->getMessage());
                            }

                            return response()->json(['success' => true, 'approval' => [
                                'status' => $status,
                                'feedback' => $feedback,
                                'actioned_by' => $actionedBy,
                                'actioned_at' => $actionedAt,
                                'source' => 'firestore',
                                'document' => $doc,
                            ]]);
                        }

                        // If PATCH failed, attempt create via documents endpoint (documentId param)
                        $createUrl = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users/{$targetUid}/guardian_approvals?documentId=" . urlencode($key);
                        $createResp = Http::withToken($access)->post($createUrl, $body);
                        if ($createResp->successful()) {
                            $written = true;
                            $doc = $createResp->json();
                                try {
                                    $pathLocal = storage_path('app/guardian_job_approvals.json');
                                    $mapLocal = [];
                                    if (file_exists($pathLocal)) $mapLocal = json_decode(file_get_contents($pathLocal), true) ?: [];
                                    $mapLocal[$key] = [
                                        'status' => $status,
                                        'feedback' => $feedback,
                                        'actioned_by' => $actionedBy,
                                        'actioned_at' => $actionedAt,
                                        'source' => 'firestore',
                                    ];
                                    @file_put_contents($pathLocal, json_encode($mapLocal, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
                                } catch (\Throwable $__e) {
                                    logger()->warning('Failed to mirror firestore approval to local file: ' . $__e->getMessage());
                                }

                                return response()->json(['success' => true, 'approval' => [
                                    'status' => $status,
                                    'feedback' => $feedback,
                                    'actioned_by' => $actionedBy,
                                    'actioned_at' => $actionedAt,
                                    'source' => 'firestore',
                                    'document' => $doc,
                                ]]);
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // fall back to file
            logger()->warning('Firestore write failed: ' . $e->getMessage());
        }

        // Fallback: write to local JSON map (backwards compatible)
        $path = storage_path('app/guardian_job_approvals.json');
        $map = [];
        if (file_exists($path)) {
            $map = json_decode(file_get_contents($path), true) ?: [];
        }
        $map[$key] = [
            'status' => $status,
            'feedback' => $feedback,
            'actioned_by' => $actionedBy,
            'actioned_at' => $actionedAt,
        ];
        try {
            file_put_contents($path, json_encode($map, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (\Throwable $e) {
            return response()->json(['error' => 'write_failed', 'message' => $e->getMessage()], 500);
        }
        return response()->json(['success' => true, 'approval' => $map[$key], 'source' => 'local']);
    }

    // Verify a Firebase ID token using Google's tokeninfo endpoint. Returns uid (sub) on success or null on failure.
    private function verifyFirebaseIdToken(string $idToken): ?string
    {
        try {
            // First try to validate token signature + claims using Google's certs
            // Parse JWT
            $parts = explode('.', $idToken);
            if (count($parts) !== 3) return null;
            $b64Header = $parts[0];
            $b64Payload = $parts[1];
            $b64Sig = $parts[2];

            $header = json_decode($this->base64UrlDecode($b64Header), true) ?: [];
            $payload = json_decode($this->base64UrlDecode($b64Payload), true) ?: [];
            $kid = isset($header['kid']) ? $header['kid'] : null;

            // Need project id to validate audience/issuer
            $svcPath = env('FIREBASE_SERVICE_ACCOUNT') ?: storage_path('app/firebase-service-account.json');
            $projectId = null;
            if (file_exists($svcPath)) {
                $j = json_decode(file_get_contents($svcPath), true);
                $projectId = $j['project_id'] ?? null;
            }

            // Fetch Google's securetoken certs (maps kid -> PEM cert)
            $certsUrl = 'https://www.googleapis.com/robot/v1/metadata/x509/securetoken@system.gserviceaccount.com';
            $certsRaw = @file_get_contents($certsUrl);
            if ($certsRaw !== false) {
                $certs = json_decode($certsRaw, true) ?: [];
                if ($kid && isset($certs[$kid])) {
                    $cert = $certs[$kid];
                    // verify signature using the public key extracted from cert
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
                        // verify claims
                        $now = time();
                        // Issuer must be https://securetoken.google.com/{projectId}
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
                        // token valid
                        return $payload['sub'];
                    }
                }
            }

            // Fallback: tokeninfo endpoint (less ideal but works in many cases)
            $url = 'https://oauth2.googleapis.com/tokeninfo?id_token=' . urlencode($idToken);
            $resp = @file_get_contents($url);
            if ($resp === false) return null;
            $data = json_decode($resp, true);
            if (empty($data) || empty($data['sub'])) return null;
            // optional: check audience matches project id or FIREBASE_API_KEY
            if ($projectId && !empty($data['aud']) && (string)$data['aud'] !== (string)$projectId && (string)$data['aud'] !== (string)env('FIREBASE_API_KEY')) {
                logger()->warning('Firebase token audience mismatch (fallback)');
                return null;
            }
            return $data['sub'] ?? null;
        } catch (\Throwable $e) {
            logger()->warning('verifyFirebaseIdToken failed: ' . $e->getMessage());
            return null;
        }
    }

    // Fetch approvals for a given Firebase uid from Firestore; returns associative map or null on failure
    public function fetchApprovalsFromFirestore(string $uid): ?array
    {
        try {
            $svcPath = env('FIREBASE_SERVICE_ACCOUNT') ?: storage_path('app/firebase-service-account.json');
            if (!file_exists($svcPath)) return null;
            $json = json_decode(file_get_contents($svcPath), true);
            $projectId = $json['project_id'] ?? null;
            if (!$projectId) return null;
            $access = $this->getServiceAccessTokenForScope($json, 'https://www.googleapis.com/auth/datastore');
            if (!$access) return null;
            $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users/{$uid}/guardian_approvals";
            $resp = Http::withToken($access)->get($url);
            if (!$resp->successful()) return null;
            $data = $resp->json();
            $map = [];
            if (!empty($data['documents']) && is_array($data['documents'])) {
                foreach ($data['documents'] as $doc) {
                    // document name ends with the documentId
                    $name = $doc['name'] ?? '';
                    $parts = explode('/', $name);
                    $docId = end($parts);
                    $fields = $doc['fields'] ?? [];
                    $map[$docId] = [
                        'status' => $fields['status']['stringValue'] ?? '',
                        'feedback' => $fields['feedback']['stringValue'] ?? '',
                        'actioned_by' => $fields['actioned_by']['stringValue'] ?? '',
                        'actioned_at' => $fields['actioned_at']['timestampValue'] ?? '',
                    ];
                }
            }
            return $map;
        } catch (\Throwable $e) {
            logger()->warning('fetchApprovalsFromFirestore failed: ' . $e->getMessage());
            return null;
        }
    }

    // Exchange service-account credentials for an access token with the requested scope
    private function getServiceAccessTokenForScope(array $serviceAccountJson, string $scope): ?string
    {
        try {
            $clientEmail = $serviceAccountJson['client_email'] ?? null;
            $privateKey = $serviceAccountJson['private_key'] ?? null;
            if (!$clientEmail || !$privateKey) return null;
            $now = time();
            $jwt = [
                'iss' => $clientEmail,
                'scope' => $scope,
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ];
            $assertion = $this->createSignedJwt($jwt, $privateKey);
            $post = http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $assertion,
            ]);
            $opts = [
                'http' => [
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                    'content' => $post,
                    'ignore_errors' => true,
                ],
            ];
            $context = stream_context_create($opts);
            $resp = @file_get_contents('https://oauth2.googleapis.com/token', false, $context);
            if ($resp === false) return null;
            $data = json_decode($resp, true);
            return $data['access_token'] ?? null;
        } catch (\Throwable $e) {
            logger()->warning('getServiceAccessTokenForScope error: ' . $e->getMessage());
            return null;
        }
    }

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
}
