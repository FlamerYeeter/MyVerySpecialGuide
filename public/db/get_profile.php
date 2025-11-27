<?php
session_start();
header('Content-Type: application/json');
require_once 'oracledb.php';

if (empty($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$id = $_SESSION['user_id'];
$conn = getOracleConnection();
if (!$conn) {
    echo json_encode(['success'=>false,'error'=>'DB connect failed']);
    exit;
}

// include LOB columns; do NOT return password
$sql = "SELECT id, first_name, last_name, email, contact_number, age, address,
               types_of_ds, guardian_first_name, guardian_last_name, guardian_email,
               guardian_contact_number, username, relationship_to_user,
               proof_of_membership, med_certificates, certificates, school, education
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

if (!empty($row['PROOF_OF_MEMBERSHIP'])) {
    $files['proof'] = base64_encode($row['PROOF_OF_MEMBERSHIP']);
    $file_lengths['proof_len'] = strlen($row['PROOF_OF_MEMBERSHIP']);
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
unset($row['PROOF_OF_MEMBERSHIP'], $row['MED_CERTIFICATES'], $row['CERTIFICATES']);
$row['EDUCATION_LEVEL'] = isset($row['EDUCATION']) ? $row['EDUCATION'] : '';
$row['SCHOOL_NAME']     = isset($row['SCHOOL']) ? $row['SCHOOL'] : '';
$row['CERTIFICATES_UPLOADED'] = (!empty($files['other_certs'])) ? true : false;
echo json_encode([
    'success' => true,
    'user' => $row,
    'files' => $files,
    'file_lengths' => $file_lengths
]);

oci_free_statement($stid);
oci_close($conn);
?>