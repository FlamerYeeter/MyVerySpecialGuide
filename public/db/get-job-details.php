<?php
header('Content-Type: application/json; charset=utf-8');
// Enable full error reporting during debugging (remove or set to 0 in production)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// start output buffering to capture unexpected output
ob_start();

// DEBUG TEMP: short-circuit to test response plumbing. REMOVE after debugging.
// echo json_encode(['debug' => 'early-exit']);
// echo "\n";
// ob_end_flush();
// exit;

// Accept either "id" or "job_id" as string to avoid integer precision loss
$id_str = $_GET['id'] ?? $_GET['job_id'] ?? null;
// basic validation: numeric string only
if (!$id_str || !preg_match('/^\d+$/', $id_str)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing or invalid job id', 'received' => $id_str]);
    exit;
}

// reject absurdly long values early to avoid DB/OCI errors and accidental output
if (strlen($id_str) > 128) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'job id too long', 'max' => 128, 'received_len' => strlen($id_str)]);
    exit;
}

// Oracle NUMBER precision is up to 38 digits; if client sends a longer numeric id
// use TO_CHAR(...) comparisons instead of TO_NUMBER(...) to avoid numeric overflow
$use_to_char_match = (strlen($id_str) > 38);

function id_condition_sql($col, $use_to_char_match) {
    if ($use_to_char_match) return "TO_CHAR($col) = :id_str";
    return "$col = TO_NUMBER(:id_str)";
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
$id_cond_main = id_condition_sql('jp.ID', $use_to_char_match);
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
WHERE $id_cond_main
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
$id_cond_managers = id_condition_sql('JOB_POSTING_ID', $use_to_char_match);
$sql2 = "SELECT ID, JOB_POSTING_ID, FIRST_NAME, MIDDLE_NAME, LAST_NAME, ROLE, TO_CHAR(CREATED_AT,'YYYY-MM-DD\"T\"HH24:MI:SS') AS CREATED_AT, TO_CHAR(UPDATED_AT,'YYYY-MM-DD\"T\"HH24:MI:SS') AS UPDATED_AT FROM MVSG.JOB_MANAGERS WHERE $id_cond_managers ORDER BY ID";
$stid2 = oci_parse($conn, $sql2);
oci_bind_by_name($stid2, ':id_str', $id_str, -1);
oci_execute($stid2);
while ($m = oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) {
    $managers[] = $m;
}

// --- NEW: fetch JOB_PROFILE entries and group by TYPE
$profiles = [];
$id_cond_profile = id_condition_sql('JOB_PROFILE.JOB_POSTING_ID', $use_to_char_match);
$sql3 = "SELECT ID, JOB_POSTING_ID, VALUE, TYPE, TO_CHAR(CREATED_AT,'YYYY-MM-DD\"T\"HH24:MI:SS') AS CREATED_AT FROM MVSG.JOB_PROFILE WHERE " . ($use_to_char_match ? "TO_CHAR(JOB_POSTING_ID) = :id_str" : "JOB_POSTING_ID = TO_NUMBER(:id_str)") . " ORDER BY ID";
$stid3 = oci_parse($conn, $sql3);
oci_bind_by_name($stid3, ':id_str', $id_str, -1);
if (@oci_execute($stid3)) {
    while ($p = oci_fetch_array($stid3, OCI_ASSOC+OCI_RETURN_LOBS)) {
        $type = strtolower(trim($p['TYPE'] ?? ''));
        $val = $p['VALUE'] ?? null;
        if ($type === '' || $val === null) continue;
        // normalize common type names
        // allow "skills", "key_responsibilities", "job_preference", "workplace", "job_positions" etc.
        if (!isset($profiles[$type])) $profiles[$type] = [];
        $profiles[$type][] = $val;
    }
}
@oci_free_statement($stid3);

// Helper: merge single DB text with profile arrays
function merge_text_and_profile_array($text, $profileArr)
{
    $out = [];
    if ($text !== null && trim($text) !== '') $out[] = $text;
    if (!empty($profileArr) && is_array($profileArr)) {
        foreach ($profileArr as $v) {
            if ($v !== null && $v !== '') $out[] = $v;
        }
    }
    return count($out) ? $out : null;
}

// Build merged fields from row + profiles
$skills_arr = $profiles['skills'] ?? null;
$positions_arr = $profiles['job_preference'] ?? ($profiles['job_positions'] ?? null);
$key_resp_arr = merge_text_and_profile_array($row['KEY_RESPONSIBILITIES'] ?? null, $profiles['key_responsibilities'] ?? null);
$working_env_arr = merge_text_and_profile_array($row['WORKING_ENVIRONMENT'] ?? null, $profiles['workplace'] ?? null);
$why_join_arr = merge_text_and_profile_array($row['WHY_JOIN_US'] ?? null, $profiles['why_join_us'] ?? ($profiles['why_join'] ?? null));
$qual_arr = merge_text_and_profile_array($row['QUALIFICATIONS'] ?? null, $profiles['qualifications'] ?? null);

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
        // prefer merged arrays where available, fall back to raw text
        'job_description' => $row['JOB_DESCRIPTION'] ?? null,
        'why_join_us' => $why_join_arr ?? ($row['WHY_JOIN_US'] ?? null),
        'key_responsibilities' => $key_resp_arr ?? ($row['KEY_RESPONSIBILITIES'] ?? null),
        'what_we_are_looking_for' => $row['WHAT_WE_ARE_LOOKING_FOR'] ?? null,
        'working_environment' => $working_env_arr ?? ($row['WORKING_ENVIRONMENT'] ?? null),
        'qualifications' => $qual_arr ?? ($row['QUALIFICATIONS'] ?? null),
        'address' => $row['ADDRESS'] ?? null,
        'phone' => $row['PHONE'] ?? null,
        'email' => $row['JOB_EMAIL'] ?? null,
        'website_link' => $row['WEBSITE_LINK'] ?? null,
        'map_link' => $row['MAP_LINK'] ?? null,
        'employee_capacity' => isset($row['EMPLOYEE_CAPACITY']) ? $row['EMPLOYEE_CAPACITY'] : null,
        'company_image_data_uri' => $companyImageDataUri,
        // expose arrays for frontend convenience
        'skills' => $skills_arr,
        'job_positions' => $positions_arr,
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
    'managers' => $managers,
    // also include raw profiles for debugging if needed
    'profiles' => $profiles
];

// Safely encode JSON and surface encoding errors (avoid silent empty body when json_encode fails)
// Ensure all strings are UTF-8 to avoid json_encode "Malformed UTF-8" errors
function utf8ize($mixed) {
    if (is_array($mixed)) {
        $out = [];
        foreach ($mixed as $k => $v) {
            $out[$k] = utf8ize($v);
        }
        return $out;
    } elseif (is_string($mixed)) {
        // detect encoding; convert to UTF-8 if needed
        $enc = mb_detect_encoding($mixed, ['UTF-8','ISO-8859-1','WINDOWS-1252','ASCII'], true);
        if ($enc !== 'UTF-8') {
            return mb_convert_encoding($mixed, 'UTF-8', $enc ?: 'UTF-8');
        }
        // remove invalid UTF-8 sequences
        return mb_convert_encoding($mixed, 'UTF-8', 'UTF-8');
    } else {
        return $mixed;
    }
}

$response = utf8ize($response);
$out = json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
if ($out === false) {
    $err = json_last_error_msg();
    // fallback: try to convert problematic objects to strings minimally
    echo json_encode(['success' => false, 'error' => 'json_encode failed', 'json_error' => $err, 'response_debug' => array_keys($response)]);
} else {
    echo $out;
}

// close connection/statements
@oci_free_statement($stid);
@oci_free_statement($stid2);
@oci_close($conn);
?>