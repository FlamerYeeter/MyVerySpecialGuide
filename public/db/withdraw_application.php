<?php
session_start();
header('Content-Type: application/json');

require_once 'oracledb.php'; // provides getOracleConnection()

$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!is_array($data)) $data = [];

// Determine guardian id: JSON -> POST -> GET -> session
$guardian_id = null;
if (!empty($data['guardian_id'])) {
    $guardian_id = preg_replace('/\D/', '', (string)$data['guardian_id']);
} elseif (!empty($_POST['guardian_id'])) {
    $guardian_id = preg_replace('/\D/', '', (string)$_POST['guardian_id']);
} elseif (!empty($_GET['guardian_id'])) {
    $guardian_id = preg_replace('/\D/', '', (string)$_GET['guardian_id']);
} elseif (!empty($_SESSION['user_id'])) {
    $guardian_id = preg_replace('/\D/', '', (string)$_SESSION['user_id']);
}
if ($guardian_id === '') $guardian_id = null;

// Determine application id: JSON -> POST -> GET
$application_id = null;
if (!empty($data['application_id'])) {
    $application_id = preg_replace('/\D/', '', (string)$data['application_id']);
} elseif (!empty($_POST['application_id'])) {
    $application_id = preg_replace('/\D/', '', (string)$_POST['application_id']);
} elseif (!empty($_GET['application_id'])) {
    $application_id = preg_replace('/\D/', '', (string)$_GET['application_id']);
}
if ($application_id === '') $application_id = null;

if (empty($guardian_id) || empty($application_id)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'guardian_id and application_id required']);
    exit;
}

$conn = getOracleConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

// Verify ownership and current status
$checkSql = "SELECT GUARDIAN_ID, STATUS FROM MVSG.APPLICATIONS WHERE ID = :id";
$stid = oci_parse($conn, $checkSql);
oci_bind_by_name($stid, ':id', $application_id, -1);
if (!@oci_execute($stid)) {
    $e = oci_error($stid) ?: oci_error($conn);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Query failed', 'oci' => $e]);
    oci_free_statement($stid);
    oci_close($conn);
    exit;
}

$row = oci_fetch_assoc($stid);
oci_free_statement($stid);
if (!$row) {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Application not found']);
    oci_close($conn);
    exit;
}

if ((string)$row['GUARDIAN_ID'] !== (string)$guardian_id) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Not authorized to withdraw this application']);
    oci_close($conn);
    exit;
}

$currentStatus = strtolower((string)($row['STATUS'] ?? ''));
if (in_array($currentStatus, ['withdrawn', 'cancelled'])) {
    echo json_encode(['success' => true, 'message' => 'Application already withdrawn', 'status' => $row['STATUS']]);
    oci_close($conn);
    exit;
}

// allow caller to suggest a status (fallback to 'withdrawn')
$newStatus = 'withdrawn';
if (!empty($data['status'])) {
    $newStatus = preg_replace('/[^A-Za-z0-9 _-]/', '', (string)$data['status']);
}
$newStatus = 'withdrawn';
// Inspect DB check constraints to determine allowed STATUS values (helpful when update would violate constraint)
$allowedStatuses = null;
$consSql = "SELECT SEARCH_CONDITION FROM ALL_CONSTRAINTS WHERE OWNER = 'MVSG' AND TABLE_NAME = 'APPLICATIONS' AND CONSTRAINT_TYPE = 'C'";
$cstid = oci_parse($conn, $consSql);
if (@oci_execute($cstid)) {
    while ($crow = oci_fetch_assoc($cstid)) {
        $cond = $crow['SEARCH_CONDITION'] ?? '';
        if (preg_match('/STATUS\s+IN\s*\(([^)]+)\)/i', $cond, $m)) {
            $list = $m[1];
            $parts = preg_split('/\s*,\s*/', $list);
            $allowed = [];
            foreach ($parts as $p) {
                $p = trim($p);
                $p = trim($p, "'\"");
                if ($p !== '') $allowed[] = $p;
            }
            if (count($allowed)) { $allowedStatuses = $allowed; break; }
        }
    }
}
if ($cstid) oci_free_statement($cstid);

// Instead of updating STATUS, delete the application so the user can re-apply later.
$delSql = "DELETE FROM MVSG.APPLICATIONS WHERE ID = :id";
$stid = oci_parse($conn, $delSql);
oci_bind_by_name($stid, ':id', $application_id, -1);
if (!@oci_execute($stid)) {
    $e = oci_error($stid) ?: oci_error($conn);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Delete failed', 'oci' => $e]);
    oci_free_statement($stid);
    oci_close($conn);
    exit;
}

$rows = oci_num_rows($stid);
oci_commit($conn);
oci_free_statement($stid);
oci_close($conn);

if ($rows > 0) {
    echo json_encode(['success' => true, 'application_id' => $application_id, 'deleted' => true]);
} else {
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Application not deleted (not found)']);
}

?>
