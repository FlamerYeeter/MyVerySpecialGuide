<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class FirestoreAdminService
{
    protected $svcPath;
    protected $json;
    protected $projectId;

    public function __construct()
    {
        $this->svcPath = env('FIREBASE_SERVICE_ACCOUNT') ?: storage_path('app/firebase-service-account.json');
        if (file_exists($this->svcPath)) {
            $this->json = json_decode(file_get_contents($this->svcPath), true) ?: null;
            $this->projectId = $this->json['project_id'] ?? null;
        } else {
            $this->json = null;
            $this->projectId = null;
        }
    }

    protected function getAccessToken(): ?string
    {
        if (!$this->json || !$this->projectId) return null;
        try {
            $clientEmail = $this->json['client_email'] ?? null;
            $privateKey = $this->json['private_key'] ?? null;
            if (!$clientEmail || !$privateKey) return null;
            $now = time();
            $jwt = [
                'iss' => $clientEmail,
                'scope' => 'https://www.googleapis.com/auth/datastore',
                'aud' => 'https://oauth2.googleapis.com/token',
                'iat' => $now,
                'exp' => $now + 3600,
            ];
            $header = ['alg' => 'RS256', 'typ' => 'JWT'];
            $segments = [];
            $segments[] = $this->base64UrlEncode(json_encode($header));
            $segments[] = $this->base64UrlEncode(json_encode($jwt));
            $signingInput = implode('.', $segments);
            $pkey = openssl_pkey_get_private($privateKey);
            if ($pkey === false) return null;
            $signature = '';
            $ok = openssl_sign($signingInput, $signature, $pkey, OPENSSL_ALGO_SHA256);
            openssl_free_key($pkey);
            if (!$ok) return null;
            $segments[] = $this->base64UrlEncode($signature);
            $assertion = implode('.', $segments);
            $post = http_build_query([
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $assertion,
            ]);
            $opts = ['http' => ['method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'content' => $post, 'ignore_errors' => true]];
            $context = stream_context_create($opts);
            $resp = @file_get_contents('https://oauth2.googleapis.com/token', false, $context);
            if ($resp === false) return null;
            $data = json_decode($resp, true);
            return $data['access_token'] ?? null;
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:getAccessToken failed: ' . $e->getMessage());
            return null;
        }
    }

    public function isAdmin(string $firebaseUid): bool
    {
        try {
            if (!$this->projectId) return false;
            $access = $this->getAccessToken();
            if (!$access) return false;
            // First, check admin_assignments/{uid} collection (preferred)
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/admin_assignments/" . urlencode($firebaseUid);
            $resp = Http::withToken($access)->get($url);
            if ($resp->successful()) {
                $doc = $resp->json();
                $fields = $doc['fields'] ?? [];
                // optional boolean field 'active' default true
                $active = true;
                if (isset($fields['active']['booleanValue'])) $active = (bool)$fields['active']['booleanValue'];
                return $active;
            }

            // Fallback: some projects (like yours) store role on users/{uid} document.
            // Check users/{uid} and accept role === 'admin' as assignment.
            $userUrl = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users/" . urlencode($firebaseUid);
            $uResp = Http::withToken($access)->get($userUrl);
            if ($uResp->successful()) {
                $ud = $uResp->json();
                $ufields = $ud['fields'] ?? [];
                if (isset($ufields['role']['stringValue']) && strtolower($ufields['role']['stringValue']) === 'admin') {
                    return true;
                }
            }
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:isAdmin failed: ' . $e->getMessage());
        }
        return false;
    }

    public function listAssignments(): array
    {
        try {
            if (!$this->projectId) return [];
            $access = $this->getAccessToken();
            if (!$access) return [];
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/admin_assignments";
            $resp = Http::withToken($access)->get($url);
            if (!$resp->successful()) return [];
            $data = $resp->json();
            $out = [];
            if (!empty($data['documents']) && is_array($data['documents'])) {
                foreach ($data['documents'] as $doc) {
                    $name = $doc['name'] ?? '';
                    $parts = explode('/', $name);
                    $docId = end($parts);
                    $fields = $doc['fields'] ?? [];
                    $out[] = [
                        'docId' => $docId,
                        'firebase_uid' => $fields['firebase_uid']['stringValue'] ?? $docId,
                        'email' => $fields['email']['stringValue'] ?? null,
                        'assigned_by' => $fields['assigned_by']['stringValue'] ?? null,
                        'assigned_at' => $fields['assigned_at']['timestampValue'] ?? null,
                        'active' => isset($fields['active']['booleanValue']) ? (bool)$fields['active']['booleanValue'] : true,
                    ];
                }
            }
            return $out;
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:listAssignments failed: ' . $e->getMessage());
            return [];
        }
    }

    public function assign(string $firebaseUid, ?string $email = null, string $assignedBy = ''): bool
    {
        try {
            if (!$this->projectId) return false;
            $access = $this->getAccessToken();
            if (!$access) return false;
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/admin_assignments/" . urlencode($firebaseUid);
            $body = [
                'fields' => [
                    'firebase_uid' => ['stringValue' => $firebaseUid],
                    'email' => ['stringValue' => ($email ?? '')],
                    'assigned_by' => ['stringValue' => $assignedBy],
                    'assigned_at' => ['timestampValue' => now()->toIso8601String()],
                    'active' => ['booleanValue' => true],
                ],
            ];
            $resp = Http::withToken($access)->patch($url, $body);
            if ($resp->successful()) return true;
            // fallback to create
            $createUrl = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/admin_assignments?documentId=" . urlencode($firebaseUid);
            $createResp = Http::withToken($access)->post($createUrl, $body);
            return $createResp->successful();
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:assign failed: ' . $e->getMessage());
            return false;
        }
    }

    public function revoke(string $firebaseUid, string $revokedBy = ''): bool
    {
        try {
            if (!$this->projectId) return false;
            $access = $this->getAccessToken();
            if (!$access) return false;
            // we will mark active = false and set revoked_by/revoked_at
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/admin_assignments/" . urlencode($firebaseUid) . '?updateMask.fieldPaths=active&updateMask.fieldPaths=revoked_by&updateMask.fieldPaths=revoked_at';
            $body = [
                'fields' => [
                    'active' => ['booleanValue' => false],
                    'revoked_by' => ['stringValue' => $revokedBy],
                    'revoked_at' => ['timestampValue' => now()->toIso8601String()],
                ],
            ];
            $resp = Http::withToken($access)->patch($url, $body);
            return $resp->successful();
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:revoke failed: ' . $e->getMessage());
            return false;
        }
    }

    private function base64UrlEncode(string $input): string
    {
        return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
    }
}
