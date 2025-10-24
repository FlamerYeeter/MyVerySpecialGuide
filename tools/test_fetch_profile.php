<?php
// Simple CLI test to fetch Firestore user document using service account
// Usage: php tools/test_fetch_profile.php <uid>
$uid = $argv[1] ?? '1';
$svcPath = __DIR__ . '/../storage/app/firebase-service-account.json';
if (!file_exists($svcPath)) {
    echo "Service account file not found at: $svcPath\n";
    exit(2);
}
$json = json_decode(file_get_contents($svcPath), true);
$projectId = $json['project_id'] ?? null;
if (!$projectId) {
    echo "project_id missing in service account\n";
    exit(2);
}
$privateKey = $json['private_key'] ?? null;
$clientEmail = $json['client_email'] ?? null;
if (!$privateKey || !$clientEmail) {
    echo "service account missing client_email or private_key\n";
    exit(2);
}
$now = time();
$jwt = [
    'iss' => $clientEmail,
    'scope' => 'https://www.googleapis.com/auth/datastore',
    'aud' => 'https://oauth2.googleapis.com/token',
    'iat' => $now,
    'exp' => $now + 3600,
];
function base64url_encode($data) { return rtrim(strtr(base64_encode($data), '+/', '-_'), '='); }
$header = ['alg' => 'RS256', 'typ' => 'JWT'];
$segments = [];
$segments[] = base64url_encode(json_encode($header));
$segments[] = base64url_encode(json_encode($jwt));
$signing_input = implode('.', $segments);
$ok = openssl_sign($signing_input, $signature, openssl_pkey_get_private($privateKey), OPENSSL_ALGO_SHA256);
if (!$ok) { echo "OpenSSL signing failed\n"; exit(3); }
$segments[] = base64url_encode($signature);
$assertion = implode('.', $segments);
$post = http_build_query(['grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer','assertion' => $assertion]);
$opts = ["http" => ["method" => 'POST', 'header' => "Content-Type: application/x-www-form-urlencoded\r\n", 'content' => $post, 'ignore_errors' => true]];
$context = stream_context_create($opts);
$resp = @file_get_contents('https://oauth2.googleapis.com/token', false, $context);
if ($resp === false) { echo "token endpoint request failed\n"; exit(4); }
$data = json_decode($resp, true);
if (empty($data['access_token'])) { echo "no access_token in response:\n" . $resp . "\n"; exit(5); }
$access = $data['access_token'];
$docUrl = "https://firestore.googleapis.com/v1/projects/{$projectId}/databases/(default)/documents/users/" . rawurlencode($uid);
$opts = ["http" => ["method" => 'GET', 'header' => "Authorization: Bearer $access\r\n", 'ignore_errors' => true]];
$context = stream_context_create($opts);
$resp = @file_get_contents($docUrl, false, $context);
$http_response_header = $http_response_header ?? [];
// try to find HTTP status in headers
$status = 'unknown';
foreach ($http_response_header as $h) {
    if (preg_match('#HTTP/\d\.\d\s+(\d+)#', $h, $m)) { $status = intval($m[1]); break; }
}
echo "HTTP status: $status\n";
if ($resp === false) {
    echo "Request failed or returned empty body\n";
    exit(6);
}
echo "Response body:\n" . $resp . "\n";
return 0;
