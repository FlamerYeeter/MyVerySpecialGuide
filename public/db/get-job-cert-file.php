<?php
require_once 'oracledb.php';
$raw = file_get_contents('php://input');
$body = json_decode($raw, true);
$id = $body['id'] ?? $_GET['id'] ?? null;

// Basic validation: accept numeric ids or short alphanumeric ids (avoid extremely long values)
if (!$id || !is_string((string)$id) || !preg_match('/^[A-Za-z0-9_\-]+$/', (string)$id) || strlen((string)$id) > 128) {
    http_response_code(400);
    echo 'Invalid id';
    exit;
}

$conn = getOracleConnection();
if (!$conn) { http_response_code(500); echo 'DB connect failed'; exit; }

try {
    $sql = "SELECT id, workexp_certificate FROM job_experience WHERE id = :id";
    $stid = oci_parse($conn, $sql);
    if (!$stid) {
        $e = oci_error($conn);
        throw new Exception('Query prepare failed: ' . ($e['message'] ?? '')); 
    }
    oci_bind_by_name($stid, ':id', $id);
    $r = @oci_execute($stid);
    if (!$r) {
        $e = oci_error($stid);
        throw new Exception('Query execute failed: ' . ($e['message'] ?? ''));
    }
    $row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_LOBS);
    oci_free_statement($stid);
    oci_close($conn);
    if (!$row || empty($row['WORKEXP_CERTIFICATE'])) { http_response_code(404); echo 'No file'; exit; }
    $data = $row['WORKEXP_CERTIFICATE'];
    // If debug requested, output JSON metadata instead of streaming binary
    if (isset($_GET['debug']) && $_GET['debug'] == '1') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'id' => $id,
            'found' => (bool)$row,
            'blob_length' => is_string($data) ? strlen($data) : 0,
        ], JSON_PRETTY_PRINT);
        exit;
    }
} catch (Throwable $ex) {
    // avoid exposing internal errors to the browser; log and return 500
    error_log('get-job-cert-file error: ' . $ex->getMessage());
    if (isset($stid) && is_resource($stid)) @oci_free_statement($stid);
    if (isset($conn) && is_resource($conn)) @oci_close($conn);
    http_response_code(500);
    echo 'Internal server error';
    exit;
}
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->buffer($data) ?: 'application/octet-stream';
$extMap = ['application/pdf'=>'pdf','image/png'=>'png','image/jpeg'=>'jpg','image/gif'=>'gif'];
$ext = $extMap[$mime] ?? 'bin';
$filename = 'workexp_' . $id . '.' . $ext;
header('Content-Type: ' . $mime);
header('Content-Length: ' . strlen($data));
header('Content-Disposition: inline; filename="' . $filename . '"');
echo $data;
exit;
?>