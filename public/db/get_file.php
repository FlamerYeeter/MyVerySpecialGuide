<?php
session_start();
require_once 'oracledb.php';
if (empty($_SESSION['user_id'])) {
    header('HTTP/1.1 401 Unauthorized');
    echo 'Not logged in';
    exit;
}
$id = $_SESSION['user_id'];
$type = $_GET['type'] ?? 'proof'; // 'proof' | 'med' | 'other'
$colMap = [
    'proof' => ['col'=>'PROOF_OF_MEMBERSHIP','name'=>'proof.pdf'],
    'med'   => ['col'=>'MED_CERTIFICATES','name'=>'medical.pdf'],
    'other' => ['col'=>'CERTIFICATES','name'=>'certificates.pdf'],
];
if (!isset($colMap[$type])) {
    header('HTTP/1.1 400 Bad Request');
    echo 'Invalid file type';
    exit;
}
$conn = getOracleConnection();
if (!$conn) { header('HTTP/1.1 500 Internal Server Error'); echo 'DB connect failed'; exit; }
$sql = "SELECT " . $colMap[$type]['col'] . " AS FILEBLOB FROM user_guardian WHERE id = :id";
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':id', $id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_LOBS);
oci_free_statement($stid);
oci_close($conn);
if (!$row || empty($row['FILEBLOB'])) {
    header('HTTP/1.1 404 Not Found');
    echo 'No file';
    exit;
}
$data = $row['FILEBLOB'];
// try PDF first, fallback to octet-stream
header('Content-Type: application/pdf');
header('Content-Length: ' . strlen($data));
header('Content-Disposition: inline; filename="' . $colMap[$type]['name'] . '"');
echo $data;
exit;
?>