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
    // Ensure we have raw string data (handle OCI-Lob or resource)
    if (is_object($data) && method_exists($data, 'load')) {
        $data = $data->load();
    } elseif (is_resource($data)) {
        $data = stream_get_contents($data);
    }

    // If compression is enabled in PHP, disable it for this response to avoid binary corruption
    if (ini_get('zlib.output_compression')) {
        ini_set('zlib.output_compression', '0');
    }

    // If there is accidental leading output (BOM, whitespace, warnings), try to locate
    // the real file signature and strip everything before it. This fixes many "cannot open PDF" cases.
    $signatures = [
        "%PDF" => 'application/pdf',
        "\xFF\xD8\xFF" => 'image/jpeg',
        "\x89PNG\r\n\x1A\n" => 'image/png',
        'GIF8' => 'image/gif',
    ];

    $foundSigMime = null;
    foreach ($signatures as $sig => $sigMime) {
        $pos = strpos($data, $sig);
        if ($pos !== false) {
            if ($pos > 0) {
                $data = substr($data, $pos);
            }
            $foundSigMime = $sigMime;
            break;
        }
    }

    // Robust MIME detection: prefer signature detection, then finfo, then fallback
    if ($foundSigMime) {
        $mime = $foundSigMime;
    } else {
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
    }
    $extMap = ['application/pdf'=>'pdf','image/png'=>'png','image/jpeg'=>'jpg','image/gif'=>'gif'];
    $ext = $extMap[$mime] ?? 'pdf';
$filename = 'workexp_' . $id . '.' . $ext;
    // Clear (and disable) output buffering to avoid corrupting binary output
    if (function_exists('ob_get_level') && ob_get_level()) {
        while (ob_get_level()) { @ob_end_clean(); }
    }

    header('Content-Type: ' . $mime);
    header('Content-Length: ' . strlen($data));
    header('Content-Disposition: inline; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');

    echo $data;
    exit;