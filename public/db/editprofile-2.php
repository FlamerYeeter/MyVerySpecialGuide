<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '1'); // change to 0 in production
error_reporting(E_ALL);
session_start();
require_once 'oracledb.php';

/* ---------- helpers ---------- */
function json_err($msg, $details = null, $code = 400) {
    http_response_code($code);
    $out = ['success'=>false,'error'=>$msg];
    if ($details !== null) $out['details'] = $details;
    echo json_encode($out);
    exit;
}
function safe_trim_scalar($v) {
    if (is_null($v)) return '';
    if (is_scalar($v)) return trim((string)$v);
    return '';
}

// decode data URLs or raw base64 into binary string for LOB writing
function base64ToBlob($input) {
    if (empty($input)) return null;
    // if array, try first element or objects with 'data'/'file'
    if (is_array($input)) {
        $first = null;
        foreach ($input as $it) { $first = $it; break; }
        $input = $first;
    }
    if (!is_string($input)) return null;
    // if JSON array encoded in string, try decode
    $maybe = @json_decode($input, true);
    if (is_string($maybe)) $input = $maybe;
    if (is_array($maybe)) {
        // take first item
        foreach ($maybe as $it) { if (is_string($it)) { $input = $it; break; } if (is_array($it) && !empty($it['data'])) { $input = $it['data']; break; } }
    }
    if (($pos = strpos($input, ',')) !== false) $input = substr($input, $pos + 1);
    $data = base64_decode($input, true);
    return ($data === false) ? null : $data;
}

/* ---------- read body robustly ---------- */
$raw = @file_get_contents('php://input');
$body = null;
if ($raw !== '' && $raw !== false) {
    $body = @json_decode($raw, true);
    if ($body === null || (is_array($body) && array_values($body) === $body && count($body) === 0)) {
        $trimmed = trim($raw, "\x00..\x1F\x7F..\xFF");
        $body = @json_decode($trimmed, true);
    }
}
if (($body === null || $body === []) && !empty($_POST)) {
    // check for a JSON-like POST field
    foreach ($_POST as $v) {
        if (is_string($v) && (strpos($v, '{') === 0 || strpos($v, '[') === 0)) {
            $try = @json_decode($v, true);
            if (is_array($try)) { $body = $try; break; }
        }
    }
}
// final fallback to empty array
if ($body === null) $body = [];

/* ---------- resolve guardian id ---------- */
$targetId = $_SESSION['guardian_id'] ?? $_SESSION['user_guardian_id'] ?? $_SESSION['user_id'] ?? null;
if (empty($targetId) && isset($body['guardian_id']) && preg_match('/^\d+$/', (string)$body['guardian_id'])) {
    $targetId = (int)$body['guardian_id'];
}
if (empty($targetId)) json_err('Not logged in or missing guardian id', null, 403);

/* ---------- extract allowed fields (presence = intent) ---------- */
$edu    = array_key_exists('education', $body) ? safe_trim_scalar($body['education']) : null;
$school = array_key_exists('school', $body)  ? safe_trim_scalar($body['school'])  : null;

$certs = null;
if (array_key_exists('certificates', $body)) {
    $certs = is_array($body['certificates']) ? $body['certificates'] : [];
}

$workType = array_key_exists('work_type', $body) ? safe_trim_scalar($body['work_type']) : null;

$jobs = null;
if (array_key_exists('job_experiences', $body)) {
    $jobs = is_array($body['job_experiences']) ? $body['job_experiences'] : [];
}

$workplace = null;
if (array_key_exists('workplace', $body)) {
    if (is_array($body['workplace'])) {
        $tmp = array_map(function($v){ return is_scalar($v) ? trim((string)$v) : null; }, $body['workplace']);
        $workplace = array_values(array_filter($tmp, 'strlen'));
    } elseif (is_string($body['workplace'])) {
        $s = trim($body['workplace']);
        $dec = @json_decode($s, true);
        if (is_array($dec)) {
            $tmp = array_map(function($v){ return is_scalar($v) ? trim((string)$v) : null; }, $dec);
            $workplace = array_values(array_filter($tmp, 'strlen'));
        } else {
            $workplace = $s === '' ? [] : [ $s ];
        }
    } else {
        $workplace = [];
    }
}

/* ---------- detect nothing-to-update ---------- */
if ($edu === null && $school === null && $certs === null && $workType === null && $jobs === null && $workplace === null) {
    echo json_encode(['success'=>false,'error'=>'No fields to update','received'=>$body]);
    exit;
}

/* ---------- connect DB ---------- */
$conn = getOracleConnection();
if (!$conn) json_err('DB connection failed', null, 500);

$needCommit = false;

/* ---------- work-only guard: if request only pertains to work fields, skip edu/certs updates ---------- */
$workOnly = ($workType !== null || $jobs !== null || $workplace !== null);

/* ---------- update education/school (when not work-only) ---------- */
if (!$workOnly && ($edu !== null || $school !== null)) {
    $sets = [];
    if ($edu !== null)    $sets[] = "education = :education";
    if ($school !== null) $sets[] = "school = :school";
    $sets[] = "updated_at = SYSTIMESTAMP";

    $sql = "UPDATE MVSG.USER_GUARDIAN SET " . implode(', ', $sets) . " WHERE id = TO_NUMBER(:id)";
    $st = oci_parse($conn, $sql);
    if (!$st) json_err('Prepare failed (education update)', oci_error($conn), 500);

    if ($edu !== null)    oci_bind_by_name($st, ':education', $edu, -1);
    if ($school !== null) oci_bind_by_name($st, ':school', $school, -1);
    oci_bind_by_name($st, ':id', $targetId);

    if (!@oci_execute($st, OCI_NO_AUTO_COMMIT)) {
        $e = oci_error($st) ?: oci_error($conn);
        oci_free_statement($st);
        oci_close($conn);
        json_err('Education update failed', $e['message'] ?? $e, 500);
    }
    oci_free_statement($st);
    $needCommit = true;
}

/* ---------- replace certificates (when not work-only) ---------- */
if (!$workOnly && is_array($certs)) {
    $del = oci_parse($conn, "DELETE FROM MVSG.GUARDIAN_CERTIFICATES WHERE GUARDIAN_ID = TO_NUMBER(:gid)");
    if (!$del) { oci_close($conn); json_err('Prepare failed (certs delete)', oci_error($conn), 500); }
    oci_bind_by_name($del, ':gid', $targetId);
    if (!@oci_execute($del, OCI_NO_AUTO_COMMIT)) {
        $e = oci_error($del) ?: oci_error($conn);
        oci_free_statement($del);
        oci_close($conn);
        json_err('Failed to delete old certificates', $e['message'] ?? $e, 500);
    }
    oci_free_statement($del);

    // insert with EMPTY_BLOB so we can write certificate LOB when provided
    $ins = oci_parse($conn, "
        INSERT INTO MVSG.GUARDIAN_CERTIFICATES
        (GUARDIAN_ID, NAME, ISSUED_BY, DATE_COMPLETED, WHAT_LEARNED, CREATED_AT, UPDATED_AT, CERTIFICATE)
        VALUES (TO_NUMBER(:gid), :name, :issuer,
                CASE WHEN :date_raw IS NULL OR TRIM(:date_raw) = '' THEN NULL ELSE TO_DATE(:date_raw,'YYYY-MM-DD') END,
                :what, SYSTIMESTAMP, SYSTIMESTAMP, EMPTY_BLOB()) RETURNING ROWID INTO :g_rowid
    ");
    if (!$ins) { oci_close($conn); json_err('Prepare failed (certs insert)', oci_error($conn), 500); }

    foreach ($certs as $c) {
        $name   = trim($c['certificate_name'] ?? $c['name'] ?? '');
        $issuer = trim($c['issued_by'] ?? $c['issuer'] ?? '');
        $date   = trim($c['date_completed'] ?? '');
        $what   = trim($c['training_description'] ?? $c['what_learned'] ?? '');

        if ($date) {
            $d = date_create($date);
            if ($d) $date = $d->format('Y-m-d');
        }

        oci_bind_by_name($ins, ':gid', $targetId);
        oci_bind_by_name($ins, ':name', $name, -1);
        oci_bind_by_name($ins, ':issuer', $issuer, -1);
        oci_bind_by_name($ins, ':date_raw', $date, -1);
        oci_bind_by_name($ins, ':what', $what, -1);
        $g_rowid = null;
        oci_bind_by_name($ins, ':g_rowid', $g_rowid, 256);

        if (!@oci_execute($ins, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($ins) ?: oci_error($conn);
            oci_rollback($conn);
            oci_free_statement($ins);
            oci_close($conn);
            json_err('Failed to insert certificate', $e['message'] ?? $e, 500);
        }
        // if client provided a certificate as base64/data-url, write into LOB
        $cert_raw = $c['certificate'] ?? $c['data'] ?? $c['file'] ?? null;
        $cert_blob = $cert_raw ? base64ToBlob($cert_raw) : null;
        if ($cert_blob !== null && is_string($cert_blob) && strlen($cert_blob) > 0 && !empty($g_rowid)) {
            try {
                $selc = "SELECT certificate FROM guardian_certificates WHERE ROWID = :rid FOR UPDATE";
                $selcst = oci_parse($conn, $selc);
                oci_bind_by_name($selcst, ':rid', $g_rowid);
                if (oci_execute($selcst, OCI_NO_AUTO_COMMIT)) {
                    if (oci_fetch($selcst)) {
                        $lob_cert_sel = oci_result($selcst, 'CERTIFICATE');
                        if ($lob_cert_sel && is_object($lob_cert_sel)) {
                            try {
                                if (method_exists($lob_cert_sel, 'write')) $lob_cert_sel->write($cert_blob);
                                elseif (method_exists($lob_cert_sel, 'writeTemporary')) $lob_cert_sel->writeTemporary($cert_blob, OCI_TEMP_BLOB);
                                elseif (method_exists($lob_cert_sel, 'saveTemporary')) $lob_cert_sel->saveTemporary($cert_blob, OCI_TEMP_BLOB);
                                else $lob_cert_sel->write($cert_blob);
                            } catch (Exception $e) {
                                // non-fatal: log and continue; blob will be empty
                                error_log('guardian cert LOB write failed: ' . $e->getMessage());
                            }
                        }
                    }
                    oci_free_statement($selcst);
                }
            } catch (Exception $e) { error_log('guardian cert FOR UPDATE error: ' . $e->getMessage()); }
        }
    }
    oci_free_statement($ins);
    $needCommit = true;
}

/* ---------- upsert work_type into USER_PROFILE TYPE='work_experience' ---------- */
if ($workType !== null) {
    $merge = "
        MERGE INTO MVSG.USER_PROFILE tgt
        USING (SELECT TO_NUMBER(:gid) AS gid, 'work_experience' AS typ, :val AS val FROM dual) src
        ON (tgt.GUARDIAN_ID = src.gid AND tgt.TYPE = src.typ)
        WHEN MATCHED THEN UPDATE SET tgt.VALUE = src.val, tgt.UPDATED_AT = SYSTIMESTAMP
        WHEN NOT MATCHED THEN INSERT (GUARDIAN_ID, TYPE, VALUE, CREATED_AT, UPDATED_AT)
            VALUES (src.gid, src.typ, src.val, SYSTIMESTAMP, SYSTIMESTAMP)
    ";
    $m = oci_parse($conn, $merge);
    if (!$m) json_err('Prepare failed (work_type upsert)', oci_error($conn), 500);
    oci_bind_by_name($m, ':gid', $targetId);
    oci_bind_by_name($m, ':val', $workType, -1);
    if (!@oci_execute($m, OCI_NO_AUTO_COMMIT)) {
        $e = oci_error($m) ?: oci_error($conn);
        oci_free_statement($m);
        oci_close($conn);
        json_err('Failed to upsert work_type', $e['message'] ?? $e, 500);
    }
    oci_free_statement($m);
    $needCommit = true;
}

/* ---------- preferred workplace: store one row per selected value (no JSON blob) ---------- */
if ($workplace !== null) {
    // delete existing workplace rows first (keeps DB canonical)
    $del = oci_parse($conn, "DELETE FROM MVSG.USER_PROFILE WHERE GUARDIAN_ID = TO_NUMBER(:gid) AND TYPE = 'workplace'");
    if (!$del) json_err('Prepare failed (workplace delete)', oci_error($conn), 500);
    oci_bind_by_name($del, ':gid', $targetId);
    if (!@oci_execute($del, OCI_NO_AUTO_COMMIT)) {
        $e = oci_error($del) ?: oci_error($conn);
        oci_free_statement($del);
        oci_close($conn);
        json_err('Failed to delete existing workplace rows', $e['message'] ?? $e, 500);
    }
    oci_free_statement($del);

    // if user cleared selection, we're done (deletion already performed)
    if (count($workplace) === 0) {
        $needCommit = true;
    } else {
        // insert one USER_PROFILE row per selected workplace value
        $ins = oci_parse($conn, "
            INSERT INTO MVSG.USER_PROFILE (GUARDIAN_ID, TYPE, VALUE, CREATED_AT, UPDATED_AT)
            VALUES (TO_NUMBER(:gid), 'workplace', :val, SYSTIMESTAMP, SYSTIMESTAMP)
        ");
        if (!$ins) json_err('Prepare failed (workplace insert)', oci_error($conn), 500);

        foreach ($workplace as $val) {
            $v = (string)$val;
            oci_bind_by_name($ins, ':gid', $targetId);
            oci_bind_by_name($ins, ':val', $v, -1);

            if (!@oci_execute($ins, OCI_NO_AUTO_COMMIT)) {
                $e = oci_error($ins) ?: oci_error($conn);
                oci_rollback($conn);
                oci_free_statement($ins);
                oci_close($conn);
                json_err('Failed to insert workplace row', $e['message'] ?? $e, 500);
            }
        }
        oci_free_statement($ins);
        $needCommit = true;
    }
}

/* ---------- replace job_experiences ---------- */
if (is_array($jobs)) {
    $del = oci_parse($conn, "DELETE FROM MVSG.JOB_EXPERIENCE WHERE GUARDIAN_ID = TO_NUMBER(:gid)");
    if (!$del) json_err('Prepare failed (job delete)', oci_error($conn), 500);
    oci_bind_by_name($del, ':gid', $targetId);
    if (!@oci_execute($del, OCI_NO_AUTO_COMMIT)) {
        $e = oci_error($del) ?: oci_error($conn);
        oci_free_statement($del);
        oci_close($conn);
        json_err('Failed to delete old job_experiences', $e['message'] ?? $e, 500);
    }
    oci_free_statement($del);

    // insert job rows with EMPTY_BLOB for workexp_certificate so we can write when provided
    $insSql = "
        INSERT INTO MVSG.JOB_EXPERIENCE
        (GUARDIAN_ID, COMPANY_NAME, JOB_TITLE, WORK_YEAR, JOB_DESCRIPTION, CREATED_AT, UPDATED_AT, WORKEXP_CERTIFICATE)
        VALUES (TO_NUMBER(:gid), :jcompany, :jtitle, :jwork_year, :jdesc, SYSTIMESTAMP, SYSTIMESTAMP, EMPTY_BLOB()) RETURNING ROWID INTO :job_rowid
    ";

    foreach ($jobs as $row) {
        $company = trim($row['company'] ?? $row['company_name'] ?? '');
        $title   = trim($row['title'] ?? $row['job_title'] ?? '');
        $yearRaw = trim($row['start_year'] ?? $row['work_year'] ?? '');
        $desc    = trim($row['description'] ?? $row['job_description'] ?? '');

        // normalize year -> string or null
        $jwork_year = null;
        if ($yearRaw !== '' && preg_match('/^\d{4}$/', $yearRaw)) {
            $jwork_year = (string)(int)$yearRaw;
        }

        // prepare per-row (safe) and bind unique names
        $ins = oci_parse($conn, $insSql);
        if (!$ins) {
            $e = oci_error($conn);
            oci_close($conn);
            json_err('Prepare failed (job insert)', $e['message'] ?? $e, 500);
        }

        oci_bind_by_name($ins, ':gid', $targetId);
        oci_bind_by_name($ins, ':jcompany', $company, -1);
        oci_bind_by_name($ins, ':jtitle', $title, -1);
        // bind WORK_YEAR as string (or null) with length to avoid bind-name/null issues
        oci_bind_by_name($ins, ':jwork_year', $jwork_year, -1);
        oci_bind_by_name($ins, ':jdesc', $desc, -1);
        $job_rowid = null;
        oci_bind_by_name($ins, ':job_rowid', $job_rowid, 256);

        if (!@oci_execute($ins, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($ins) ?: oci_error($conn);
            oci_rollback($conn);
            oci_free_statement($ins);
            oci_close($conn);
            json_err('Failed to insert job_experience', $e['message'] ?? $e, 500);
        }
        // write per-row certificate blob when provided in payload (data URL / base64)
        $job_cert_raw = $row['certificate'] ?? $row['data'] ?? $row['file'] ?? null;
        $job_cert_blob = $job_cert_raw ? base64ToBlob($job_cert_raw) : null;
        if ($job_cert_blob !== null && is_string($job_cert_blob) && strlen($job_cert_blob) > 0 && !empty($job_rowid)) {
            try {
                $selj = "SELECT workexp_certificate FROM job_experience WHERE ROWID = :rid FOR UPDATE";
                $seljst = oci_parse($conn, $selj);
                oci_bind_by_name($seljst, ':rid', $job_rowid);
                if (oci_execute($seljst, OCI_NO_AUTO_COMMIT)) {
                    if (oci_fetch($seljst)) {
                        $lob_job_sel = oci_result($seljst, 'WORKEXP_CERTIFICATE');
                        if ($lob_job_sel && is_object($lob_job_sel)) {
                            try {
                                if (method_exists($lob_job_sel, 'write')) $lob_job_sel->write($job_cert_blob);
                                elseif (method_exists($lob_job_sel, 'writeTemporary')) $lob_job_sel->writeTemporary($job_cert_blob, OCI_TEMP_BLOB);
                                elseif (method_exists($lob_job_sel, 'saveTemporary')) $lob_job_sel->saveTemporary($job_cert_blob, OCI_TEMP_BLOB);
                                else $lob_job_sel->write($job_cert_blob);
                            } catch (Exception $e) {
                                error_log('job cert LOB write failed: ' . $e->getMessage());
                            }
                        }
                    }
                    oci_free_statement($seljst);
                }
            } catch (Exception $e) { error_log('job cert FOR UPDATE error: ' . $e->getMessage()); }
        }
        oci_free_statement($ins);
    }
    $needCommit = true;
}

/* ---------- commit ---------- */
if ($needCommit) {
    if (!@oci_commit($conn)) {
        $e = oci_error($conn);
        oci_close($conn);
        json_err('Commit failed', $e['message'] ?? $e, 500);
    }
}

oci_close($conn);

/* ---------- response ---------- */
echo json_encode([
    'success' => true,
    'updated' => [
        'education' => ($edu !== null && !$workOnly),
        'school' => ($school !== null && !$workOnly),
        'certificates' => ($certs !== null && !$workOnly),
        'work_type' => $workType !== null,
        'workplace' => $workplace !== null,
        'job_experiences' => is_array($jobs)
    ]
]);
exit;
?>