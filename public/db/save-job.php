<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'oracledb.php';

try {
    // read JSON body (or fallback to POST/form)
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    if (!is_array($data)) {
        $data = $_POST ?: [];
    }

    // job id required
    $jobId = $data['job_id'] ?? null;
    if ($jobId === null || $jobId === '') {
        echo json_encode(['success' => false, 'message' => 'job_id required']);
        exit;
    }

    // guardian id from session (normal) or optional debug param (for local testing)
    $guardianId = $_SESSION['user_id'] ?? $_SESSION['guardian_id'] ?? null;
    $user_id_source = 'session';
    if (!$guardianId) {
        // allow JSON body override (useful when client has localStorage user_id immediately after registration)
        if (!empty($data['user_id'])) {
            $guardianId = preg_replace('/\D/', '', (string)$data['user_id']);
            $user_id_source = 'json_body';
        } elseif (!empty($data['debug_user_id'])) {
            $guardianId = preg_replace('/\D/', '', (string)$data['debug_user_id']);
            $user_id_source = 'debug_param';
        } elseif (!empty($_COOKIE['user_id'])) {
            $guardianId = preg_replace('/\D/', '', (string)$_COOKIE['user_id']);
            $user_id_source = 'cookie:user_id';
        } elseif (!empty($_COOKIE['uid'])) {
            $guardianId = preg_replace('/\D/', '', (string)$_COOKIE['uid']);
            $user_id_source = 'cookie:uid';
        }
    }

    if (!$guardianId) {
        echo json_encode(['success' => false, 'message' => 'Not authenticated (missing session user_id)', 'user_id_source' => null]);
        exit;
    }

    $conn = getOracleConnection();
    if (!$conn) {
        echo json_encode(['success' => false, 'message' => 'DB connection failed']);
        exit;
    }

    // normalize job id: accept numeric strings (do not intval, to avoid precision loss)
    if (!is_numeric($jobId)) {
        echo json_encode(['success' => false, 'message' => 'job_id must be numeric']);
        oci_close($conn);
        exit;
    }
    // keep as string to avoid JS -> PHP precision loss for very large numbers
    $jobIdNum = (string)$jobId;
    // ensure guardian id numeric
    $guardianId = preg_replace('/\D/', '', (string)$guardianId);
    if ($guardianId === '') {
        echo json_encode(['success' => false, 'message' => 'Invalid guardian id after parsing', 'user_id_source' => $user_id_source]);
        oci_close($conn);
        exit;
    }

    // VERIFY: job posting exists (JOB_POSTINGS only)
    // If your PHP DB user is not the MVSG schema, either qualify the table name (MVSG.JOB_POSTINGS)
    // or create a synonym so the table is visible to the connected user.
    $checkJobSql = "SELECT COUNT(*) AS CNT FROM MVSG.JOB_POSTINGS WHERE ID = :jid";
    $js = @oci_parse($conn, $checkJobSql);
    if (!$js) {
        $err = oci_error($conn);
        oci_close($conn);
        echo json_encode(['success' => false, 'message' => 'Failed to prepare job existence check', 'error' => $err['message'] ?? $err, 'checked_job_id' => $jobIdNum]);
        exit;
    }
    oci_bind_by_name($js, ':jid', $jobIdNum);
    if (!@oci_execute($js)) {
        $err = oci_error($js);
        oci_free_statement($js);
        oci_close($conn);
        echo json_encode(['success' => false, 'message' => 'Failed to verify job existence', 'error' => $err['message'] ?? $err, 'checked_job_id' => $jobIdNum]);
        exit;
    }
    $jr = oci_fetch_assoc($js);
    $jobCount = intval($jr['CNT'] ?? 0);
    oci_free_statement($js);
    if ($jobCount === 0) {
        // helpful debug: echo back which id we attempted to find
        oci_close($conn);
        echo json_encode(['success' => false, 'message' => 'job_not_found', 'detail' => 'Job posting not found (cannot save)', 'checked_job_id' => $jobIdNum]);
        exit;
    }

    // check duplicate
    $checkSql = "SELECT COUNT(*) AS CNT FROM SAVED_JOBS WHERE GUARDIAN_ID = :gid AND JOB_ID = :jid";
    $stid = oci_parse($conn, $checkSql);
    oci_bind_by_name($stid, ':gid', $guardianId);
    oci_bind_by_name($stid, ':jid', $jobIdNum);
    if (!@oci_execute($stid)) {
        $err = oci_error($stid);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode(['success' => false, 'message' => 'Duplicate check failed', 'error' => $err['message'] ?? $err]);
        exit;
    }
    $row = oci_fetch_assoc($stid);
    $cnt = intval($row['CNT'] ?? 0);
    oci_free_statement($stid);

    if ($cnt > 0) {
        oci_close($conn);
        echo json_encode(['success' => true, 'message' => 'already_saved']);
        exit;
    }

    // insert using sequence SAVED_JOBS_SEQ
    $insertSql = "INSERT INTO SAVED_JOBS (ID, GUARDIAN_ID, JOB_ID, CREATED_AT) VALUES (SAVED_JOBS_SEQ.NEXTVAL, :gid, :jid, SYSTIMESTAMP)";
    $ist = oci_parse($conn, $insertSql);
    oci_bind_by_name($ist, ':gid', $guardianId);
    // bind :jid to the insert statement ($ist), not $js
    oci_bind_by_name($ist, ':jid', $jobIdNum, -1);
    $ok = @oci_execute($ist, OCI_COMMIT_ON_SUCCESS);
    if (!$ok) {
        $e = oci_error($ist);
        $msg = $e['message'] ?? 'Insert failed';
        oci_free_statement($ist);
        oci_close($conn);
        echo json_encode(['success' => false, 'message' => 'Failed to save job', 'error' => $msg]);
        exit;
    }
    oci_free_statement($ist);
    oci_close($conn);

    echo json_encode(['success' => true, 'message' => 'saved']);
    exit;
} catch (Throwable $e) {
    echo json_encode(['success' => false, 'message' => 'Server error', 'error' => (string)$e->getMessage()]);
    exit;
}
?>
// ...existing code...