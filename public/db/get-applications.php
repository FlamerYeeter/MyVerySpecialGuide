<?php
session_start();
header('Content-Type: application/json');

require_once 'oracledb.php'; // provides getOracleConnection()

// Read JSON body if present
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) $data = [];

// Determine guardian id: JSON -> GET -> session
$guardian_id = null;
if (!empty($data['guardian_id'])) {
    $guardian_id = preg_replace('/\D/', '', (string)$data['guardian_id']);
} elseif (!empty($_GET['guardian_id'])) {
    $guardian_id = preg_replace('/\D/', '', (string)$_GET['guardian_id']);
} elseif (!empty($_SESSION['user_id'])) {
    $guardian_id = preg_replace('/\D/', '', (string)$_SESSION['user_id']);
}
if ($guardian_id === '') $guardian_id = null;

if (empty($guardian_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'guardian_id required (json, GET or session.user_id)']);
    exit;
}

$conn = getOracleConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

$sql = "
SELECT a.ID,
       a.JOB_POSTING_ID,
       a.COMPANY_ID,
       a.GUARDIAN_ID,
       a.FIRST_NAME,
       a.LAST_NAME,
       a.EMAIL,
       a.AGE,
       a.PHONE_NUMBER,
       a.COMPLETE_ADDRESS,
    a.CREATED_AT,
    -- prefer latest status from JOB_CAPACITY (per job_posting_id + user)
    (SELECT STATUS FROM (
         SELECT STATUS FROM MVSG.JOB_CAPACITY jc2
         WHERE jc2.JOB_POSTING_ID = a.JOB_POSTING_ID AND jc2.USER_ID = a.GUARDIAN_ID
         ORDER BY jc2.UPDATED_AT DESC
     ) jc_sub WHERE ROWNUM = 1) AS JC_STATUS,
       jp.COMPANY_NAME,
       jp.JOB_ROLE,
       jp.ADDRESS AS JOB_ADDRESS
FROM MVSG.APPLICATIONS a
LEFT JOIN MVSG.JOB_POSTINGS jp ON jp.ID = a.JOB_POSTING_ID
WHERE a.GUARDIAN_ID = :guardian_id
ORDER BY a.CREATED_AT DESC
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':guardian_id', $guardian_id, -1);
if (!@oci_execute($stid)) {
    $e = oci_error($stid) ?: oci_error($conn);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Query failed', 'oci' => $e]);
    exit;
}

$applications = [];
while ($row = oci_fetch_assoc($stid)) {
    $applications[] = [
        'id' => isset($row['ID']) ? $row['ID'] : null,
        'job_posting_id' => isset($row['JOB_POSTING_ID']) ? $row['JOB_POSTING_ID'] : null,
        'company_id' => isset($row['COMPANY_ID']) ? $row['COMPANY_ID'] : null,
        'guardian_id' => isset($row['GUARDIAN_ID']) ? $row['GUARDIAN_ID'] : null,
        'first_name' => $row['FIRST_NAME'] ?? null,
        'last_name' => $row['LAST_NAME'] ?? null,
        'email' => $row['EMAIL'] ?? null,
        'age' => isset($row['AGE']) ? intval($row['AGE']) : null,
        'phone_number' => $row['PHONE_NUMBER'] ?? null,
        'complete_address' => $row['COMPLETE_ADDRESS'] ?? null,
        'created_at' => isset($row['CREATED_AT']) ? $row['CREATED_AT'] : null,
        // Use JOB_CAPACITY status exclusively (no fallback to APPLICATIONS.STATUS)
        'status' => $row['JC_STATUS'] ?? null,
        'company_name' => $row['COMPANY_NAME'] ?? null,
        'job_role' => $row['JOB_ROLE'] ?? null,
        'job_address' => $row['JOB_ADDRESS'] ?? null,
    ];
}

oci_free_statement($stid);
oci_close($conn);

echo json_encode([
    'success' => true,
    'guardian_id' => $guardian_id,
    'count' => count($applications),
    'applications' => $applications,
]);

?>
