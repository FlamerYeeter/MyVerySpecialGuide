<?php
// repair-job-cert.php
// Admin helper: write a file from public/uploads into job_experience.workexp_certificate LOB
header('Content-Type: application/json; charset=utf-8');
require_once 'oracledb.php';

$raw = file_get_contents('php://input');
$body = json_decode($raw, true) ?: [];
$id = $body['id'] ?? $body['job_id'] ?? null;
$filename = $body['filename'] ?? null;

if (!$id || !preg_match('/^\d+$/', (string)$id)) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'invalid id']);
    exit;
}
if (!$filename) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'missing filename']);
    exit;
}

$uploadsDir = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;
$path = realpath($uploadsDir . $filename);
if (!$path || strpos($path, realpath($uploadsDir)) !== 0 || !is_file($path)) {
    http_response_code(400);
    echo json_encode(['success'=>false,'error'=>'file not found']);
    exit;
}

$data = @file_get_contents($path);
if ($data === false) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>'failed to read file']);
    exit;
}

$conn = getOracleConnection();
if (!$conn) { http_response_code(500); echo json_encode(['success'=>false,'error'=>'db connect failed']); exit; }

try {
    $sel = "SELECT workexp_certificate FROM job_experience WHERE id = :id FOR UPDATE";
    $stid = oci_parse($conn, $sel);
    oci_bind_by_name($stid, ':id', $id);
    if (!oci_execute($stid, OCI_NO_AUTO_COMMIT)) {
        $e = oci_error($stid);
        throw new Exception('select failed: ' . ($e['message'] ?? json_encode($e)));
    }
    if (!oci_fetch($stid)) {
        throw new Exception('no row');
    }
    $lob = oci_result($stid, 'WORKEXP_CERTIFICATE');
    if (!is_object($lob)) {
        throw new Exception('LOB locator not available');
    }
    // write into the LOB locator
    if (method_exists($lob, 'write')) {
        $rv = @$lob->write($data);
        if ($rv === false) throw new Exception('LOB write() failed');
    } elseif (method_exists($lob, 'writeTemporary')) {
        $rv = @$lob->writeTemporary($data, OCI_TEMP_BLOB);
        if ($rv === false) throw new Exception('LOB writeTemporary() failed');
    } elseif (method_exists($lob, 'saveTemporary')) {
        $rv = @$lob->saveTemporary($data, OCI_TEMP_BLOB);
        if ($rv === false) throw new Exception('LOB saveTemporary() failed');
    } else {
        throw new Exception('no suitable write method on LOB');
    }
    oci_free_statement($stid);
    $comm = oci_commit($conn);
    if (!$comm) {
        $ce = oci_error($conn) ?: oci_error();
        throw new Exception('commit failed: ' . json_encode($ce));
    }
    oci_close($conn);
    echo json_encode(['success'=>true,'id'=>$id,'filename'=>$filename,'bytes'=>strlen($data)]);
    exit;
} catch (Throwable $ex) {
    if (isset($stid) && is_resource($stid)) @oci_free_statement($stid);
    if (isset($conn) && is_resource($conn)) @oci_close($conn);
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$ex->getMessage()]);
    exit;
}

?>
