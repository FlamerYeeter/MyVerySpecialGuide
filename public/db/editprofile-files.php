<?php
session_start();
header('Content-Type: application/json');
require_once 'oracledb.php';

if (empty($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Not logged in']);
    exit;
}

$id = $_SESSION['user_id'];
$conn = getOracleConnection();
if (!$conn) {
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

$allowedCols = [
    'proof' => 'PROOF_OF_MEMBERSHIP',
    'med'   => 'MED_CERTIFICATES',
    'other' => 'CERTIFICATES'
];

$allowedMime = [
    'application/pdf',
    'image/png',
    'image/jpeg',
    'image/jpg'
];
$maxBytes = 10 * 1024 * 1024; // 10 MB

$results = [];
$any = false;

function update_blob_column($conn, $id, $colName, $binaryData) {
    // Prepare statement that returns the LOB locator so we can save into it
    $sql = "UPDATE user_guardian SET {$colName} = EMPTY_BLOB() WHERE id = :id RETURNING {$colName} INTO :blob";
    $stid = oci_parse($conn, $sql);
    if (!$stid) return ['ok' => false, 'error' => 'OCI parse failed'];

    $lob = oci_new_descriptor($conn, OCI_D_LOB);
    oci_bind_by_name($stid, ':id', $id);
    oci_bind_by_name($stid, ':blob', $lob, -1, OCI_B_BLOB);

    if (!oci_execute($stid, OCI_DEFAULT)) {
        $err = oci_error($stid);
        $lob->free();
        oci_free_statement($stid);
        return ['ok' => false, 'error' => $err ? $err['message'] : 'Execute failed'];
    }

    // save binary into the returned LOB locator
    $ok = $lob->save($binaryData);
    if (!$ok) {
        $lob->free();
        oci_free_statement($stid);
        return ['ok' => false, 'error' => 'LOB save failed'];
    }

    // commit
    if (!oci_commit($conn)) {
        $err = oci_error($conn);
        $lob->free();
        oci_free_statement($stid);
        return ['ok' => false, 'error' => $err ? $err['message'] : 'Commit failed'];
    }

    $len = strlen($binaryData);
    $lob->free();
    oci_free_statement($stid);
    return ['ok' => true, 'length' => $len];
}

// Accept multipart/form-data file uploads (input names: proof, med, other)
// Also accept base64 JSON body (optional) with keys proof_b64, med_b64, other_b64
foreach ($allowedCols as $key => $col) {
    // multipart upload
    if (!empty($_FILES[$key]) && is_uploaded_file($_FILES[$key]['tmp_name'])) {
        $file = $_FILES[$key];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $results[$key] = ['ok' => false, 'error' => 'File upload error code '.$file['error']];
            continue;
        }
        if ($file['size'] > $maxBytes) {
            $results[$key] = ['ok' => false, 'error' => 'File too large'];
            continue;
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, $allowedMime)) {
            $results[$key] = ['ok' => false, 'error' => 'Invalid file type: '.$mime];
            continue;
        }
        $data = file_get_contents($file['tmp_name']);
        $res = update_blob_column($conn, $id, $col, $data);
        $results[$key] = $res;
        $any = $any || ($res['ok'] ?? false);
        continue;
    }

    // JSON base64 fallback
    $body = file_get_contents('php://input');
    if ($body) {
        $json = json_decode($body, true);
        if (is_array($json)) {
            $b64Key = $key . '_b64';
            if (!empty($json[$b64Key])) {
                $data = base64_decode($json[$b64Key], true);
                if ($data === false) {
                    $results[$key] = ['ok' => false, 'error' => 'Invalid base64 for '.$b64Key];
                    continue;
                }
                if (strlen($data) > $maxBytes) {
                    $results[$key] = ['ok' => false, 'error' => 'File too large'];
                    continue;
                }
                $res = update_blob_column($conn, $id, $col, $data);
                $results[$key] = $res;
                $any = $any || ($res['ok'] ?? false);
                continue;
            }
        }
    }
}

// If nothing uploaded/provided
if (!$any && empty($results)) {
    echo json_encode(['success' => false, 'error' => 'No files provided']);
    oci_close($conn);
    exit;
}

// Build summary
$summary = ['success' => $any, 'results' => $results];

// If at least one succeeded, return overall success true
if ($any) {
    http_response_code(200);
} else {
    http_response_code(400);
}

echo json_encode($summary);

oci_close($conn);
?>