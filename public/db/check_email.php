<?php
require_once __DIR__ . '/oracledb.php';

header('Content-Type: application/json; charset=utf-8');

$email = '';
if (isset($_GET['email'])) $email = trim((string)$_GET['email']);
elseif (isset($_POST['email'])) $email = trim((string)$_POST['email']);

if ($email === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing email']);
    exit;
}

try {
    $conn = getOracleConnection();
    $sql = "SELECT COUNT(*) AS CNT FROM user_guardian WHERE LOWER(email) = LOWER(:email)";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':email', $email);
    if (!oci_execute($stid)) {
        $e = oci_error($stid) ?: oci_error($conn);
        http_response_code(500);
        echo json_encode(['success' => false, 'error' => 'Query failed', 'debug' => $e]);
        exit;
    }
    $count = 0;
    if (oci_fetch($stid)) {
        $count = intval(oci_result($stid, 'CNT'));
    }
    oci_free_statement($stid);

    echo json_encode(['success' => true, 'exists' => $count > 0]);
    exit;
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => (string)$e]);
    exit;
}

?>
