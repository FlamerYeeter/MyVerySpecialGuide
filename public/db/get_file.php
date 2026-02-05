<?php
$sessionStarted = session_status() === PHP_SESSION_ACTIVE;
if (!$sessionStarted) session_start();
require_once 'oracledb.php';

// support multiple session keys used across the app
$id = $_SESSION['user_id'] ?? $_SESSION['guardian_id'] ?? $_SESSION['user_guardian_id'] ?? $_SESSION['id'] ?? null;
if (empty($id)) {
    header('HTTP/1.1 401 Unauthorized');
    echo 'Not logged in';
    exit;
}
$type = $_GET['type'] ?? 'proof'; // 'proof' | 'med' | 'other'
$colMap = [
    'proof' => ['col'=>'PWD_ID','name'=>'proof.pdf'],
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
$sql = "SELECT id, username, " . $colMap[$type]['col'] . " AS FILEBLOB FROM user_guardian WHERE id = :id";
$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':id', $id);
oci_execute($stid);
$row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_LOBS);
oci_free_statement($stid);
oci_close($conn);
// debug support: allow overriding id when testing locally
$debug = isset($_GET['debug']) && in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1']);
if ($debug && isset($_GET['id'])) {
    // re-run query for the debug id to provide immediate info
    $debugId = $_GET['id'];
    $conn = getOracleConnection();
    if ($conn) {
        $sql2 = "SELECT id, username, " . $colMap[$type]['col'] . " AS FILEBLOB FROM user_guardian WHERE id = :did";
        $stid2 = oci_parse($conn, $sql2);
        oci_bind_by_name($stid2, ':did', $debugId);
        oci_execute($stid2);
        $row = oci_fetch_array($stid2, OCI_ASSOC + OCI_RETURN_LOBS);
        oci_free_statement($stid2);
        oci_close($conn);
        $id = $debugId;
    }
}

if (!$row || empty($row['FILEBLOB'])) {
    if ($debug) {
        header('Content-Type: application/json');
        $len = ($row && isset($row['FILEBLOB']) && is_string($row['FILEBLOB'])) ? strlen($row['FILEBLOB']) : 0;
        echo json_encode([
            'success' => false,
            'message' => 'No file for requested id',
            'requested_id' => $id,
            'found_row' => (bool)$row,
            'blob_length' => $len,
            'row_sample' => $row ? array_diff_key($row, array_filter($row, 'is_string')) : null
        ], JSON_PRETTY_PRINT);
        exit;
    }
    header('HTTP/1.1 404 Not Found');
    echo 'No file';
    exit;
}
$data = $row['FILEBLOB'];
// detect MIME type from binary data and choose a sensible filename/extension
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->buffer($data) ?: 'application/octet-stream';
$extMap = [
    'application/pdf' => 'pdf',
    'image/png'       => 'png',
    'image/jpeg'      => 'jpg',
    'image/gif'       => 'gif',
];
$ext = isset($extMap[$mime]) ? $extMap[$mime] : 'bin';
$baseName = pathinfo($colMap[$type]['name'], PATHINFO_FILENAME);
$filename = $baseName . '.' . $ext;
header('Content-Type: ' . $mime);
header('Content-Length: ' . strlen($data));
header('Content-Disposition: inline; filename="' . $filename . '"');
echo $data;
exit;
?>