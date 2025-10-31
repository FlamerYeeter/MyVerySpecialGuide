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

        // If Laravel session contains firebase_uid, use it (helps when Auth::user() lacks the field)
        if (!$resolvedUid) {
            try {
                $sessUid = session('firebase_uid', null);
                if (!empty($sessUid)) {
                    $resolvedUid = (string)$sessUid;
                    Log::info('recommendations: resolved uid from session firebase_uid=' . substr($resolvedUid,0,8) . '...');
                }
            } catch (\Throwable $_se) {}
        }

        // Development convenience: when running locally, allow the client-provided uid to be
        // accepted if no Laravel session or ID token was available. This lets the local dev
        // client post a profile.uid and still get per-user recs without a full auth flow.
        if (!$resolvedUid && app()->environment('local') && $payloadUid) {
            Log::info('recommendations: local dev fallback - using payload uid=' . $payloadUid);
            $resolvedUid = $payloadUid;
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
    $debugUsersPath = storage_path('app/reco_debug_users_' . $safeUid . '.json');
    $debugOutPath = storage_path('app/reco_debug_out_' . $safeUid . '.log');
    $debugParsedPath = storage_path('app/reco_debug_parsed_' . $safeUid . '.json');

    Log::info('recommendations: request for uid=' . $uid . ' cachePath=' . $cachePath);

    // Helper to extract a per-user recommendation array from multiple possible shapes:
    // - mapping keyed by original uid
    // - mapping keyed by safeUid
    // - direct numeric array
    // - mapping containing an array-valued entry (pick first)
    $extractPerUser = function($maybe) use ($uid, $safeUid) {
        if (!is_array($maybe)) return null;
        if (array_key_exists($uid, $maybe)) return $maybe[$uid];
        if (array_key_exists($safeUid, $maybe)) return $maybe[$safeUid];
        // direct sequential array
        if (array_values($maybe) === $maybe) return $maybe;
        // mapping with nested arrays: prefer first array-valued entry
        foreach ($maybe as $k => $v) {
            if (is_array($v) && array_values($v) === $v) return $v;
        }
        return null;
    };

        // TTL for cached results (seconds). If cached file is recent, return it immediately.
        $cacheTtl = 60 * 60; // 1 hour

        // honor a 'force' flag in the request to force regeneration for this uid (dev-friendly)
        $force = $request->input('force') ? true : false;
    // placeholder for synchronous run result
    $result = null;
        $debug = $request->input('debug') ? true : false;

        if ($force) {
            Log::info('recommendations: force regeneration requested for uid=' . $uid);
            try {
                // Run synchronously to produce an updated cache immediately (safe in dev/sync queue)
                $job = new GenerateRecommendations($uid, $profile);
                $result = $job->runAndReturn();
                if ($result !== null) {
                    // Generator may return either a mapping keyed by uid or a direct array for this user.
                    if (is_array($result)) {
                        if (array_key_exists($uid, $result)) {
                            $out = $result[$uid];
                            if ($debug && app()->environment('local')) {
                                return response()->json(['data' => $out, 'debug' => ['users_json' => @file_get_contents($debugUsersPath), 'python_log' => @file_get_contents($debugOutPath), 'parsed' => @file_get_contents($debugParsedPath)]]);
                            }
                            return response()->json($out);
                        }
                        // direct list returned for this user
                        if (array_values($result) === $result) {
                            $out = $result;
                            if ($debug && app()->environment('local')) {
                                return response()->json(['data' => $out, 'debug' => ['users_json' => @file_get_contents($debugUsersPath), 'python_log' => @file_get_contents($debugOutPath), 'parsed' => @file_get_contents($debugParsedPath)]]);
                            }
                            return response()->json($out);
                        }
                        // mapping with nested arrays? try to pick the first array-valued entry
                        foreach ($result as $k => $v) {
                            if (is_array($v) && array_values($v) === $v) {
                                $out = $v;
                                if ($debug && app()->environment('local')) {
                                    return response()->json(['data' => $out, 'debug' => ['users_json' => @file_get_contents($debugUsersPath), 'python_log' => @file_get_contents($debugOutPath), 'parsed' => @file_get_contents($debugParsedPath)]]);
                                }
                                return response()->json($out);
                            }
                        }
                    }
                    // Generator produced no per-user payload we could detect
                    Log::info('recommendations: generator returned no per-uid entry on force run for ' . $uid);
                    return response()->json(['error' => 'no_per_user_results', 'message' => 'Generator produced no per-user results for this uid.'], 404);
                }
                // small sleep to allow file write on slower filesystems (harmless)
                usleep(150000);
            } catch (\Throwable $e) {
                Log::warning('GenerateRecommendations force run failed: ' . $e->getMessage());
            }
        }
        try {
            // If cache exists and is fresh, return immediately
            if (file_exists($cachePath) && (time() - filemtime($cachePath) < $cacheTtl)) {
                // log which cache file is being used (helpful for multi-user debugging)
                try {
                    Log::info('recommendations: using fresh cache', ['cachePath' => $cachePath, 'mtime' => @filemtime($cachePath), 'size' => @filesize($cachePath)]);
                } catch (\Throwable $_log_e) {}
                $raw = @file_get_contents($cachePath);
                $json = json_decode($raw, true);
                    if ($json !== null) {
                        $out = $extractPerUser($json);
                        if ($out !== null) {
                            Log::info('recommendations: returning cached per-uid results for ' . $uid, ['cachePath' => $cachePath]);
                            return response()->json($out);
                        }
                        // fall through to regeneration logic below
                        Log::info('recommendations: cache present but no per-uid entry; skipping global return for ' . $uid, ['cachePath' => $cachePath]);
                    }
            }

            // If stale or missing cache: dispatch background job to generate recommendations
            // but return cached file immediately if present
            if (file_exists($cachePath)) {
                // return stale cache while job regenerates in background
                try {
                    Log::info('recommendations: using stale cache (will dispatch regenerate)', ['cachePath' => $cachePath, 'mtime' => @filemtime($cachePath)]);
                } catch (\Throwable $_le) {}
                $raw = @file_get_contents($cachePath);
                $json = json_decode($raw, true);
                // dispatch the job asynchronously to regenerate per-user output
                GenerateRecommendations::dispatch($uid, $profile);
                    if ($json !== null) {
                        $out = $extractPerUser($json);
                        if ($out !== null) {
                            Log::info('recommendations: returning stale per-uid cache for ' . $uid, ['cachePath' => $cachePath]);
                            return response()->json($out);
                        }
                        // do NOT return stale global JSON; instead allow regeneration to proceed
                        Log::info('recommendations: stale cache present but no per-uid entry; skipping global return for ' . $uid, ['cachePath' => $cachePath]);
                    }
            }

            // No cache exists: dispatch job. In local/dev or when queue driver is 'sync', run it synchronously
            try { Log::info('recommendations: no cache found, dispatching job for uid=' . $uid, ['expectedCachePath' => $cachePath]); } catch (\Throwable $__l) {}
            GenerateRecommendations::dispatch($uid, $profile);

            try {
                $queueDriver = config('queue.default');
            } catch (\Throwable $_e) { $queueDriver = null; }

            // If using sync queue or in local environment, run the job inline so results are immediately available for dev/testing.
            if ($queueDriver === 'sync' || app()->environment('local')) {
                try {
                    // Run synchronously (safe for dev). Use runAndReturn to get JSON directly.
                    $job = new GenerateRecommendations($uid, $profile);
                    $result = $job->runAndReturn();
                        if ($result !== null) {
                            if (is_array($result)) {
                                if (array_key_exists($uid, $result)) {
                                    $out = $result[$uid];
                                    if ($debug && app()->environment('local')) {
                                        return response()->json(['data' => $out, 'debug' => ['users_json' => @file_get_contents($debugUsersPath), 'python_log' => @file_get_contents($debugOutPath), 'parsed' => @file_get_contents($debugParsedPath)]]);
                                    }
                                    Log::info('recommendations: returning sync-generated per-uid results for ' . $uid);
                                    return response()->json($out);
                                }
                                if (array_values($result) === $result) {
                                    $out = $result;
                                    if ($debug && app()->environment('local')) {
                                        return response()->json(['data' => $out, 'debug' => ['users_json' => @file_get_contents($debugUsersPath), 'python_log' => @file_get_contents($debugOutPath), 'parsed' => @file_get_contents($debugParsedPath)]]);
                                    }
                                    Log::info('recommendations: returning sync-generated per-uid results (direct array) for ' . $uid);
                                    return response()->json($out);
                                }
                                foreach ($result as $k => $v) {
                                    if (is_array($v) && array_values($v) === $v) {
                                        $out = $v;
                                        if ($debug && app()->environment('local')) {
                                            return response()->json(['data' => $out, 'debug' => ['users_json' => @file_get_contents($debugUsersPath), 'python_log' => @file_get_contents($debugOutPath), 'parsed' => @file_get_contents($debugParsedPath)]]);
                                        }
                                        Log::info('recommendations: returning sync-generated per-uid results (found array in mapping) for ' . $uid, ['foundKey' => $k]);
                                        return response()->json($out);
                                    }
                                }
                            }
                            Log::info('recommendations: sync-generated result had no per-uid entry for ' . $uid);
                            return response()->json(['error' => 'no_per_user_results', 'message' => 'Generator produced no per-user results for this uid.'], 404);
                        }
                } catch (\Throwable $e) {
                    Log::warning('GenerateRecommendations sync run failed: ' . $e->getMessage());
                }
            }
            // As a last resort: if cache does not exist yet (queue running in background), attempt a synchronous generation
            // This is a fallback to help dev/testing so users see per-user recommendations immediately.
            try {
                Log::info('recommendations: attempting synchronous fallback generation for uid=' . $uid);
                $job = new GenerateRecommendations($uid, $profile);
                $result = $job->runAndReturn();
                    if ($result !== null) {
                        if (is_array($result)) {
                            if (array_key_exists($uid, $result)) {
                                $out = $result[$uid];
                                if ($debug && app()->environment('local')) {
                                    return response()->json(['data' => $out, 'debug' => ['users_json' => @file_get_contents($debugUsersPath), 'python_log' => @file_get_contents($debugOutPath), 'parsed' => @file_get_contents($debugParsedPath)]]);
                                }
                                Log::info('recommendations: returning fallback-generated per-uid results for ' . $uid);
                                return response()->json($out);
                            }
                            if (array_values($result) === $result) {
                                $out = $result;
                                if ($debug && app()->environment('local')) {
                                    return response()->json(['data' => $out, 'debug' => ['users_json' => @file_get_contents($debugUsersPath), 'python_log' => @file_get_contents($debugOutPath), 'parsed' => @file_get_contents($debugParsedPath)]]);
                                }
                                Log::info('recommendations: returning fallback-generated per-uid results (direct array) for ' . $uid);
                                return response()->json($out);
                            }
                            foreach ($result as $k => $v) {
                                if (is_array($v) && array_values($v) === $v) {
                                    $out = $v;
                                    if ($debug && app()->environment('local')) {
                                        return response()->json(['data' => $out, 'debug' => ['users_json' => @file_get_contents($debugUsersPath), 'python_log' => @file_get_contents($debugOutPath), 'parsed' => @file_get_contents($debugParsedPath)]]);
                                    }
                                    Log::info('recommendations: returning fallback-generated per-uid results (found array in mapping) for ' . $uid, ['foundKey' => $k]);
                                    return response()->json($out);
                                }
                            }
                        }
                        Log::info('recommendations: fallback generation produced no per-uid entry for ' . $uid);
                        return response()->json(['error' => 'no_per_user_results', 'message' => 'Generator produced no per-user results for this uid.'], 404);
                    }
            } catch (\Throwable $_e) {
                Log::warning('recommendations: synchronous fallback failed: ' . $_e->getMessage());
            }

            return response()->json(['status' => 'scheduled', 'message' => 'Recommendation generation scheduled.'], 202);
        } catch (\Exception $e) {
            Log::error('Recommendation exception: ' . $e->getMessage());
            return response()->json(['error' => 'exception', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Trigger bulk generation for all users. Restricted to local environment or loopback requests.
     * POST /api/recommendations/all
     */
    public function generateAll(Request $request)
    {
        try {
            // Restrict this endpoint to local dev or loopback callers to avoid abuse
            $allowed = app()->environment('local') || in_array($request->ip(), ['127.0.0.1', '::1', 'localhost']);
            if (!$allowed) {
                return response()->json(['error' => 'forbidden'], 403);
            }

            // Run bulk generator synchronously (dev-friendly). It will write per-uid cache files.
            $result = \App\Jobs\GenerateRecommendations::runForAllUsers();
            if ($result === null) {
                return response()->json(['status' => 'failed', 'message' => 'bulk generation failed or produced no output'], 500);
            }
            return response()->json(['status' => 'ok', 'users' => array_keys($result)]);
        } catch (\Throwable $e) {
            logger()->error('RecommendationController::generateAll failed: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
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
