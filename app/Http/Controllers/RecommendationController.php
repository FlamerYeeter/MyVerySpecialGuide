<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use App\Jobs\GenerateRecommendations;

class RecommendationController extends Controller
{
    /**
     * Accept a Firestore-like profile JSON and return hybrid recommendations.
     * POST /api/recommendations/user
     */
    public function userRecommendations(Request $request)
    {
        $profile = $request->json()->all();
        // Attempt to resolve authenticated user: prefer Laravel session, then Firebase ID token
        $resolvedUid = null;
        try {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $u = \Illuminate\Support\Facades\Auth::user();
                if (!empty($u->firebase_uid)) $resolvedUid = (string)$u->firebase_uid;
            }
        } catch (\Throwable $__e) {}

        // If Authorization header present, try to verify ID token
        if (!$resolvedUid) {
            $authHeader = $request->header('Authorization', '') ?: $request->server('HTTP_AUTHORIZATION', '');
            $idToken = null;
            if ($authHeader && preg_match('/Bearer\s+(.*)$/i', $authHeader, $m)) $idToken = trim($m[1]);
            if (!$idToken) $idToken = (string)$request->input('idToken', '');
            if ($idToken) {
                try {
                    $verified = $this->verifyFirebaseIdToken($idToken);
                    if ($verified) $resolvedUid = $verified;
                } catch (\Throwable $__e) {
                    // verification failed
                    logger()->warning('recommendations: idToken verification failed: ' . $__e->getMessage());
                }
            }
        }

        // As a last resort, accept uid in payload only if we already resolved via session/token
        $payloadUid = $request->input('uid') ?? ($profile['uid'] ?? null);
        if ($payloadUid && $resolvedUid && (string)$payloadUid !== (string)$resolvedUid) {
            // mismatch between provided uid and authenticated uid
            return response()->json(['error' => 'uid_mismatch'], 403);
        }

        if ($resolvedUid) {
            $uid = $resolvedUid;
        } else {
            // no authenticated identity: reject (we require authenticated user to request per-user recs)
            return response()->json(['error' => 'unauthorized', 'message' => 'Missing or invalid Firebase idToken or Laravel session.'], 401);
        }

        // sanitize uid for file paths
        $safeUid = preg_replace('/[^A-Za-z0-9_\-]/', '_', $uid ?: 'anonymous');
        $cachePath = storage_path('app/reco_user_' . $safeUid . '.json');

        // TTL for cached results (seconds). If cached file is recent, return it immediately.
        $cacheTtl = 60 * 60; // 1 hour
        try {
            // If cache exists and is fresh, return immediately
            if (file_exists($cachePath) && (time() - filemtime($cachePath) < $cacheTtl)) {
                $raw = @file_get_contents($cachePath);
                $json = json_decode($raw, true);
                if ($json !== null) {
                    return response()->json($json);
                }
            }

            // If stale or missing cache: dispatch background job to generate recommendations
            // but return cached file immediately if present
            if (file_exists($cachePath)) {
                // return stale cache while job regenerates in background
                $raw = @file_get_contents($cachePath);
                $json = json_decode($raw, true);
                // dispatch the job asynchronously
                GenerateRecommendations::dispatch($uid, $profile);
                if ($json !== null) {
                    return response()->json($json);
                }
            }

            // No cache exists: dispatch job and return 202 Accepted with placeholder
            GenerateRecommendations::dispatch($uid, $profile);
            return response()->json(['status' => 'scheduled', 'message' => 'Recommendation generation scheduled.'], 202);
        } catch (\Exception $e) {
            Log::error('Recommendation exception: ' . $e->getMessage());
            return response()->json(['error' => 'exception', 'message' => $e->getMessage()], 500);
        }
    }

    // Verify a Firebase ID token using Google's certs or tokeninfo endpoint. Returns uid (sub) on success or null on failure.
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
            logger()->warning('recommendation verifyFirebaseIdToken failed: ' . $e->getMessage());
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
}
