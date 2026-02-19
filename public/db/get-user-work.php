<?php
// get-user-work.php - return USER_PROFILE (multiple TYPE rows) and JOB_EXPERIENCE for a guardian (uses same session pattern as get_profile.php)
ob_start();
ini_set('display_errors', '0');
ini_set('log_errors', '1');
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json; charset=utf-8');

require_once 'oracledb.php';

try {
    // accept JSON body (optional) but follow get_profile.php: prefer session user_id if available
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);

    $guardian_id = null;
    if (!empty($data['guardian_id'])) {
        $guardian_id = $data['guardian_id'];
    } elseif (!empty($_SESSION['user_id'])) {
        // get_profile.php uses $_SESSION['user_id'] as the guardian id; reuse same behaviour
        $guardian_id = $_SESSION['user_id'];
    } else {
        // same style as get_profile.php: when no session, return JSON error
        http_response_code(401);
        ob_end_clean();
        echo json_encode(['success' => false, 'error' => 'Not logged in']);
        exit;
    }

    $conn = getOracleConnection();
    if (!$conn) {
        http_response_code(500);
        ob_end_clean();
        echo json_encode(['success' => false, 'error' => 'DB connect failed']);
        exit;
    }

    // collect USER_PROFILE rows (TYPE can be repeated)
    $profiles = ['skills' => [], 'job_preference' => [], 'work_experience' => [], 'workplace' => []];

    $sql = "SELECT TYPE, VALUE FROM user_profile WHERE guardian_id = :gid ORDER BY created_at";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':gid', $guardian_id);
    oci_execute($stid);
    while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_LOBS + OCI_RETURN_NULLS)) {
        $type = strtolower(trim($row['TYPE'] ?? ''));
        $val  = $row['VALUE'] ?? '';
        if ($type === 'skills') {
            $profiles['skills'][] = $val;
        } elseif ($type === 'job_preference') {
            $profiles['job_preference'][] = $val;
        } elseif ($type === 'work_experience') {
            $profiles['work_experience'][] = $val;
        } elseif ($type === 'workplace') {
            $profiles['workplace'][] = $val;
        }
    }
    oci_free_statement($stid);

    // fetch JOB_EXPERIENCE rows
    $jobRows = [];
    $sql2 = "SELECT id, years_experience, job_title, company_name, work_year, job_description, working_environment, created_at,
             CASE WHEN workexp_certificate IS NOT NULL THEN 1 ELSE 0 END AS HAS_CERT
             FROM job_experience
             WHERE guardian_id = :gid
             ORDER BY created_at DESC";
    $stid2 = oci_parse($conn, $sql2);
    oci_bind_by_name($stid2, ':gid', $guardian_id);
    oci_execute($stid2);
    while ($r = oci_fetch_array($stid2, OCI_ASSOC + OCI_RETURN_LOBS + OCI_RETURN_NULLS)) {
        $jobRows[] = [
            'id' => $r['ID'] ?? null,
            'years_experience' => $r['YEARS_EXPERIENCE'] ?? null,
            'job_title' => $r['JOB_TITLE'] ?? null,
            'company_name' => $r['COMPANY_NAME'] ?? null,
            'work_year' => $r['WORK_YEAR'] ?? null,
            'job_description' => $r['JOB_DESCRIPTION'] ?? null,
            'working_environment' => $r['WORKING_ENVIRONMENT'] ?? null,
            'created_at' => isset($r['CREATED_AT']) ? (string)$r['CREATED_AT'] : null,
            // include HAS_CERT so the frontend can show file badges/links
            'has_cert' => isset($r['HAS_CERT']) ? (int)$r['HAS_CERT'] : 0
        ];
    }
    oci_free_statement($stid2);

    // close connection
    oci_close($conn);

    // return JSON (follow the get_profile.php pattern: success + payload)
    ob_end_clean();
    echo json_encode([
        'success' => true,
        'guardian_id' => (string)$guardian_id,
        'profiles' => $profiles,
        'job_experience_rows' => $jobRows
    ], JSON_UNESCAPED_UNICODE);
    exit;
} catch (Throwable $e) {
    if (ob_get_length()) { @ob_end_clean(); }
    http_response_code(500);
    error_log("get-user-work error: " . $e->getMessage());
    echo json_encode(['success' => false, 'error' => 'internal_server_error']);
    exit;
}
?>
// ...existing code...