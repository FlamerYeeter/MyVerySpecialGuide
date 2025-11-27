<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
require_once 'oracledb.php';

try {
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

    // Join saved jobs to JOB_POSTINGS (use MVSG schema if needed)
    $sql = "
      SELECT sj.JOB_ID,
             sj.CREATED_AT,
             jp.ID                AS JP_ID,
             jp.JOB_ROLE          AS JOB_TITLE,
             jp.COMPANY_NAME      AS COMPANY_NAME,
             jp.ADDRESS           AS LOCATION,
             jp.JOB_DESCRIPTION   AS DESCRIPTION,
             jp.COMPANY_IMAGE     AS COMPANY_IMAGE /* BLOB - not converted here */
      FROM MVSG.SAVED_JOBS sj
      JOIN MVSG.JOB_POSTINGS jp ON jp.ID = sj.JOB_ID
      WHERE sj.GUARDIAN_ID = :gid
      ORDER BY sj.CREATED_AT DESC
    ";

    $stid = oci_parse($conn, $sql);
    if (!$stid) {
        $err = oci_error($conn);
        echo json_encode(['success' => false, 'message' => 'Prepare failed', 'error' => $err['message'] ?? $err]);
        oci_close($conn);
        exit;
    }

    oci_bind_by_name($stid, ':gid', $guardianId);
    if (!@oci_execute($stid)) {
        $err = oci_error($stid);
        oci_free_statement($stid);
        oci_close($conn);
        echo json_encode(['success' => false, 'message' => 'Query failed', 'error' => $err['message'] ?? $err]);
        exit;
    }

    $rows = [];
    while (($r = oci_fetch_assoc($stid)) !== false) {
        $rows[] = [
            'job_id'      => $r['JOB_ID'] ?? null,
            'created_at'  => isset($r['CREATED_AT']) ? (string)$r['CREATED_AT'] : null,
            'job_role'    => $r['JOB_TITLE'] ?? null,
            'company_name'=> $r['COMPANY_NAME'] ?? null,
            'address'     => $r['LOCATION'] ?? null,
            'description' => $r['DESCRIPTION'] ?? null,
            // COMPANY_IMAGE is BLOB — return null and let client use default or implement blob->base64 if desired
            'logo'        => null,
        ];
    }

    oci_free_statement($stid);
    oci_close($conn);

    echo json_encode(['success' => true, 'saved' => $rows]);
    exit;
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error', 'error' => $e->getMessage()]);
    exit;
}
?>