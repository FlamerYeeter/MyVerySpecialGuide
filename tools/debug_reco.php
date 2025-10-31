<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$uid = $argv[1] ?? 'BIPhEcQu6ISF8vdQvqeTpJf4O1D2';
$limit = intval($argv[2] ?? 20);
$svc = app(\App\Services\RecommendationService::class);
try {
    echo "Running RecommendationService->generate for uid={$uid} limit={$limit}\n";
    // Quick diagnostics: call FirestoreAdminService methods first to ensure network/credentials work
    $fs = app(\App\Services\FirestoreAdminService::class);
    echo "Calling FirestoreAdminService->getUser...\n";
    $u = null;
    try { $u = $fs->getUser($uid); echo "getUser returned: ".(is_array($u)? 'array' : gettype($u))."\n"; } catch (Throwable $e) { echo "getUser ERROR: " . $e->getMessage() . "\n"; }
    echo "Calling FirestoreAdminService->listJobs...\n";
    $jobs = null;
    try {
        // Attempt a manual jobs list with a short timeout using the service account JWT flow
        $svcPath = getenv('FIREBASE_SERVICE_ACCOUNT') ?: __DIR__ . '/../storage/app/firebase-service-account.json';
        if (!file_exists($svcPath)) {
            echo "Service account not found at {$svcPath}\n";
        } else {
            $json = json_decode(file_get_contents($svcPath), true);
            $projectId = $json['project_id'] ?? null;
            if (!$projectId) {
                echo "project_id missing in service account\n";
            } else {
                // Build JWT assertion
                $clientEmail = $json['client_email'] ?? null;
                $privateKey = $json['private_key'] ?? null;
                if (!$clientEmail || !$privateKey) {
                    echo "service account missing client_email or private_key\n";
                } else {
                    $now = time();
                    $jwt = ['iss' => $clientEmail, 'scope' => 'https://www.googleapis.com/auth/datastore', 'aud' => 'https://oauth2.googleapis.com/token', 'iat' => $now, 'exp' => $now + 3600];
                    $header = ['alg' => 'RS256', 'typ' => 'JWT'];
                    $segments = [];
                    $segments[] = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
                    $segments[] = rtrim(strtr(base64_encode(json_encode($jwt)), '+/', '-_'), '=');
                    $signingInput = implode('.', $segments);
                    $pkey = openssl_pkey_get_private($privateKey);
                    $sig = '';
                    $ok = openssl_sign($signingInput, $sig, $pkey, OPENSSL_ALGO_SHA256);
                    openssl_free_key($pkey);
                    if (!$ok) { echo "openssl_sign failed\n"; }
                    $segments[] = rtrim(strtr(base64_encode($sig), '+/', '-_'), '=');
                    $assertion = implode('.', $segments);

                    // Request token with short timeout
                    $post = http_build_query(['grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'assertion' => $assertion]);
                    $opts = ['http' => ['method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'content' => $post, 'timeout' => 10]];
                    $ctx = stream_context_create($opts);
                    $resp = @file_get_contents('https://oauth2.googleapis.com/token', false, $ctx);
                    if ($resp === false) { echo "token request failed or timed out\n"; }
                    else {
                        $tok = json_decode($resp, true)['access_token'] ?? null;
                        if (!$tok) { echo "no access_token in token response\n"; }
                        else {
                            $url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/jobs?pageSize=50";
                            // use stream_context for GET with timeout
                            $opts2 = ['http' => ['method' => 'GET', 'header' => "Authorization: Bearer {$tok}\r\n", 'timeout' => 10]];
                            $ctx2 = stream_context_create($opts2);
                            $jresp = @file_get_contents($url, false, $ctx2);
                            if ($jresp === false) { echo "jobs GET failed or timed out\n"; }
                            else {
                                $data = json_decode($jresp, true);
                                $cnt = !empty($data['documents']) && is_array($data['documents']) ? count($data['documents']) : 0;
                                echo "manual listJobs returned: {$cnt} documents\n";
                                    // also probe interactions collection with short timeout
                                    $intUrl = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/interactions?pageSize=500";
                                    $jresp2 = @file_get_contents($intUrl, false, $ctx2);
                                    if ($jresp2 === false) { echo "interactions GET failed or timed out\n"; }
                                    else {
                                        $idata = json_decode($jresp2, true);
                                        $icnt = !empty($idata['documents']) && is_array($idata['documents']) ? count($idata['documents']) : 0;
                                        echo "manual listInteractions returned: {$icnt} documents\n";
                                    }
                            }
                        }
                    }
                }
            }
        }
    } catch (Throwable $e) { echo "manual listJobs ERROR: " . $e->getMessage() . "\n"; }

    echo "Now calling RecommendationService->generate()...\n";
    $start = microtime(true);
    $recs = $svc->generate($uid, $limit);
    $dur = microtime(true) - $start;
    echo "DONE; generate returned " . (is_array($recs) ? count($recs) : 0) . " records in " . round($dur,2) . "s\n";
    echo json_encode($recs, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) . PHP_EOL;
} catch (Throwable $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
}
