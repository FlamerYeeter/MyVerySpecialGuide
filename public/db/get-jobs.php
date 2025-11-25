<?php
session_start();
header('Content-Type: application/json');

require_once 'oracledb.php'; // contains getOracleConnection()

$conn = getOracleConnection();
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed']);
    exit;
}

$sql = "
    SELECT 
        jp.ID,
        jp.COMPANY_NAME,
        jp.JOB_ROLE,
        jp.JOB_DESCRIPTION,
        jp.ADDRESS,
        jp.JOB_TYPE,
        jp.EMPLOYEE_CAPACITY,
        jp.COMPANY_IMAGE
    FROM JOB_POSTINGS jp
    ORDER BY jp.JOB_POST_DATE DESC
";

$stid = oci_parse($conn, $sql);
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

    // Handle BLOB image correctly
    if ($row['COMPANY_IMAGE'] !== null) {
        $blob = $row['COMPANY_IMAGE']; // OCI-Lob object
        $imageContent = $blob->load(); // read the binary content
        $logoSrc = "data:image/png;base64," . base64_encode($imageContent);
    } else {
        $logoSrc = "https://via.placeholder.com/150?text=Logo";
    }

    $jobs[] = [
        'id'            => $jobId,
        'company_name'  => $row['COMPANY_NAME'] ?? 'Null',
        'job_role'      => $row['JOB_ROLE'] ?? 'Service Crew',
        'description'   => $row['JOB_DESCRIPTION'] ?? '',
        'address'       => $row['ADDRESS'] ?? 'Null',
        'job_type'      => !empty($jobTypes) ? $jobTypes[0] : ($row['JOB_TYPE'] ?? 'Full Time'),
        'skills'        => $skills,
        'openings'      => $row['EMPLOYEE_CAPACITY'] ?? 10,
        'applied'       => rand(1, 8), // placeholder, replace with real count if needed
        'logo'          => $logoSrc
    ];
}

oci_free_statement($stid);
oci_close($conn);

echo json_encode(['success' => true, 'jobs' => $jobs]);
?>
