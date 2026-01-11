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

    // Join saved jobs to JOB_POSTINGS (schema-qualified)
    $sql = "
      SELECT sj.JOB_ID,
             sj.CREATED_AT,
             jp.ID                AS JP_ID,
             jp.JOB_ROLE          AS JOB_TITLE,
             jp.COMPANY_NAME      AS COMPANY_NAME,
             jp.ADDRESS           AS LOCATION,
                         jp.JOB_DESCRIPTION   AS DESCRIPTION,
                         jp.COMPANY_IMAGE     AS COMPANY_IMAGE,
                         jp.EMPLOYEE_CAPACITY AS EMPLOYEE_CAPACITY,
                         jp.APPLY_BEFORE      AS APPLY_BEFORE,
                         (SELECT COUNT(DISTINCT GUARDIAN_ID) FROM MVSG.APPLICATIONS a WHERE a.JOB_POSTING_ID = jp.ID) AS APPLIED_COUNT,
                         (SELECT COUNT(*) FROM MVSG.APPLICATIONS a2 WHERE a2.JOB_POSTING_ID = jp.ID AND a2.GUARDIAN_ID = :gid) AS USER_APPLIED
      FROM MVSG.SAVED_JOBS sj
      JOIN MVSG.JOB_POSTINGS jp ON jp.ID = sj.JOB_ID
      WHERE sj.GUARDIAN_ID = :gid
      ORDER BY sj.CREATED_AT DESC
    ";

    $stid = oci_parse($conn, $sql);
    if (!$stid) {
        $err = oci_error($conn);
        oci_close($conn);
        echo json_encode(['success' => false, 'message' => 'Prepare failed', 'error' => $err['message'] ?? $err]);
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
        // COMPANY_IMAGE may come as an OCI-Lob object; convert to base64 if present
        $logoSrc = null;
        if (!empty($r['COMPANY_IMAGE'])) {
            $blob = $r['COMPANY_IMAGE'];
            try {
                if (is_object($blob) && method_exists($blob, 'load')) {
                    $imageContent = $blob->load();
                    if ($imageContent !== false && $imageContent !== null && strlen($imageContent) > 0) {
                        // try to guess PNG/JPEG; default to png
                        $mime = 'image/png';
                        // very small heuristic: check JPEG magic bytes
                        if (substr($imageContent, 0, 3) === "\xFF\xD8\xFF") $mime = 'image/jpeg';
                        $logoSrc = "data:$mime;base64," . base64_encode($imageContent);
                    }
                }
            } catch (Throwable $e) {
                // ignore blob load errors and fallback to null
                $logoSrc = null;
            }
        }

        // fallback placeholder
        if (!$logoSrc) {
            $logoSrc = "/image/jobexp3.png";
        }

        $rows[] = [
            'job_id'      => $r['JOB_ID'] ?? $r['JP_ID'] ?? null,
            'created_at'  => isset($r['CREATED_AT']) ? (string)$r['CREATED_AT'] : null,
            'job_role'    => $r['JOB_TITLE'] ?? null,
            'company_name'=> $r['COMPANY_NAME'] ?? null,
            'address'     => $r['LOCATION'] ?? null,
            'description' => $r['DESCRIPTION'] ?? null,
            'logo'        => $logoSrc,
            'openings'    => isset($r['EMPLOYEE_CAPACITY']) ? (int)$r['EMPLOYEE_CAPACITY'] : null,
            'apply_before'=> $r['APPLY_BEFORE'] ?? null,
            'applied'     => isset($r['APPLIED_COUNT']) ? (int)$r['APPLIED_COUNT'] : 0,
            'applied_count'=> isset($r['APPLIED_COUNT']) ? (int)$r['APPLIED_COUNT'] : 0,
            'user_applied'=> isset($r['USER_APPLIED']) && intval($r['USER_APPLIED']) > 0 ? true : false,
        ];
    }

    // --- new: record view interactions (once per session) -------------------------
    try {
        if (!isset($_SESSION['ui_logged_saved_view']) || !is_array($_SESSION['ui_logged_saved_view'])) {
            $_SESSION['ui_logged_saved_view'] = [];
        }

        // Prepare an insert statement; rely on DB identity for ID if available
        $insSql = "INSERT INTO MVSG.USER_INTERACTIONS (GUARDIAN_ID, JOB_ID, INTERACTION_TYPE, INTERACTION_AT, META)
                VALUES (:gid, :jid, :itype, SYSTIMESTAMP, :meta)";
        $insStmt = @oci_parse($conn, $insSql);

        foreach ($rows as $r) {
            $jid = $r['job_id'] ?? null;
            if (!$jid) continue;
            // Avoid repeated inserts for the same job during this session
            if (in_array((string)$jid, $_SESSION['ui_logged_saved_view'], true)) continue;

            if ($insStmt) {
                $itype = 'view';
                $meta = json_encode(['source' => 'saved_list', 'note' => 'user fetched saved jobs']);
                oci_bind_by_name($insStmt, ':gid', $guardianId);
                oci_bind_by_name($insStmt, ':jid', $jid);
                oci_bind_by_name($insStmt, ':itype', $itype);
                oci_bind_by_name($insStmt, ':meta', $meta);
                // execute but do not let a failure break the response
                @oci_execute($insStmt);
                // mark as logged in session
                $_SESSION['ui_logged_saved_view'][] = (string)$jid;
            }
        }
        if ($insStmt) @oci_free_statement($insStmt);
    } catch (Throwable $e) {
        // ignore logging failures — they should not affect primary API
    }
    // ---------------------------------------------------------------------------

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