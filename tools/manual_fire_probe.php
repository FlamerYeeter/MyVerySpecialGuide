<?php
$svcPath = __DIR__ . '/../storage/app/firebase-service-account.json';
if (!file_exists($svcPath)) { echo "service account not found at {$svcPath}\n"; exit(1); }
$json = json_decode(file_get_contents($svcPath), true);
$projectId = $json['project_id'] ?? null;
$clientEmail = $json['client_email'] ?? null;
$privateKey = $json['private_key'] ?? null;
if (!$projectId || !$clientEmail || !$privateKey) { echo "service account missing fields\n"; exit(1); }
$now = time();
$jwt = ['iss' => $clientEmail, 'scope' => 'https://www.googleapis.com/auth/datastore', 'aud' => 'https://oauth2.googleapis.com/token', 'iat' => $now, 'exp' => $now + 3600];
$header = ['alg' => 'RS256', 'typ' => 'JWT'];
$segments = [];
$segments[] = rtrim(strtr(base64_encode(json_encode($header)), '+/', '-_'), '=');
$segments[] = rtrim(strtr(base64_encode(json_encode($jwt)), '+/', '-_'), '=');
$signingInput = implode('.', $segments);
$pkey = openssl_pkey_get_private($privateKey);
if ($pkey === false) { echo "openssl_pkey_get_private failed\n"; exit(1); }
$sig = ''; $ok = openssl_sign($signingInput, $sig, $pkey, OPENSSL_ALGO_SHA256);
openssl_free_key($pkey);
if (!$ok) { echo "openssl_sign failed\n"; exit(1); }
$segments[] = rtrim(strtr(base64_encode($sig), '+/', '-_'), '=');
$assertion = implode('.', $segments);
$post = http_build_query(['grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer', 'assertion' => $assertion]);
$opts = ['http' => ['method' => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'content' => $post, 'timeout' => 10]];
$ctx = stream_context_create($opts);
$resp = @file_get_contents('https://oauth2.googleapis.com/token', false, $ctx);
if ($resp === false) { echo "token request failed or timed out\n"; exit(1); }
$data = json_decode($resp, true);
$tok = $data['access_token'] ?? null;
if (!$tok) { echo "no access_token in token response\n"; echo $resp; exit(1); }
echo "got token; calling jobs endpoint...\n";
$url = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/jobs?pageSize=50";
$opts2 = ['http' => ['method' => 'GET', 'header' => "Authorization: Bearer {$tok}\r\n", 'timeout' => 10]];
$ctx2 = stream_context_create($opts2);
$jresp = @file_get_contents($url, false, $ctx2);
if ($jresp === false) { echo "jobs GET failed or timed out\n"; exit(1); }
$data = json_decode($jresp, true);
$cnt = !empty($data['documents']) && is_array($data['documents']) ? count($data['documents']) : 0;
echo "manual probe: jobs returned {$cnt} documents\n";

// interactions
$intUrl = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/interactions?pageSize=500";
$jresp2 = @file_get_contents($intUrl, false, $ctx2);
if ($jresp2 === false) { echo "interactions GET failed or timed out\n"; exit(1); }
$idata = json_decode($jresp2, true);
$icnt = !empty($idata['documents']) && is_array($idata['documents']) ? count($idata['documents']) : 0;
echo "manual probe: interactions returned {$icnt} documents\n";
