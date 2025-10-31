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

    /**
     * List user documents under the 'users' collection and convert them to simple PHP arrays.
     * Returns an associative array uid => profileArray
     */
    public function listUsers(): array
    {
        try {
            if (!$this->projectId) return [];
            $access = $this->getAccessToken();
            if (!$access) return [];
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users";
            $resp = Http::withToken($access)->get($url, ['pageSize' => 1000]);
            if (!$resp->successful()) return [];
            $data = $resp->json();
            $out = [];
            if (!empty($data['documents']) && is_array($data['documents'])) {
                foreach ($data['documents'] as $doc) {
                    $name = $doc['name'] ?? '';
                    $parts = explode('/', $name);
                    $docId = end($parts);
                    $fields = $doc['fields'] ?? [];
                    $profile = [];
                    foreach ($fields as $k => $v) {
                        $profile[$k] = $this->convertFirestoreValue($v);
                    }
                    $out[$docId] = $profile;
                }
            }
            return $out;
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:listUsers failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Convert a Firestore value object to a PHP scalar/array.
     */
    private function convertFirestoreValue($v)
    {
        if (!is_array($v)) return $v;
        if (isset($v['stringValue'])) return $v['stringValue'];
        if (isset($v['booleanValue'])) return (bool)$v['booleanValue'];
        if (isset($v['integerValue'])) return is_numeric($v['integerValue']) ? (int)$v['integerValue'] : $v['integerValue'];
        if (isset($v['doubleValue'])) return is_numeric($v['doubleValue']) ? (float)$v['doubleValue'] : $v['doubleValue'];
        if (isset($v['timestampValue'])) return $v['timestampValue'];
        if (isset($v['arrayValue']) && isset($v['arrayValue']['values']) && is_array($v['arrayValue']['values'])) {
            $arr = [];
            foreach ($v['arrayValue']['values'] as $it) $arr[] = $this->convertFirestoreValue($it);
            return $arr;
        }
        if (isset($v['mapValue']) && isset($v['mapValue']['fields']) && is_array($v['mapValue']['fields'])) {
            $m = [];
            foreach ($v['mapValue']['fields'] as $kk => $vv) $m[$kk] = $this->convertFirestoreValue($vv);
            return $m;
        }
        // fallback: return raw
        return $v;
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

    /**
     * Get saved jobs array for a user (returns array of job ids as strings).
     */
    public function getSavedJobs(string $firebaseUid): array
    {
        try {
            if (!$this->projectId) return [];
            $access = $this->getAccessToken();
            if (!$access) return [];
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/saved_jobs/" . urlencode($firebaseUid);
            $resp = Http::withToken($access)->get($url);
            if (!$resp->successful()) return [];
            $doc = $resp->json();
            $fields = $doc['fields'] ?? [];
            if (isset($fields['saved_jobs']['arrayValue']['values']) && is_array($fields['saved_jobs']['arrayValue']['values'])) {
                $out = [];
                foreach ($fields['saved_jobs']['arrayValue']['values'] as $v) {
                    if (isset($v['stringValue'])) $out[] = $v['stringValue'];
                    elseif (isset($v['integerValue'])) $out[] = (string)$v['integerValue'];
                }
                return $out;
            }
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:getSavedJobs failed: ' . $e->getMessage());
        }
        return [];
    }

    /**
     * Get a single user document (converted) or null
     */
    public function getUser(string $firebaseUid): ?array
    {
        try {
            if (!$this->projectId) return null;
            $access = $this->getAccessToken();
            if (!$access) return null;
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/users/" . urlencode($firebaseUid);
            $resp = Http::withToken($access)->get($url);
            if (!$resp->successful()) return null;
            $doc = $resp->json();
            $fields = $doc['fields'] ?? [];
            $profile = [];
            foreach ($fields as $k => $v) {
                $profile[$k] = $this->convertFirestoreValue($v);
            }
            return $profile;
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:getUser failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * List job documents under the 'jobs' collection and convert them to arrays.
     * Returns associative array jobId => jobData
     */
    public function listJobs(): array
    {
        try {
            if (!$this->projectId) return [];
            $access = $this->getAccessToken();
            if (!$access) return [];
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/jobs";
            $resp = Http::withToken($access)->get($url, ['pageSize' => 1000]);
            if (!$resp->successful()) return [];
            $data = $resp->json();
            $out = [];
            if (!empty($data['documents']) && is_array($data['documents'])) {
                foreach ($data['documents'] as $doc) {
                    $name = $doc['name'] ?? '';
                    $parts = explode('/', $name);
                    $docId = end($parts);
                    $fields = $doc['fields'] ?? [];
                    $job = [];
                    foreach ($fields as $k => $v) $job[$k] = $this->convertFirestoreValue($v);
                    $out[$docId] = $job;
                }
            }
            return $out;
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:listJobs failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * List interaction documents (basic) and return a flat array of interaction arrays.
     * Note: This pulls up to pageSize items via the REST list endpoint; for larger datasets consider a paginated approach.
     */
    public function listInteractions(): array
    {
        try {
            if (!$this->projectId) return [];
            $access = $this->getAccessToken();
            if (!$access) return [];
            $url = "httpss://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/interactions";
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:listInteractions failed (build): ' . $e->getMessage());
            // fallback to a safe implementation below
        }

        try {
            if (!$this->projectId) return [];
            $access = $this->getAccessToken();
            if (!$access) return [];
            // Use the standard documents:list endpoint which exists for a collection path
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/interactions";
            $resp = Http::withToken($access)->get($url, ['pageSize' => 2000]);
            if (!$resp->successful()) return [];
            $data = $resp->json();
            $out = [];
            if (!empty($data['documents']) && is_array($data['documents'])) {
                foreach ($data['documents'] as $doc) {
                    $name = $doc['name'] ?? '';
                    $parts = explode('/', $name);
                    $docId = end($parts);
                    $fields = $doc['fields'] ?? [];
                    $it = ['id' => $docId];
                    foreach ($fields as $k => $v) $it[$k] = $this->convertFirestoreValue($v);
                    $out[] = $it;
                }
            }
            return $out;
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:listInteractions failed: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Set saved jobs array for a user. Overwrites previous list.
     */
    public function setSavedJobs(string $firebaseUid, array $jobIds): bool
    {
        try {
            if (!$this->projectId) return false;
            $access = $this->getAccessToken();
            if (!$access) return false;
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/saved_jobs/" . urlencode($firebaseUid) . '?updateMask.fieldPaths=saved_jobs';
            // Build arrayValue
            $vals = [];
            foreach ($jobIds as $j) {
                // store as stringValue
                $vals[] = ['stringValue' => (string)$j];
            }
            $body = ['fields' => ['saved_jobs' => ['arrayValue' => ['values' => $vals]]]];
            $resp = Http::withToken($access)->patch($url, $body);
            if ($resp->successful()) return true;
            // Try create (post) if patch failed
            $createUrl = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/saved_jobs?documentId=" . urlencode($firebaseUid);
            $createResp = Http::withToken($access)->post($createUrl, $body);
            return $createResp->successful();
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:setSavedJobs failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Upsert a job document under the 'jobs' collection.
     * $docId: desired document id (string). If null, Firestore will assign one when creating.
     * $jobData: associative array of key => value to store.
     */
    public function upsertJob(string $docId, array $jobData): bool
    {
        try {
            if (!$this->projectId) return false;
            $access = $this->getAccessToken();
            if (!$access) return false;

            // convert PHP array into Firestore fields structure
            $fields = $this->convertToFirestoreFields($jobData);
            $body = ['fields' => $fields];

            // Try patch (update) first
            $url = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/jobs/" . urlencode($docId);
            $resp = Http::withToken($access)->patch($url, $body);
            if ($resp->successful()) return true;

            // Fallback: create with documentId
            $createUrl = "https://firestore.googleapis.com/v1/projects/{$this->projectId}/databases/(default)/documents/jobs?documentId=" . urlencode($docId);
            $createResp = Http::withToken($access)->post($createUrl, $body);
            return $createResp->successful();
        } catch (\Throwable $e) {
            logger()->warning('FirestoreAdminService:upsertJob failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Helper: convert a PHP associative array into Firestore "fields" representation.
     */
    private function convertToFirestoreFields(array $data): array
    {
        $out = [];
        foreach ($data as $k => $v) {
            if (is_null($v)) continue;
            if (is_bool($v)) {
                $out[$k] = ['booleanValue' => $v];
            } elseif (is_int($v)) {
                $out[$k] = ['integerValue' => (string)$v];
            } elseif (is_float($v)) {
                $out[$k] = ['doubleValue' => $v];
            } elseif (is_array($v)) {
                // if numeric-indexed array, store as arrayValue of stringValues where possible
                $values = [];
                $isMap = array_values($v) !== $v;
                if ($isMap) {
                    // mapValue
                    $fields = [];
                    foreach ($v as $kk => $vv) {
                        // recurse for nested map
                        $fields[$kk] = $this->convertScalarToFirestoreValue($vv);
                    }
                    $out[$k] = ['mapValue' => ['fields' => $fields]];
                } else {
                    foreach ($v as $it) {
                        $values[] = $this->convertScalarToFirestoreValue($it);
                    }
                    $out[$k] = ['arrayValue' => ['values' => $values]];
                }
            } else {
                // default to stringValue
                $out[$k] = ['stringValue' => (string)$v];
            }
        }
        return $out;
    }

    private function convertScalarToFirestoreValue($v)
    {
        if (is_null($v)) return ['nullValue' => null];
        if (is_bool($v)) return ['booleanValue' => $v];
        if (is_int($v)) return ['integerValue' => (string)$v];
        if (is_float($v)) return ['doubleValue' => $v];
        if (is_array($v)) {
            // nested array -> map or list
            $isMap = array_values($v) !== $v;
            if ($isMap) {
                $fields = [];
                foreach ($v as $kk => $vv) $fields[$kk] = $this->convertScalarToFirestoreValue($vv);
                return ['mapValue' => ['fields' => $fields]];
            } else {
                $vals = [];
                foreach ($v as $it) $vals[] = $this->convertScalarToFirestoreValue($it);
                return ['arrayValue' => ['values' => $vals]];
            }
        }
        return ['stringValue' => (string)$v];
    }

    private function base64UrlEncode(string $input): string
    {
        return rtrim(strtr(base64_encode($input), '+/', '-_'), '=');
    }
}
