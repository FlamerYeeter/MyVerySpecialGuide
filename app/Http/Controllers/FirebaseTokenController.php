<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

// We'll use firebase/php-jwt to create RS256-signed JWTs from the service account
use Firebase\JWT\JWT;

class FirebaseTokenController extends Controller
{
    /**
     * Return a Firebase custom token for the current authenticated Laravel user.
     * This implementation uses firebase/php-jwt (lightweight) and a service
     * account JSON file (private_key + client_email).
     *
     * Install: composer require firebase/php-jwt
     */
    public function token(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'unauthenticated'], 401);
        }

        $serviceAccountPath = env('FIREBASE_SERVICE_ACCOUNT') ?: storage_path('app/firebase-service-account.json');
        if (!file_exists($serviceAccountPath)) {
            // Don't return 500 which the client will display as an error; instead
            // return OK with token=null so the client can gracefully continue
            logger()->warning('FirebaseTokenController: service account file missing: ' . $serviceAccountPath);
            return response()->json(['token' => null, 'error' => 'service_account_missing'], 200);
        }

        $json = json_decode(file_get_contents($serviceAccountPath), true);
        if (!$json || empty($json['client_email']) || empty($json['private_key'])) {
            logger()->warning('FirebaseTokenController: invalid service account JSON');
            return response()->json(['token' => null, 'error' => 'invalid_service_account'], 200);
        }

    $clientEmail = $json['client_email'];
    $privateKey = $json['private_key'];
    $projectId = $json['project_id'] ?? null;
        $now = time();

        // Try to find an existing Firebase user by email so we sign in the same account
        $firebaseUid = null;
        try {
            if (!empty($projectId)) {
                $accessToken = $this->getServiceAccessToken($json);
                if ($accessToken) {
                    $lookupUrl = "https://identitytoolkit.googleapis.com/v1/projects/{$projectId}/accounts:lookup";
                    $opts = [
                        'http' => [
                            'method' => 'POST',
                            'header' => "Content-Type: application/json\r\n" . "Authorization: Bearer {$accessToken}\r\n",
                            'content' => json_encode(['email' => [$user->email]]),
                            'ignore_errors' => true,
                        ],
                    ];
                    $context = stream_context_create($opts);
                    $resp = @file_get_contents($lookupUrl, false, $context);
                    if ($resp !== false) {
                        $data = json_decode($resp, true);
                        if (!empty($data['users']) && is_array($data['users'])) {
                            $first = $data['users'][0];
                            if (!empty($first['localId'])) {
                                $firebaseUid = $first['localId'];
                            }
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            logger()->warning('FirebaseTokenController: lookup by email failed: ' . $e->getMessage());
        }

        // If we didn't find an existing Firebase UID, fall back to a Laravel-scoped UID
        if (empty($firebaseUid)) {
            $firebaseUid = 'laravel:' . $user->id;
        }

        // Build custom token payload per Firebase custom token spec
        $payload = [
            'iss' => $clientEmail,
            'sub' => $clientEmail,
            'aud' => 'https://identitytoolkit.googleapis.com/google.identity.identitytoolkit.v1.IdentityToolkit',
            'iat' => $now,
            'exp' => $now + 3600,
            // The uid field is required by Firebase for custom tokens
            'uid' => $firebaseUid,
        ];

        try {
            $customToken = $this->createSignedJwt($payload, $privateKey);
            return response()->json(['token' => $customToken]);
        } catch (\Throwable $e) {
            logger()->error('FirebaseTokenController: failed to create custom token: ' . $e->getMessage());
            return response()->json(['error' => 'token_creation_failed'], 500);
        }
    }

    // Exchange a service-account-signed JWT for an OAuth2 access_token usable with admin APIs
    private function getServiceAccessToken(array $serviceAccountJson): ?string
    {
        $clientEmail = $serviceAccountJson['client_email'] ?? null;
        $privateKey = $serviceAccountJson['private_key'] ?? null;
        if (!$clientEmail || !$privateKey) return null;

        $now = time();
        $scope = 'https://www.googleapis.com/auth/identitytoolkit';
        $jwtPayload = [
            'iss' => $clientEmail,
            'scope' => $scope,
            'aud' => 'https://oauth2.googleapis.com/token',
            'iat' => $now,
            'exp' => $now + 3600,
        ];

        try {
            $assertion = $this->createSignedJwt($jwtPayload, $privateKey);
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
            logger()->warning('FirebaseTokenController: getServiceAccessToken failed: ' . $e->getMessage());
            return null;
        }
    }

    // Create an RS256-signed JWT using OpenSSL and a PEM private key (no external libs).
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
}
