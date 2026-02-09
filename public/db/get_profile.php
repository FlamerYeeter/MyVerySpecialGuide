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

$sql = "SELECT id, first_name, last_name, email, contact_number, TO_CHAR(date_of_birth,'YYYY-MM-DD') AS DATE_OF_BIRTH, address,
           types_of_ds, cdd_type,
           guardian_first_name, guardian_last_name, guardian_email,
           guardian_contact_number, username, relationship_to_user,
           PWD_ID, med_certificates, certificates, school, education
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
    $file_lengths['other_len'] = strlen($row['CERTIFICATES']);
}

// remove raw blobs from $row to keep JSON smaller (they are in $files now)
unset($row['PWD_ID'], $row['MED_CERTIFICATES'], $row['CERTIFICATES']);
$row['EDUCATION_LEVEL'] = isset($row['EDUCATION']) ? $row['EDUCATION'] : '';
$row['SCHOOL_NAME']     = isset($row['SCHOOL']) ? $row['SCHOOL'] : '';
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