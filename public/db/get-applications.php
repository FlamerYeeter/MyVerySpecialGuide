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

// Debug shortcut: return request/session/headers and a lightweight DB connect test
if (!empty($_GET['debug']) && $_GET['debug'] === '1') {
    $hdrs = function_exists('getallheaders') ? getallheaders() : [];
    $connTest = null;
    $conn = getOracleConnection();
    if ($conn) {
        $stidT = @oci_parse($conn, 'SELECT 1 FROM DUAL');
        if ($stidT && @oci_execute($stidT)) {
            $connTest = ['ok' => true];
        } else {
            $eT = oci_error($stidT) ?: oci_error($conn);
            $connTest = ['ok' => false, 'error' => $eT];
        }
        @oci_free_statement($stidT);
        // do not close shared connection here
    } else {
        $connTest = ['ok' => false, 'error' => 'no-connection'];
    }

    echo json_encode([
        'success' => true,
        'guardian_id' => $guardian_id,
        'get' => $_GET,
        'cookie' => $_COOKIE,
        'session' => isset($_SESSION) ? $_SESSION : null,
        'headers' => $hdrs,
        'db_test' => $connTest,
    ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

// We only needed the session to read `user_id` above; close it to avoid session-file locking
if (session_status() === PHP_SESSION_ACTIVE) {
    session_write_close();
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
    NVL(jp.JOB_ROLE, jp.JOB_DESCRIPTION) AS JOB_ROLE,
    jp.ADDRESS AS JOB_ADDRESS
FROM MVSG.APPLICATIONS a
LEFT JOIN MVSG.JOB_POSTINGS jp ON jp.ID = a.JOB_POSTING_ID
WHERE a.GUARDIAN_ID = :guardian_id
ORDER BY a.CREATED_AT DESC
FETCH FIRST 500 ROWS ONLY
";

$stid = oci_parse($conn, $sql);
// Request OCI to prefetch rows to reduce round-trips for larger result sets
if (function_exists('oci_set_prefetch')) {
    @oci_set_prefetch($stid, 100);
}
// Measure query time for diagnostics
$qStart = microtime(true);
oci_bind_by_name($stid, ':guardian_id', $guardian_id, -1);
if (!@oci_execute($stid)) {
    $e = oci_error($stid) ?: oci_error($conn);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Query failed', 'oci' => $e]);
    exit;
}
$qElapsed = microtime(true) - $qStart;
if ($qElapsed > 1.0) {
    error_log('get-applications: query time ' . round($qElapsed,3) . 's for guardian_id=' . $guardian_id);
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
        // historical clients may expect `job_title`; provide alias to `job_role`
        'job_role' => $row['JOB_ROLE'] ?? null,
        'job_title' => $row['JOB_ROLE'] ?? null,
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
