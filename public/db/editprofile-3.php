<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors','1');
error_reporting(E_ALL);
session_start();
require_once 'oracledb.php';

function json_err($msg, $details=null, $code=400){
    http_response_code($code);
    $o = ['success'=>false,'error'=>$msg];
    if ($details !== null) $o['details'] = $details;
    echo json_encode($o);
    exit;
}
function normArrayField($v){
    if ($v === null) return null;
    if (is_array($v)) {
        $out = [];
        foreach ($v as $it) {
            if (is_scalar($it)) {
                $s = trim((string)$it);
                if ($s !== '') $out[] = $s;
            }
        }
        return array_values(array_unique($out));
    }
    if (is_string($v)) {
        $s = trim($v);
        // try json decode stringified array
        if ($s !== '' && ($s[0] === '[' || $s[0] === '{')) {
            $dec = @json_decode($s, true);
            if (is_array($dec)) return normArrayField($dec);
        }
        if ($s === '') return [];
        // comma separated fallback
        if (strpos($s, ',') !== false) {
            $parts = array_map('trim', explode(',', $s));
            return array_values(array_filter(array_unique($parts)));
        }
        return [$s];
    }
    return [];
}

/* Read body */
$raw = @file_get_contents('php://input');
$body = null;
if ($raw !== '' && $raw !== false) {
    $body = @json_decode($raw, true);
    if ($body === null) {
        $trim = trim($raw);
        $body = @json_decode($trim, true);
    }
}
if (($body === null || $body === []) && !empty($_POST)) {
    // try to find JSON-like field
    foreach ($_POST as $v) {
        if (is_string($v) && (strpos($v,'{')===0 || strpos($v,'[')===0)) {
            $try = @json_decode($v, true);
            if (is_array($try)) { $body = $try; break; }
        }
    }
}
if ($body === null) $body = [];

/* guardian id */
$targetId = $_SESSION['guardian_id'] ?? $_SESSION['user_guardian_id'] ?? $_SESSION['user_id'] ?? null;
if (empty($targetId) && isset($body['guardian_id']) && preg_match('/^\d+$/', (string)$body['guardian_id'])) {
    $targetId = (int)$body['guardian_id'];
}
if (empty($targetId)) json_err('Not logged in or missing guardian id', null, 403);

/* normalize fields */
$skills = array_key_exists('skills', $body) ? normArrayField($body['skills']) : null;
$jobpref = array_key_exists('job_preference', $body) ? normArrayField($body['job_preference']) : null;

if ($skills === null && $jobpref === null) {
    json_err('No fields to update');
}

/* connect */
$conn = getOracleConnection();
if (!$conn) json_err('DB connect failed', null, 500);

$needCommit = false;

/* helper: delete existing for type */
$deleteStmtCache = [];
function deleteType($conn, $gid, $type){
    $sql = "DELETE FROM MVSG.USER_PROFILE WHERE GUARDIAN_ID = TO_NUMBER(:gid) AND TYPE = :typ";
    $st = oci_parse($conn, $sql);
    if (!$st) return oci_error($conn);
    oci_bind_by_name($st, ':gid', $gid);
    oci_bind_by_name($st, ':typ', $type);
    if (!@oci_execute($st, OCI_NO_AUTO_COMMIT)) {
        $err = oci_error($st) ?: oci_error($conn);
        oci_free_statement($st);
        return $err;
    }
    oci_free_statement($st);
    return true;
}

/* helper: insert one row */
function insertProfileRow($conn, $gid, $type, $val){
    $ins = oci_parse($conn, "INSERT INTO MVSG.USER_PROFILE (GUARDIAN_ID, TYPE, VALUE, CREATED_AT, UPDATED_AT) VALUES (TO_NUMBER(:gid), :typ, :val, SYSTIMESTAMP, SYSTIMESTAMP)");
    if (!$ins) return oci_error($conn);
    oci_bind_by_name($ins, ':gid', $gid);
    oci_bind_by_name($ins, ':typ', $type);
    oci_bind_by_name($ins, ':val', $val, -1);
    if (!@oci_execute($ins, OCI_NO_AUTO_COMMIT)) {
        $e = oci_error($ins) ?: oci_error($conn);
        oci_free_statement($ins);
        return $e;
    }
    oci_free_statement($ins);
    return true;
}

/* process skills */
if ($skills !== null) {
    $res = deleteType($conn, $targetId, 'skills');
    if ($res !== true) {
        oci_close($conn);
        json_err('Failed to delete existing skills', $res['message'] ?? $res, 500);
    }
    if (count($skills) > 0) {
        foreach ($skills as $v) {
            $r = insertProfileRow($conn, $targetId, 'skills', $v);
            if ($r !== true) {
                oci_rollback($conn);
                oci_close($conn);
                json_err('Failed to insert skills row', $r['message'] ?? $r, 500);
            }
        }
    }
    $needCommit = true;
}

/* process job_preference */
if ($jobpref !== null) {
    $res = deleteType($conn, $targetId, 'job_preference');
    if ($res !== true) {
        oci_close($conn);
        json_err('Failed to delete existing job_preference', $res['message'] ?? $res, 500);
    }
    if (count($jobpref) > 0) {
        foreach ($jobpref as $v) {
            $r = insertProfileRow($conn, $targetId, 'job_preference', $v);
            if ($r !== true) {
                oci_rollback($conn);
                oci_close($conn);
                json_err('Failed to insert job_preference row', $r['message'] ?? $r, 500);
            }
        }
    }
    $needCommit = true;
}

/* commit */
if ($needCommit) {
    if (!@oci_commit($conn)) {
        $e = oci_error($conn);
        oci_close($conn);
        json_err('Commit failed', $e['message'] ?? $e, 500);
    }
}

oci_close($conn);
echo json_encode(['success'=>true,'updated'=>['skills'=>$skills!==null,'job_preference'=>$jobpref!==null]]);
exit;
?>