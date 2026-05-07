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
    'resume' => ['col'=>'PROOF_OF_MEMBERSHIP','name'=>'resume.pdf'],
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

// Helper: try to detect common file types using magic bytes or common wrappers
function detect_mime_and_ext($data) {
    if ($data === null || $data === '') return ['mime' => 'application/octet-stream', 'ext' => 'bin'];
    // If the blob looks like a data: URI
    if (is_string($data) && strlen($data) > 5 && strpos($data, 'data:') === 0) {
        if (preg_match('#^data:([^;]+);base64,(.*)$#s', $data, $m)) {
            $b64 = $m[2];
            $decoded = base64_decode($b64, true);
            if ($decoded !== false) $data = $decoded;
        }
    }
    // If the blob is ASCII base64 (no binary bytes) try to decode
    $sample = substr($data, 0, 200);
    if (preg_match('#^[A-Za-z0-9+/=\s]+$#', $sample) && strlen($data) > 200) {
        $maybe = @base64_decode(preg_replace('/\s+/', '', $data), true);
        if ($maybe !== false && strlen($maybe) > 0) $data = $maybe;
    }

    // Check magic bytes
    $bytes = substr($data, 0, 8);
    // PDF
    if (strpos($bytes, '%PDF') === 0) return ['mime' => 'application/pdf', 'ext' => 'pdf'];
    // PNG
    if (substr($bytes,0,4) === "\x89PNG") return ['mime' => 'image/png', 'ext' => 'png'];
    // JPG
    if (strlen($bytes) >= 3 && ord($bytes[0]) === 0xFF && ord($bytes[1]) === 0xD8 && ord($bytes[2]) === 0xFF) return ['mime' => 'image/jpeg', 'ext' => 'jpg'];
    // GIF
    if (strpos($bytes, 'GIF8') === 0) return ['mime' => 'image/gif', 'ext' => 'gif'];
    // ZIP-based (DOCX) - PK\x03\x04
    if (substr($bytes,0,2) === "PK") {
        // attempt to detect DOCX by looking for word/ in blob
        if (strpos($data, '[Content_Types].xml') !== false || strpos($data, 'word/') !== false) return ['mime' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'ext' => 'docx'];
        return ['mime' => 'application/zip', 'ext' => 'zip'];
    }
    // OLE Compound File (old DOC)
    if (strlen($bytes) >= 8 && ord($bytes[0]) === 0xD0 && ord($bytes[1]) === 0xCF && ord($bytes[2]) === 0x11) return ['mime' => 'application/msword', 'ext' => 'doc'];

    // Fallback to finfo
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($data) ?: 'application/octet-stream';
    $extMap = [
        'application/pdf' => 'pdf',
        'image/png'       => 'png',
        'image/jpeg'      => 'jpg',
        'image/gif'       => 'gif',
        'application/zip' => 'zip',
        'application/msword' => 'doc',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx'
    ];
    $ext = isset($extMap[$mime]) ? $extMap[$mime] : 'bin';
    return ['mime' => $mime, 'ext' => $ext];
}

$det = detect_mime_and_ext($data);
$mime = $det['mime'];
$ext = $det['ext'];

// Create a helpful filename: prefer username if present
$userPart = '';
if (!empty($row['USERNAME'])) {
    // sanitize username for filesystem
    $userPart = preg_replace('/[^A-Za-z0-9_\-]/', '_', $row['USERNAME']) . '_';
}
$baseName = $userPart . pathinfo($colMap[$type]['name'], PATHINFO_FILENAME);
$filename = $baseName . '.' . $ext;

header('Content-Type: ' . $mime);
header('Content-Length: ' . strlen($data));
header('Content-Disposition: inline; filename="' . $filename . '"');
echo $data;
exit;
?>