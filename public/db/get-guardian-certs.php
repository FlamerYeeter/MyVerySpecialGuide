<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'oracledb.php';

// accept JSON POST or GET param
$raw = file_get_contents('php://input');
$body = json_decode($raw, true);
$gid = $body['guardian_id'] ?? $_GET['guardian_id'] ?? null;

if (!$gid || !preg_match('/^\d+$/', (string)$gid)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing or invalid guardian_id']);
    exit;
}

$conn = getOracleConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

$sql = "
SELECT ID,
       GUARDIAN_ID,
       NAME,
       ISSUED_BY,
       TO_CHAR(DATE_COMPLETED,'YYYY-MM-DD\"T\"HH24:MI:SS') AS DATE_COMPLETED,
       WHAT_LEARNED,
       TO_CHAR(CREATED_AT,'YYYY-MM-DD\"T\"HH24:MI:SS') AS CREATED_AT,
       TO_CHAR(UPDATED_AT,'YYYY-MM-DD\"T\"HH24:MI:SS') AS UPDATED_AT
FROM MVSG.GUARDIAN_CERTIFICATES
WHERE GUARDIAN_ID = TO_NUMBER(:gid)
ORDER BY DATE_COMPLETED DESC NULLS LAST, ID DESC
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':gid', $gid, -1);
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Query failed', 'details' => $e ? $e['message'] : null]);
    @oci_free_statement($stid);
    @oci_close($conn);
    exit;
}

$rows = [];
while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_LOBS + OCI_RETURN_NULLS)) {
    // Normalize keys to uppercase (already) but ensure simple types
    $rows[] = $row;
}

echo json_encode(['success' => true, 'certificates' => $rows], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

@oci_free_statement($stid);
@oci_close($conn);
?>