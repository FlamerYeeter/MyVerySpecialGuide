<?php
$sessionStarted = session_status() === PHP_SESSION_ACTIVE;
if (!$sessionStarted) session_start();
header('Content-Type: application/json');
require_once 'oracledb.php';

// allow caller to supply guardian_id in request body (JSON) or query param when no PHP session is available
$rawInput = file_get_contents('php://input');
$body = null;
if ($rawInput) {
    $body = json_decode($rawInput, true);
}

$id = null;
// priority: JSON body -> query param -> PHP session
if (!empty($body) && !empty($body['guardian_id'])) {
    $id = $body['guardian_id'];
    $id_source = 'json_body';
} elseif (!empty($_REQUEST['guardian_id'])) {
    $id = $_REQUEST['guardian_id'];
    $id_source = 'request_param';
} elseif (!empty($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];
    $id_source = 'session';
}

if (empty($id)) {
    // helpful debug info to aid client troubleshooting
    $debug = [
        'id_source' => isset($id_source) ? $id_source : null,
        'session_user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null,
        'body_present' => $body ? true : false,
        'request_guardian_id' => isset($_REQUEST['guardian_id']) ? $_REQUEST['guardian_id'] : null
    ];
    echo json_encode(['success' => false, 'error' => 'Not logged in', 'debug' => $debug]);
    exit;
}
$conn = getOracleConnection();
if (!$conn) {
    echo json_encode(['success'=>false,'error'=>'DB connect failed']);
    exit;
}

$sql = "SELECT id,
               first_name, last_name, middle_name, email, contact_number, TO_CHAR(date_of_birth,'YYYY-MM-DD') AS DATE_OF_BIRTH, address,
               types_of_ds, cdd_type,
               guardian_first_name, guardian_middle_name, guardian_last_name, guardian_email,
               TO_CHAR(guardian_birthdate,'YYYY-MM-DD') AS GUARDIAN_BIRTHDATE,
               guardian_contact_number, guardian_cell_number, guardian_home_number, guardian_work_number, guardian_work_address,
               username, relationship_to_user,
               PWD_ID, med_certificates, certificates, proof_of_membership,
               school, education, education_course, year_start, year_end,
               spouse_first_name, spouse_middle_name, spouse_last_name, spouse_email,
               spouse_cell_number, spouse_home_number, spouse_work_number, spouse_work_address, TO_CHAR(spouse_birthdate,'YYYY-MM-DD') AS SPOUSE_BIRTHDATE, spouse_relationship_to_user,
               job_preference, approval_status, prog_status, expert_id, age
    FROM user_guardian
    WHERE id = :id";
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':id', $id);
oci_execute($stid);

// return LOBs as strings using OCI_RETURN_LOBS
$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_LOBS);

if (!$row) {
    echo json_encode(['success'=>false,'error'=>'User not found']);
    oci_free_statement($stid);
    oci_close($conn);
    exit;
}

// Build files payload and include raw lengths for debugging
$files = [];
$file_lengths = [
    'proof_len' => 0,
    'med_len' => 0,
    'other_len' => 0,
    'proof_of_membership_len' => 0,
];

if (!empty($row['PWD_ID'])) {
    $files['proof'] = base64_encode($row['PWD_ID']);
    $file_lengths['proof_len'] = strlen($row['PWD_ID']);
}
if (!empty($row['MED_CERTIFICATES'])) {
    $files['med'] = base64_encode($row['MED_CERTIFICATES']);
    $file_lengths['med_len'] = strlen($row['MED_CERTIFICATES']);
}
if (!empty($row['CERTIFICATES'])) {
    $files['other_certs'] = base64_encode($row['CERTIFICATES']);
    // provide a conventional alias 'other' so clients checking 'other' find the blob
    $files['other'] = $files['other_certs'];
    $file_lengths['other_len'] = strlen($row['CERTIFICATES']);
}
// If CERTIFICATES LOB is empty (length 0) try falling back to guardian_certificates table
if ((empty($files['other']) || (isset($file_lengths['other_len']) && $file_lengths['other_len'] == 0))) {
    try {
        $qc = "SELECT certificate FROM (SELECT certificate FROM guardian_certificates WHERE guardian_id = :gid AND NVL(dbms_lob.getlength(certificate),0) > 0 ORDER BY created_at) WHERE ROWNUM = 1";
        $stc = oci_parse($conn, $qc);
        if ($stc) {
            oci_bind_by_name($stc, ':gid', $id);
            if (oci_execute($stc)) {
                $crow = oci_fetch_array($stc, OCI_ASSOC + OCI_RETURN_LOBS);
                if ($crow && !empty($crow['CERTIFICATE'])) {
                    $files['other'] = base64_encode($crow['CERTIFICATE']);
                    $files['other_certs'] = $files['other_certs'] ?? $files['other'];
                    $file_lengths['other_len'] = strlen($crow['CERTIFICATE']);
                }
            }
            oci_free_statement($stc);
        }
    } catch (Exception $e) { /* ignore fallback failures */ }
}
if (!empty($row['PROOF_OF_MEMBERSHIP'])) {
    $files['proof_of_membership'] = base64_encode($row['PROOF_OF_MEMBERSHIP']);
    $file_lengths['proof_of_membership_len'] = strlen($row['PROOF_OF_MEMBERSHIP']);
}

// remove raw blobs from $row to keep JSON smaller (they are in $files now)
// remove raw blobs from $row to keep JSON smaller (they are in $files now)
unset($row['PWD_ID'], $row['MED_CERTIFICATES'], $row['CERTIFICATES'], $row['PROOF_OF_MEMBERSHIP']);
$parseMaybeJson = function($v) {
    if ($v === null) return '';
    if (is_array($v) || is_object($v)) return $v;
    if (!is_string($v)) return $v;
    $s = trim($v);
    if ($s === '') return '';
    if (($s[0] === '{') || ($s[0] === '[')) {
        $dec = json_decode($s, true);
        if (json_last_error() === JSON_ERROR_NONE) return $dec;
    }
    return $v;
};

$row['EDUCATION_LEVEL'] = isset($row['EDUCATION']) ? $parseMaybeJson($row['EDUCATION']) : '';
$row['SCHOOL_NAME']     = isset($row['SCHOOL']) ? $parseMaybeJson($row['SCHOOL']) : '';
// also expose course and year columns (may be scalar or JSON)
$row['EDUCATION_COURSE'] = isset($row['EDUCATION_COURSE']) ? $parseMaybeJson($row['EDUCATION_COURSE']) : '';
$row['YEAR_START'] = isset($row['YEAR_START']) ? $parseMaybeJson($row['YEAR_START']) : '';
$row['YEAR_END'] = isset($row['YEAR_END']) ? $parseMaybeJson($row['YEAR_END']) : '';
$row['CERTIFICATES_UPLOADED'] = (!empty($files['other_certs'])) ? true : false;
echo json_encode([
    'success' => true,
    'user' => $row,
    'debug' => [ 'id_source' => isset($id_source) ? $id_source : null, 'id_used' => $id, 'session_user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null ],
    'files' => $files,
    'file_lengths' => $file_lengths
]);

oci_free_statement($stid);
oci_close($conn);
?>