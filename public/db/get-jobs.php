<?php
session_start();
header('Content-Type: application/json');

require_once 'oracledb.php'; // contains getOracleConnection()

// ——— READ & VALIDATE JSON ———
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (!$data) {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => 'Invalid JSON']));
}

$conn = getOracleConnection();
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed']);
    exit;
}

$user_id = $data['user_id'];

$sql = "
SELECT *
FROM (
    SELECT 
        jp.ID,
        jp.COMPANY_NAME,
        jp.JOB_ROLE,
        jp.JOB_DESCRIPTION,
        jp.ADDRESS,
        jp.JOB_TYPE,
        jp.EMPLOYEE_CAPACITY,
        PRIORITY,
        jp.JOB_POST_DATE,
        ROW_NUMBER() OVER (PARTITION BY jp.ID ORDER BY PRIORITY) AS rn
    FROM (
        -- Priority 1: profile match
        SELECT 
            jp.ID,
            jp.COMPANY_NAME,
            jp.JOB_ROLE,
            jp.JOB_DESCRIPTION,
            jp.ADDRESS,
            jp.JOB_TYPE,
            jp.EMPLOYEE_CAPACITY,
            1 AS PRIORITY,
            jp.JOB_POST_DATE
        FROM JOB_POSTINGS jp
        INNER JOIN JOB_PROFILE JPR
            ON JPR.JOB_POSTING_ID = jp.ID
        INNER JOIN USER_PROFILE UP
            ON UP.VALUE = JPR.VALUE
        INNER JOIN USER_GUARDIAN UG
            ON UG.ID = UP.GUARDIAN_ID
        WHERE UG.ID = :user_id

        UNION ALL

        -- Priority 2: address match only
        SELECT 
            jp.ID,
            jp.COMPANY_NAME,
            jp.JOB_ROLE,
            jp.JOB_DESCRIPTION,
            jp.ADDRESS,
            jp.JOB_TYPE,
            jp.EMPLOYEE_CAPACITY,
            2 AS PRIORITY,
            jp.JOB_POST_DATE
        FROM JOB_POSTINGS jp
        INNER JOIN USER_GUARDIAN UG
            ON UG.ADDRESS = jp.ADDRESS
        WHERE UG.ID = :user_id
    ) jp
)
WHERE rn = 1
ORDER BY PRIORITY, JOB_POST_DATE DESC

";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':user_id', $user_id);
oci_execute($stid);

$jobs = [];

while ($row = oci_fetch_assoc($stid)) {
    $jobId = $row['ID'];

    // Fetch skills from JOB_PROFILE
    $profileSql = "
        SELECT VALUE, TYPE 
        FROM JOB_PROFILE 
        WHERE JOB_POSTING_ID = :job_id 
        AND VALUE IS NOT NULL
        AND TYPE IN ('skills', 'job-position', 'role')
    ";
    $pstid = oci_parse($conn, $profileSql);
    oci_bind_by_name($pstid, ':job_id', $jobId);
    oci_execute($pstid);

    $skills = [];
    $jobTypes = [];
    while ($p = oci_fetch_assoc($pstid)) {
        $type = strtolower($p['TYPE']);
        if (strpos($type, 'role') !== false || $type === 'job-position') {
            $jobTypes[] = $p['VALUE'];
        } elseif ($type === 'skills') {
            $skills[] = $p['VALUE'];
        }
    }
    oci_free_statement($pstid);

    // === Fetch COMPANY_IMAGE separately ===
    $imgSql = "SELECT COMPANY_IMAGE FROM JOB_POSTINGS WHERE ID = :job_id";
    $imgStid = oci_parse($conn, $imgSql);
    oci_bind_by_name($imgStid, ':job_id', $jobId);
    oci_execute($imgStid);
    $imgRow = oci_fetch_assoc($imgStid);

    if ($imgRow && $imgRow['COMPANY_IMAGE'] !== null) {
        $blob = $imgRow['COMPANY_IMAGE']; // OCI-Lob object
        $imageContent = $blob->load();
        $logoSrc = "data:image/png;base64," . base64_encode($imageContent);
    } else {
        $logoSrc = "https://via.placeholder.com/150?text=Logo";
    }
    oci_free_statement($imgStid);

    $jobs[] = [
        'id'            => $jobId,
        'company_name'  => $row['COMPANY_NAME'] ?? 'Null',
        'job_role'      => $row['JOB_ROLE'] ?? 'Service Crew',
        'description'   => $row['JOB_DESCRIPTION'] ?? '',
        'address'       => $row['ADDRESS'] ?? 'Null',
        'job_type'      => !empty($jobTypes) ? $jobTypes[0] : ($row['JOB_TYPE'] ?? 'Full Time'),
        'skills'        => $skills,
        'openings'      => $row['EMPLOYEE_CAPACITY'] ?? 10,
        'applied'       => 0,
        'logo'          => $logoSrc
    ];
}

oci_free_statement($stid);
oci_close($conn);

echo json_encode(['success' => true, 'jobs' => $jobs]);
?>
