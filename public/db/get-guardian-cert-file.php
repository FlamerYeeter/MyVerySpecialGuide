<?php
require_once 'oracledb.php';
$raw = file_get_contents('php://input');
$body = json_decode($raw, true);
// accept explicit cert_id first for clarity, fall back to id for compatibility
$id = $body['cert_id'] ?? $body['id'] ?? $_GET['cert_id'] ?? $_GET['id'] ?? null;

// expect a numeric certificate ID
if (!$id || !preg_match('/^\d+$/', (string)$id)) {
    http_response_code(400);
    echo 'Invalid id';
    exit;
}

$conn = getOracleConnection();
if (!$conn) { http_response_code(500); echo 'DB connect failed'; exit; }

try {
    $sql = "SELECT id, name, certificate FROM guardian_certificates WHERE id = TO_NUMBER(:id)";
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
    // compute blob length safely
    $data = $row['CERTIFICATE'] ?? null;
    $blob_length = is_string($data) ? strlen($data) : 0;
    // If debug requested, always return JSON describing found row and blob length
    if (isset($_GET['debug']) && $_GET['debug'] == '1') {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => true,
            'id' => $id,
            'found' => (bool)$row,
            'blob_length' => $blob_length,
            'name' => $row['NAME'] ?? null,
        ], JSON_PRETTY_PRINT);
        exit;
    }
    // Non-debug: return file only when blob has content
    if (!$row || $blob_length === 0) { http_response_code(404); echo 'No file'; exit; }
} catch (Throwable $ex) {
    error_log('get-guardian-cert-file error: ' . $ex->getMessage());
    if (isset($stid) && is_resource($stid)) @oci_free_statement($stid);
    if (isset($conn) && is_resource($conn)) @oci_close($conn);
    http_response_code(500);
    echo 'Internal server error';
    exit;
}
    // Robust MIME detection: prefer finfo but fall back to header signature checks
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($data) ?: 'application/octet-stream';
    if ($mime === 'application/octet-stream' || empty($mime)) {
        $sig = substr($data, 0, 8);
        if (strpos($sig, '%PDF') === 0) {
            $mime = 'application/pdf';
        } elseif (substr($sig,0,3) === "\xFF\xD8\xFF") {
            $mime = 'image/jpeg';
        } elseif ($sig === "\x89PNG\r\n\x1A\n") {
            $mime = 'image/png';
        } elseif (substr($sig,0,4) === 'GIF8') {
            $mime = 'image/gif';
        }
    }
    $extMap = ['application/pdf'=>'pdf','image/png'=>'png','image/jpeg'=>'jpg','image/gif'=>'gif'];
    $ext = $extMap[$mime] ?? 'pdf';
$filename = preg_replace('/[^a-z0-9_\-\.]/i','_', ($row['NAME'] ?? 'certificate')) . '.' . $ext;
header('Content-Type: ' . $mime);
header('Content-Length: ' . strlen($data));
header('Content-Disposition: inline; filename="' . $filename . '"');
echo $data;
exit;
?>