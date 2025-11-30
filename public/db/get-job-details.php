<?php
header('Content-Type: application/json; charset=utf-8');

// Accept either "id" or "job_id" as string to avoid integer precision loss
$id_str = $_GET['id'] ?? $_GET['job_id'] ?? null;
if (!$id_str || !preg_match('/^\d+$/', $id_str)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing or invalid job id', 'received' => $id_str]);
    exit;
}

// Use the shared Oracle helper (same as get-jobs.php)
require_once 'oracledb.php'; // expects getOracleConnection()

$conn = getOracleConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

// Main query: job + company. Use TO_NUMBER(:id_str) so Oracle receives exact value.
$sql = "
SELECT jp.ID,
       jp.COMPANY_ID,
       jp.COMPANY_NAME as JOB_COMPANY_NAME,
       jp.JOB_TYPE,
       jp.JOB_ROLE,
       TO_CHAR(jp.JOB_POST_DATE, 'YYYY-MM-DD\"T\"HH24:MI:SS') AS JOB_POST_DATE,
       TO_CHAR(jp.APPLY_BEFORE, 'YYYY-MM-DD\"T\"HH24:MI:SS') AS APPLY_BEFORE,
       jp.JOB_DESCRIPTION,
       jp.WHY_JOIN_US,
       jp.KEY_RESPONSIBILITIES,
       jp.WHAT_WE_ARE_LOOKING_FOR,
       jp.WORKING_ENVIRONMENT,
       jp.QUALIFICATIONS,
       jp.ADDRESS,
       jp.PHONE,
       jp.EMAIL AS JOB_EMAIL,
       jp.WEBSITE_LINK,
       jp.MAP_LINK,
       jp.EMPLOYEE_CAPACITY,
       c.ID AS COMPANY_ID_REAL,
       c.EMAIL AS COMPANY_EMAIL,
       c.COMPANY_NAME AS COMPANY_OFFICIAL_NAME,
       c.CONTACT_NUMBER AS COMPANY_CONTACT_NUMBER,
       c.ADDRESS AS COMPANY_ADDRESS,
       c.INDUSTRY,
       c.STATUS AS COMPANY_STATUS,
       c.COMPANY_PROOF,
       jp.COMPANY_IMAGE
FROM MVSG.JOB_POSTINGS jp
LEFT JOIN MVSG.COMPANY c ON jp.COMPANY_ID = c.ID
WHERE jp.ID = TO_NUMBER(:id_str)
";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':id_str', $id_str, -1); // bind string (digits) and let TO_NUMBER convert
$r = oci_execute($stid);
if (!$r) {
    $e = oci_error($stid);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Query failed', 'details' => $e ? $e['message'] : null]);
    exit;
}

$row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS);
if (!$row) {
    http_response_code(404);
    // include received id for debug so you can confirm frontend/server values (remove in production)
    echo json_encode(['success' => false, 'error' => 'Job not found', 'queried_id' => $id_str]);
    exit;
}

// Handle BLOB -> base64 data URI for COMPANY_IMAGE (logo)
function blob_to_data_uri($blob)
{
    if (!$blob) return null;
    if (is_object($blob) && method_exists($blob, 'load')) {
        $data = $blob->load();
    } else {
        $data = $blob;
    }
    if ($data === null || $data === '') return null;

    // try detect mime type
    $mime = null;
    if (function_exists('finfo_open')) {
        $f = finfo_open(FILEINFO_MIME_TYPE);
        if ($f !== false) {
            $m = finfo_buffer($f, $data);
            if ($m) $mime = $m;
            finfo_close($f);
        }
    }

    // fallback to image/png for compatibility with get-jobs.php
    if (!$mime) $mime = 'image/png';

    return 'data:' . $mime . ';base64,' . base64_encode($data);
}

$companyImageDataUri = blob_to_data_uri($row['COMPANY_IMAGE'] ?? $row['COMPANY_PROOF'] ?? null);

// --- NEW: provide `logo` field similar to get-jobs.php (use placeholder if missing)
$logo = $companyImageDataUri;
if (!$logo) {
    // same placeholder used by get-jobs.php
    $logo = "https://via.placeholder.com/150?text=Logo";
}

// Get job managers (all) — use TO_NUMBER binding as well
$managers = [];
$sql2 = "SELECT ID, JOB_POSTING_ID, FIRST_NAME, MIDDLE_NAME, LAST_NAME, ROLE, TO_CHAR(CREATED_AT,'YYYY-MM-DD\"T\"HH24:MI:SS') AS CREATED_AT, TO_CHAR(UPDATED_AT,'YYYY-MM-DD\"T\"HH24:MI:SS') AS UPDATED_AT FROM MVSG.JOB_MANAGERS WHERE JOB_POSTING_ID = TO_NUMBER(:id_str) ORDER BY ID";
$stid2 = oci_parse($conn, $sql2);
oci_bind_by_name($stid2, ':id_str', $id_str, -1);
oci_execute($stid2);
while ($m = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $managers[] = $m;
}

// Build response: include all possible fields from schema (fill nulls if not present)
$response = [
    'success' => true,
    'job' => [
        'id' => isset($row['ID']) ? $row['ID'] : null,
        'company_id' => isset($row['COMPANY_ID']) ? $row['COMPANY_ID'] : null,
        'company_name_from_job' => $row['JOB_COMPANY_NAME'] ?? null,
        'job_type' => $row['JOB_TYPE'] ?? null,
        'job_role' => $row['JOB_ROLE'] ?? null,
        'job_post_date' => $row['JOB_POST_DATE'] ?? null,
        'apply_before' => $row['APPLY_BEFORE'] ?? null,
        'job_description' => $row['JOB_DESCRIPTION'] ?? null,
        'why_join_us' => $row['WHY_JOIN_US'] ?? null,
        'key_responsibilities' => $row['KEY_RESPONSIBILITIES'] ?? null,
        'what_we_are_looking_for' => $row['WHAT_WE_ARE_LOOKING_FOR'] ?? null,
        'working_environment' => $row['WORKING_ENVIRONMENT'] ?? null,
        'qualifications' => $row['QUALIFICATIONS'] ?? null,
        'address' => $row['ADDRESS'] ?? null,
        'phone' => $row['PHONE'] ?? null,
        'email' => $row['JOB_EMAIL'] ?? null,
        'website_link' => $row['WEBSITE_LINK'] ?? null,
        'map_link' => $row['MAP_LINK'] ?? null,
        'employee_capacity' => isset($row['EMPLOYEE_CAPACITY']) ? $row['EMPLOYEE_CAPACITY'] : null,
        'company_image_data_uri' => $companyImageDataUri,
    ],
    'company' => [
        'id' => isset($row['COMPANY_ID_REAL']) ? $row['COMPANY_ID_REAL'] : null,
        'email' => $row['COMPANY_EMAIL'] ?? null,
        'official_name' => $row['COMPANY_OFFICIAL_NAME'] ?? null,
        'contact_number' => $row['COMPANY_CONTACT_NUMBER'] ?? null,
        'address' => $row['COMPANY_ADDRESS'] ?? null,
        'industry' => $row['INDUSTRY'] ?? null,
        'status' => $row['COMPANY_STATUS'] ?? null,
        'logo' => $logo,
    ],
    'managers' => $managers
];

echo json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

// close connection/statements
@oci_free_statement($stid);
@oci_free_statement($stid2);
@oci_close($conn);
?>