<?php
// filepath: c:\xampp\htdocs\MyVerySpecialGuide\public\db\remove-saved-job.php
session_start();
header('Content-Type: application/json; charset=utf-8');

require_once 'oracledb.php';

try {
    // accept JSON or form POST
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (!$data) {
        $data = $_POST;
    }

    $jobId = $data['job_id'] ?? null;
    if (!$jobId) {
        echo json_encode(['success' => false, 'message' => 'job_id required']);
        exit;
    }

    $guardianId = $_SESSION['user_id'] ?? null;
    if (!$guardianId) {
        echo json_encode(['success' => false, 'message' => 'Not authenticated']);
        exit;
    }

    $conn = getOracleConnection();
    if (!$conn) {
        echo json_encode(['success' => false, 'message' => 'DB connection failed']);
        exit;
    }

    $sql = "DELETE FROM SAVED_JOBS WHERE GUARDIAN_ID = :gid AND JOB_ID = :jid";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':gid', $guardianId);
    oci_bind_by_name($stid, ':jid', $jobId);
    $ok = @oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
    $err = null;
    if (!$ok) {
        $e = oci_error($stid);
        $err = $e['message'] ?? 'Delete failed';
    }
    oci_free_statement($stid);
    oci_close($conn);

    if ($ok) {
        echo json_encode(['success' => true, 'message' => 'deleted']);
    } else {
        echo json_encode(['success' => false, 'message' => $err]);
    }
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error', 'error' => $e->getMessage()]);
}