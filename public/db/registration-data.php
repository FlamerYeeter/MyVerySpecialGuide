<?php
require_once 'oracledb.php';

// Debug / response helpers
$proof = null;
$certs = [];
$lastError = null;
function generateNumericId() {
    $micro = str_replace('.', '', (string)microtime(true));
    $rand = random_int(1000, 9999);
    return substr($micro, 0, 15) . $rand;
}

function saveBase64File($base64String, $path = '../uploads/') {
    if (empty($base64String)) return null;
    $base64String = substr($base64String, strpos($base64String, ',') + 1);
    $data = base64_decode($base64String, true);
    if ($data === false) return null;
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->buffer($data);
    $ext = ['image/jpeg'=>'jpg','image/png'=>'png','image/gif'=>'gif','application/pdf'=>'pdf'][$mime] ?? 'bin';
    if (!file_exists($path)) mkdir($path, 0777, true);
    $filename = uniqid('file_', true) . '.' . $ext;
    file_put_contents($path . $filename, $data);
    return $filename;
}

function base64ToBlob($input) {
    if (empty($input)) return null;
    $binary = '';

    // If the input is already an array (client may send an array of file objects), use it
    if (is_array($input)) {
        $items = $input;
    } else {
        // If input is a string, try to json-decode it into an array; otherwise treat as single data URL/base64
        if (is_string($input)) {
            $decoded = json_decode($input, true);
            $items = is_array($decoded) ? $decoded : null;
        } else {
            $items = null;
        }
    }

    // If we have an array of items, iterate and collect their 'data' fields or string values
    if (is_array($items)) {
        foreach ($items as $item) {
            if (is_string($item)) {
                $str = $item;
                if (($pos = strpos($str, ',')) !== false) {
                    $str = substr($str, $pos + 1);
                }
                $data = base64_decode($str, true);
                if ($data !== false) $binary .= $data;
                continue;
            }
            if (!is_array($item)) continue;
            if (!empty($item['data'])) {
                $d = $item['data'];
                if (($pos = strpos($d, ',')) !== false) $d = substr($d, $pos + 1);
                $decoded = base64_decode($d, true);
                if ($decoded !== false) $binary .= $decoded;
            } elseif (!empty($item['file'])) {
                $d = $item['file'];
                if (($pos = strpos($d, ',')) !== false) $d = substr($d, $pos + 1);
                $decoded = base64_decode($d, true);
                if ($decoded !== false) $binary .= $decoded;
            }
        }
        return $binary !== '' ? $binary : null;
    }

    // Single Base64 string (data URL or raw base64)
    if (is_string($input)) {
        if (($pos = strpos($input, ',')) !== false) {
            $input = substr($input, $pos + 1);
        }
        $data = base64_decode($input, true);
        return $data !== false ? $data : null;
    }

    return null;
}

// ——— READ & VALIDATE JSON ———
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (!$data) {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => 'Invalid JSON']));
}

    // DEBUG: persist received payload for troubleshooting CDD_TYPE issues (temporary)
    try {
        $debugPath = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_registration_payload.json';
        @file_put_contents($debugPath, json_encode(['received_at' => date('c'), 'raw_json' => $json, 'decoded_keys' => array_keys(is_array($data)?$data:[] )], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        // NOTE: intentionally do not write a separate rpi_personal debug file to avoid persisting sensitive personal JSON
    } catch (Exception $e) { /* ignore debug failures */ }

// helper to write debug errors safely
function write_debug_error($filename, $payload) {
    try {
        $path = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $filename;
        @file_put_contents($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    } catch (Exception $e) { /* ignore debug write errors */ }
}

// ——— EXTRACT DATA ———
$user_info         = json_decode($data['rpi_personal'] ?? '{}', true);
// Robustly extract education level and school name (accept JSON object or plain string)
$education_level_raw = $data['education'] ?? null;
$edu_level = null;
$school_name = null;
if ($education_level_raw !== null) {
    $decoded = json_decode($education_level_raw, true);
     if (is_array($decoded)) {
         $edu_level  = $decoded['edu_level'] ?? $decoded['education_level'] ?? $decoded['level'] ?? null;
         $school_name = $decoded['school_name'] ?? $decoded['school'] ?? null;
     } else {
         // plain string (e.g. "Vocational/Training")
         $edu_level = is_string($education_level_raw) ? $education_level_raw : null;
     }
 }
 // also accept explicit top-level keys if present
$edu_level    = $edu_level ?? ($data['edu_level'] ?? $data['education_level'] ?? null);
$school_name  = $school_name ?? ($data['school_name'] ?? $data['school'] ?? null);
$is_graduate       = $data['review_certs'] ?? null;
$license_type      = $data['selected_work_year'] ?? null;
$status            = $data['workplace'] ?? null;
// $proof = base64ToBlob($data['admin_uploaded_proof_data'] ?? '');
$medRaw = $data['admin_uploaded_med_data'] ?? null;
$pwdRaw = $data['admin_uploaded_pwd_data'] ?? null;
$medcerts = base64ToBlob($medRaw);
$pwdid    = base64ToBlob($pwdRaw);

$medBlob = $medcerts;
$pwdBlob = $pwdid;
// fallback recordings when LOB write not possible
$fallback_saved_files = [];

// Personal
$firstName   = $user_info['firstName'] ?? null;
$lastName    = $user_info['lastName'] ?? null;
$email       = $user_info['email'] ?? null;
$phone       = $user_info['phone'] ?? null;
$age         = $user_info['age'] ?? null;
$address     = $user_info['address'] ?? null;
$username    = $user_info['username'] ?? null;
$password    = password_hash($user_info['password'] ?? 'temp123', PASSWORD_DEFAULT);
$types_of_ds = $user_info['r_dsType1'] ?? null;
$birthdate_raw   = $user_info['birthdate'] ?? null;

// Normalize and validate birthdate to 'YYYY-MM-DD' or null to avoid invalid TO_DATE calls
$birthdate = null;
if (!empty($birthdate_raw)) {
    try {
        // Take only first 10 chars in case time is included
        $candidate = substr(trim((string)$birthdate_raw), 0, 10);
        $dt = DateTime::createFromFormat('Y-m-d', $candidate);
        if ($dt && $dt->format('Y-m-d') === $candidate) {
            // Ensure year is not 0
            $yr = intval($dt->format('Y'));
            if ($yr !== 0) $birthdate = $dt->format('Y-m-d');
        }
    } catch (Exception $e) { $birthdate = null; }
}

// Congenital/Developmental Disability (CDD) - accept from nested rpi_personal or top-level keys
$cdd_type = null;
// Accept many possible key names from different frontend pages: prefer nested user_info (rpi_personal)
// Common keys: r_cddType1, cddType, cdd_type, cddTypeOther, r_cddType1_other
$cdd_type = $user_info['r_cddType1'] ?? $user_info['r_cdd_type'] ?? $user_info['cddType'] ?? $user_info['cdd_type'] ?? $user_info['cddTypeOther'] ?? $user_info['cdd_type_other'] ?? $user_info['r_cddType1_other'] ?? null;
// Fallback to top-level payload keys
if (!$cdd_type) {
    $cdd_type = $data['r_cddType1'] ?? $data['r_cdd_type'] ?? $data['cddType'] ?? $data['cdd_type'] ?? $data['cddTypeOther'] ?? $data['cdd_type_other'] ?? $data['r_cddType1_other'] ?? null;
}

// Normalize CDD value to a string and ensure it fits the DB column size (VARCHAR2(50)).
try {
    if (is_array($cdd_type)) {
        $cdd_type = implode(', ', $cdd_type);
    }
    $cdd_type = $cdd_type !== null ? trim((string)$cdd_type) : null;

    // If value too long for DB column, truncate and record a debug trace
    if ($cdd_type !== null && mb_strlen($cdd_type, 'UTF-8') > 50) {
        $debugNote = [
            'warning' => 'cdd_type_truncated',
            'original_length' => mb_strlen($cdd_type, 'UTF-8'),
            'max_length' => 50,
            'original_value' => $cdd_type,
            'received_at' => date('c')
        ];
        try {
            $dbgFile = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_cdd_truncation.json';
            @file_put_contents($dbgFile, json_encode($debugNote, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        } catch (Exception $e) { /* ignore logging failure */ }
        // Truncate safely using multibyte substring
        $cdd_type = mb_substr($cdd_type, 0, 50, 'UTF-8');
    }
} catch (Exception $e) { /* keep original behavior if anything unexpected happens */ }

// Guardian
$gf = $user_info['g_first_name'] ?? null;
$gl = $user_info['g_last_name'] ?? null;
$ge = $user_info['g_email'] ?? null;
$gp = $user_info['g_phone'] ?? null;
$gr = $user_info['guardian_relationship'] ?? null;

// IDs
$user_guardian_id = generateNumericId();    

// Connect
$conn = getOracleConnection();
if (!$conn) {
    http_response_code(500);
    die(json_encode(['success'=>false, 'error'=>'DB connection failed']));
}

// Disable auto-commit
oci_set_action($conn, "Registration Transaction");

// BEGIN TRANSACTION
$allGood = true;
// Defer creating LOB descriptors for med/pwd until we know there's binary data.
$lob_med = null;
$lob_pwd = null;

/* Write Binary Data: will write into LOB locators AFTER successful insert */

// -------- 1. INSERT user_guardian --------
$sql1 = "
INSERT INTO user_guardian (
    id,
    role,
    first_name,
    last_name,
    email,
    contact_number,
    password,
    age,
    education,
    school,
    guardian_first_name,
    guardian_last_name,
    guardian_email,
    guardian_contact_number,
    relationship_to_user,
    created_at,
    updated_at,
    address,
    types_of_ds,
    cdd_type,
    username,
    med_certificates,
    pwd_id,
    date_of_birth
) VALUES (
    :id,
    'User',
    :first_name,
    :last_name,
    :email,
    :contact_number,
    :password,
    :age,
    :education,
    :school,
    :guardian_first_name,
    :guardian_last_name,
    :guardian_email,
    :guardian_contact_number,
    :relationship,
    SYSDATE,
    SYSDATE,
    :address,
    :types_of_ds,
    :cdd_type,
    :username,
    EMPTY_BLOB(),
    EMPTY_BLOB(),
    CASE WHEN :birthdate IS NULL OR TRIM(:birthdate) = '' THEN NULL ELSE TO_DATE(:birthdate,'YYYY-MM-DD') END
)";

$stid1 = oci_parse($conn, $sql1);

/* ---------- TEXT BINDS ---------- */

oci_bind_by_name($stid1, ':id',            $user_guardian_id);
oci_bind_by_name($stid1, ':first_name',    $firstName);
oci_bind_by_name($stid1, ':last_name',     $lastName);
oci_bind_by_name($stid1, ':email',         $email);
oci_bind_by_name($stid1, ':contact_number',$phone);
oci_bind_by_name($stid1, ':password',      $password);

oci_bind_by_name($stid1, ':age',           $age);
oci_bind_by_name($stid1, ':education',     $edu_level);
oci_bind_by_name($stid1, ':school',        $school_name);

oci_bind_by_name($stid1, ':guardian_first_name', $gf);
oci_bind_by_name($stid1, ':guardian_last_name',  $gl);
oci_bind_by_name($stid1, ':guardian_email',      $ge);
oci_bind_by_name($stid1, ':guardian_contact_number', $gp);
oci_bind_by_name($stid1, ':relationship',        $gr);

oci_bind_by_name($stid1, ':address',       $address);
oci_bind_by_name($stid1, ':types_of_ds',   $types_of_ds);
oci_bind_by_name($stid1, ':cdd_type',       $cdd_type);
oci_bind_by_name($stid1, ':username',      $username);
oci_bind_by_name($stid1, ':birthdate',     $birthdate);

// Append RETURNING clause to get ROWID only (we'll SELECT FOR UPDATE to obtain LOB locators)
// Re-parse/prepare with RETURNING because OCI does not support modifying parsed SQL easily
oci_free_statement($stid1);
$sql1_return = $sql1 . " RETURNING ROWID INTO :ug_rowid";
$stid1 = oci_parse($conn, $sql1_return);

/* ---------- RE-BIND TEXT/BASIC PARAMETERS FOR NEW statement ---------- */
oci_bind_by_name($stid1, ':id',            $user_guardian_id);
oci_bind_by_name($stid1, ':first_name',    $firstName);
oci_bind_by_name($stid1, ':last_name',     $lastName);
oci_bind_by_name($stid1, ':email',         $email);
oci_bind_by_name($stid1, ':contact_number',$phone);
oci_bind_by_name($stid1, ':password',      $password);
oci_bind_by_name($stid1, ':age',           $age);
oci_bind_by_name($stid1, ':education',     $edu_level);
oci_bind_by_name($stid1, ':school',        $school_name);
oci_bind_by_name($stid1, ':guardian_first_name', $gf);
oci_bind_by_name($stid1, ':guardian_last_name',  $gl);
oci_bind_by_name($stid1, ':guardian_email',      $ge);
oci_bind_by_name($stid1, ':guardian_contact_number', $gp);
oci_bind_by_name($stid1, ':relationship',        $gr);
oci_bind_by_name($stid1, ':address',       $address);
oci_bind_by_name($stid1, ':types_of_ds',   $types_of_ds);
oci_bind_by_name($stid1, ':cdd_type',       $cdd_type);
oci_bind_by_name($stid1, ':username',      $username);
oci_bind_by_name($stid1, ':birthdate',     $birthdate);

// (LOB locators will be bound after we create descriptors below)


/* ---------- RETURNING ROWID (will SELECT FOR UPDATE to obtain LOB locators) ---------- */
// Bind only ROWID placeholder so we can SELECT FOR UPDATE to safely obtain LOB locators
$ug_rowid = null;
oci_bind_by_name($stid1, ':ug_rowid', $ug_rowid, 256);

// EXECUTE
if (!oci_execute($stid1, OCI_NO_AUTO_COMMIT)) {
    $e = oci_error($stid1);
    $lastError = $e;
    $allGood = false;
    write_debug_error('temp_debug_registration_sql_error_user_guardian.json', [
        'stage' => 'user_guardian_insert',
        'error' => $e,
        'payload_summary' => array_keys(is_array($data)?$data:[]),
        'time' => date('c')
    ]);
}
// After successful execute, obtain LOB locators using SELECT ... FOR UPDATE and write med/pwd blobs
if ($allGood) {
    if (($medBlob !== null && is_string($medBlob) && strlen($medBlob) > 0) || ($pwdBlob !== null && is_string($pwdBlob) && strlen($pwdBlob) > 0)) {
        try {
            $sel = "SELECT med_certificates, pwd_id FROM user_guardian WHERE ROWID = :rid FOR UPDATE";
            $selt = oci_parse($conn, $sel);
            oci_bind_by_name($selt, ':rid', $ug_rowid);
            if (oci_execute($selt, OCI_NO_AUTO_COMMIT)) {
                if (oci_fetch($selt)) {
                    $lob_med_sel = oci_result($selt, 'MED_CERTIFICATES');
                    $lob_pwd_sel = oci_result($selt, 'PWD_ID');
                    if ($medBlob !== null && is_string($medBlob) && strlen($medBlob) > 0 && $lob_med_sel && is_object($lob_med_sel)) {
                        try {
                            if (method_exists($lob_med_sel, 'write')) $lob_med_sel->write($medBlob);
                            elseif (method_exists($lob_med_sel, 'writeTemporary')) $lob_med_sel->writeTemporary($medBlob, OCI_TEMP_BLOB);
                            elseif (method_exists($lob_med_sel, 'saveTemporary')) $lob_med_sel->saveTemporary($medBlob, OCI_TEMP_BLOB);
                            else $lob_med_sel->write($medBlob);
                            write_debug_error('temp_debug_med_blob_written.json', ['size_bytes'=>strlen($medBlob),'time'=>date('c')]);
                        } catch (Exception $e) {
                            write_debug_error('temp_debug_med_blob_error.json', ['error'=> (is_object($e)? (method_exists($e,'getMessage')?$e->getMessage():(string)$e) : (string)$e), 'time'=>date('c')]);
                            try { if (!empty($medRaw)) { $savedm = saveBase64File($medRaw); if ($savedm) $fallback_saved_files[] = ['type'=>'med','file'=>$savedm]; write_debug_error('temp_debug_med_blob_fallback_saved.json', ['file'=>$savedm,'time'=>date('c')]); } } catch (Exception $ee) { write_debug_error('temp_debug_med_blob_fallback_error.json', ['error'=> (string)$ee,'time'=>date('c')]); }
                        }
                    }
                    if ($pwdBlob !== null && is_string($pwdBlob) && strlen($pwdBlob) > 0 && $lob_pwd_sel && is_object($lob_pwd_sel)) {
                        try {
                            if (method_exists($lob_pwd_sel, 'write')) $lob_pwd_sel->write($pwdBlob);
                            elseif (method_exists($lob_pwd_sel, 'writeTemporary')) $lob_pwd_sel->writeTemporary($pwdBlob, OCI_TEMP_BLOB);
                            elseif (method_exists($lob_pwd_sel, 'saveTemporary')) $lob_pwd_sel->saveTemporary($pwdBlob, OCI_TEMP_BLOB);
                            else $lob_pwd_sel->write($pwdBlob);
                            write_debug_error('temp_debug_pwd_blob_written.json', ['size_bytes'=>strlen($pwdBlob),'time'=>date('c')]);
                        } catch (Exception $e) {
                            write_debug_error('temp_debug_pwd_blob_error.json', ['error'=> (is_object($e)? (method_exists($e,'getMessage')?$e->getMessage():(string)$e) : (string)$e), 'time'=>date('c')]);
                            try { if (!empty($pwdRaw)) { $savedp = saveBase64File($pwdRaw); if ($savedp) $fallback_saved_files[] = ['type'=>'pwd','file'=>$savedp]; write_debug_error('temp_debug_pwd_blob_fallback_saved.json', ['file'=>$savedp,'time'=>date('c')]); } } catch (Exception $ee) { write_debug_error('temp_debug_pwd_blob_fallback_error.json', ['error'=> (string)$ee,'time'=>date('c')]); }
                        }
                    }
                }
                oci_free_statement($selt);
            }
        } catch (Exception $e) { write_debug_error('temp_debug_med_pwd_forupdate_error.json', ['error'=> (string)$e, 'time'=>date('c')]); }
    }
}

// ——— 2. INSERT job_experiences ———
if ($allGood) {
    $work_exp = json_decode($data['job_experiences'] ?? '[]', true);
    foreach ($work_exp as $work) {
        // Accept multiple possible field names and normalize year
        $job_title   = $work['title'] ?? $work['job_title'] ?? $work['position'] ?? null;
        $company     = $work['company'] ?? $work['company_name'] ?? $work['employer'] ?? null;
        $raw_year    = $work['start_year'] ?? $work['year'] ?? $work['work_year'] ?? null;
        $description = $work['description'] ?? $work['job_description'] ?? $work['desc'] ?? null;

        // Normalize year to a 4-digit string when possible, otherwise NULL
        $work_year = null;
        if ($raw_year !== null && $raw_year !== '') {
            if (is_numeric($raw_year)) {
                $work_year = (string) intval($raw_year);
            } else {
                if (preg_match('/(\d{4})/', (string)$raw_year, $m)) {
                    $work_year = $m[1];
                } else {
                    // leave as null to avoid inserting invalid data
                    $work_year = null;
                }
            }
        }

        // Insert row with EMPTY_BLOB() and RETURN the ROWID only; we'll SELECT FOR UPDATE to get LOB locator
        $sql2 = "INSERT INTO job_experience (
                    guardian_id, job_title, company_name, work_year, job_description, workexp_certificate
                ) VALUES (
                    :v1,:v2,:v3,:v4,:v5, EMPTY_BLOB()
                ) RETURNING ROWID INTO :job_rowid";
        $stid2 = oci_parse($conn, $sql2);

        // bind normalized variables (not array keys directly)
        oci_bind_by_name($stid2, ':v1', $user_guardian_id);
        oci_bind_by_name($stid2, ':v2', $job_title);
        oci_bind_by_name($stid2, ':v3', $company);
        oci_bind_by_name($stid2, ':v4', $work_year);
        oci_bind_by_name($stid2, ':v5', $description);

        // Extract possible base64 certificate from job entry (keep raw for fallback)
        $job_cert_raw = null;
        if (!empty($work['certificate'])) $job_cert_raw = $work['certificate'];
        elseif (!empty($work['certificate_data'])) $job_cert_raw = $work['certificate_data'];
        elseif (!empty($work['file'])) $job_cert_raw = $work['file'];
        elseif (!empty($work['data'])) $job_cert_raw = $work['data'];
        $job_cert_blob = $job_cert_raw ? base64ToBlob($job_cert_raw) : null;

        // Bind ROWID holder so RETURNING will provide it; we'll SELECT FOR UPDATE after execute to obtain locator
        $job_rowid = null;
        oci_bind_by_name($stid2, ':job_rowid', $job_rowid, 256);

        if (!oci_execute($stid2, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($stid2);
            $lastError = $e;
            $allGood = false;
            write_debug_error('temp_debug_registration_sql_error_job_experience.json', [
                'stage'=>'job_experience_insert',
                'error'=>$e,
                'work_item'=>$work,
                'time'=>date('c')
            ]);
            oci_free_statement($stid2);
            try { if (isset($lob_job_cert) && is_object($lob_job_cert)) $lob_job_cert->free(); } catch (Exception $ee) {}
            break;
        }

        // After execute, SELECT FOR UPDATE to obtain LOB locator and write content
        if ($job_cert_blob !== null && is_string($job_cert_blob) && strlen($job_cert_blob) > 0) {
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
                                write_debug_error('temp_debug_job_certificate_blobs.json', [
                                    'stage' => 'job_blob_written',
                                    'size_bytes' => strlen($job_cert_blob),
                                    'work_item' => $work,
                                    'rowid' => $job_rowid,
                                    'time' => date('c')
                                ]);
                            } catch (Exception $e) {
                                write_debug_error('temp_debug_job_certificate_blobs_error.json', ['stage'=>'job_blob_write_failed','error'=> (string)$e,'work_item'=>$work,'time'=>date('c')]);
                                try { if (!empty($job_cert_raw)) { $savedj = saveBase64File($job_cert_raw); if ($savedj) { $fallback_saved_files[] = ['type'=>'job','work_item'=>$work,'file'=>$savedj]; write_debug_error('temp_debug_job_certificate_fallback_saved.json', ['file'=>$savedj,'time'=>date('c')]); } } } catch (Exception $ee) { write_debug_error('temp_debug_job_certificate_fallback_error.json', ['error'=> (string)$ee,'time'=>date('c')]); }
                            }
                        }
                    }
                    oci_free_statement($seljst);
                }
            } catch (Exception $e) { write_debug_error('temp_debug_job_certificate_forupdate_error.json', ['error'=> (string)$e, 'time'=>date('c')]); }
        }

        oci_free_statement($stid2);
    }
}

// ——— 3. INSERT guardian_certificates (Certificate / Training Details) ———
if ($allGood) {
    // Accept several possible incoming keys for certificate entries
    $rawCerts = $data['certificates'] ?? $data['education_certificates'] ?? $data['education_profile'] ?? '[]';
    $cert_entries = is_string($rawCerts) ? json_decode($rawCerts, true) : $rawCerts;
    if (!is_array($cert_entries)) $cert_entries = [];

    foreach ($cert_entries as $ce) {
        if (!is_array($ce)) continue;
        $c_name   = trim($ce['certificate_name'] ?? $ce['name'] ?? $ce['certificate'] ?? '');
        $c_issued = trim($ce['issued_by'] ?? $ce['issuer'] ?? '');
        $c_date   = trim($ce['date_completed'] ?? $ce['date'] ?? '');
        // Normalize certificate date to 'YYYY-MM-DD' or NULL to avoid ORA-01841
        $c_date_norm = null;
        $extracted_year = null;
        if ($c_date !== '') {
            $candidate = trim((string)$c_date);
            // Try common formats: ISO, then long textual month like 'July 4, 2020', then strtotime fallback
            $dt = DateTime::createFromFormat('Y-m-d', substr($candidate,0,10));
            if ($dt && $dt->format('Y-m-d') === substr($candidate,0,10)) {
                $yr = intval($dt->format('Y'));
                if ($yr !== 0) {
                    $c_date_norm = $dt->format('Y-m-d');
                    $extracted_year = $yr;
                }
            } else {
                // Try parsing formats like 'July 4, 2020' or 'Jul 4, 2020'
                $formats = ['F j, Y', 'M j, Y', 'F d, Y', 'M d, Y', 'j F Y', 'j M Y'];
                foreach ($formats as $fmt) {
                    $dt2 = DateTime::createFromFormat($fmt, $candidate);
                    if ($dt2 && $dt2->format('Y') > 0) {
                        $c_date_norm = $dt2->format('Y-m-d');
                        $extracted_year = intval($dt2->format('Y'));
                        break;
                    }
                }
                // As a last resort, try strtotime which handles many human-readable dates
                if ($c_date_norm === null) {
                    $ts = strtotime($candidate);
                    if ($ts !== false && $ts > 0) {
                        $c_date_norm = date('Y-m-d', $ts);
                        $extracted_year = intval(date('Y', $ts));
                    } else {
                        // attempt to extract a 4-digit year only
                        if (preg_match('/(\d{4})/', $c_date, $m)) {
                            $yr = intval($m[1]);
                            if ($yr !== 0) {
                                $extracted_year = $yr;
                                $c_date_norm = null; // avoid guessing full date
                            }
                        }
                    }
                }
            }

            // Write per-certificate debug info (append as JSON lines)
            try {
                $certDbg = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_certificate_years.json';
                $dbgEntry = [
                    'logged_at' => date('c'),
                    'certificate_name' => $c_name,
                    'original_date' => $c_date,
                    'normalized_date' => $c_date_norm,
                    'extracted_year' => $extracted_year
                ];
                @file_put_contents($certDbg, json_encode($dbgEntry, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
            } catch (Exception $e) { /* ignore logging failure */ }
        }
        $c_learn  = trim($ce['training_description'] ?? $ce['description'] ?? $ce['what_you_learned'] ?? '');

        // skip totally empty entries
        if ($c_name === '' && $c_issued === '' && $c_date === '' && $c_learn === '') continue;

        // Use TO_DATE only when a date string is provided; otherwise NULL
        // Prepare SQL to include optional CERTIFICATE BLOB column
          // Insert with EMPTY_BLOB() and RETURN the locator into :gcert so we can write into it safely
          $sqlc = "INSERT INTO guardian_certificates (
                          guardian_id, name, issued_by, date_completed, what_learned, created_at, updated_at, certificate
                      ) VALUES (
                          :gid, :gname, :gissued,
                          CASE WHEN :gdate IS NULL OR :gdate = '' THEN NULL ELSE TO_DATE(:gdate,'YYYY-MM-DD') END,
                          :glearn, SYSDATE, SYSDATE, EMPTY_BLOB()
                      ) RETURNING ROWID INTO :g_rowid";
        $stidc = oci_parse($conn, $sqlc);
        oci_bind_by_name($stidc, ':gid',   $user_guardian_id);
        oci_bind_by_name($stidc, ':gname', $c_name);
        oci_bind_by_name($stidc, ':gissued', $c_issued);
        // bind normalized date (or NULL) to avoid TO_DATE errors on malformed dates
        oci_bind_by_name($stidc, ':gdate', $c_date_norm);
        oci_bind_by_name($stidc, ':glearn', $c_learn);

        // Accept file data in several possible keys and keep raw for fallback
        $cert_raw = null;
        if (!empty($ce['data'])) $cert_raw = $ce['data'];
        elseif (!empty($ce['file'])) $cert_raw = $ce['file'];
        elseif (!empty($ce['certificate_data'])) $cert_raw = $ce['certificate_data'];
        elseif (!empty($ce['certificate']) && is_string($ce['certificate'])) {
            // some clients may place the base64 directly under 'certificate'
            $cert_raw = $ce['certificate'];
        }
        $cert_blob = $cert_raw ? base64ToBlob($cert_raw) : null;

        // Bind ROWID holder; we'll SELECT FOR UPDATE after execute to obtain LOB locator
        $g_rowid = null;
        oci_bind_by_name($stidc, ':g_rowid', $g_rowid, 256);

        if (!oci_execute($stidc, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($stidc);
            $lastError = $e;
            $allGood = false;
            write_debug_error('temp_debug_registration_sql_error_certificate.json', [
                'stage'=>'guardian_certificate_insert',
                'error'=>$e,
                'certificate'=>$ce,
                'time'=>date('c')
            ]);
            // free statement and any LOB descriptor
            oci_free_statement($stidc);
            try { if (isset($lob_cert) && is_object($lob_cert)) $lob_cert->free(); } catch (Exception $e) {}
            break;
        }
        // If we received binary data, use UPDATE with a bound blob to write directly (avoids LOB locator transaction issues)
        if ($cert_blob !== null && is_string($cert_blob) && strlen($cert_blob) > 0) {
            try {
                $upSql = "UPDATE guardian_certificates SET certificate = :blob WHERE ROWID = :rid";
                $upSt = oci_parse($conn, $upSql);
                // Use a LOB descriptor and save the binary into it before executing the UPDATE
                $lob_cert_desc = oci_new_descriptor($conn, OCI_D_LOB);
                oci_bind_by_name($upSt, ':blob', $lob_cert_desc, -1, OCI_B_BLOB);
                oci_bind_by_name($upSt, ':rid', $g_rowid, 256);
                // save binary into descriptor (this writes into the bound placeholder)
                try {
                    if ($lob_cert_desc === false) throw new Exception('Failed to create LOB descriptor');
                    $lob_cert_desc->save($cert_blob);
                } catch (Exception $e) {
                    write_debug_error('temp_debug_certificate_lob_desc_error.json', ['error'=>(string)$e,'rowid'=>$g_rowid,'cert_name'=>$c_name,'time'=>date('c')]);
                }
                if (oci_execute($upSt, OCI_NO_AUTO_COMMIT)) {
                    write_debug_error('temp_debug_certificate_blobs.json', [
                        'stage'=>'guardian_certificate_blob_written',
                        'size_bytes'=>strlen($cert_blob),
                        'certificate_name'=>$c_name,
                        'rowid'=>$g_rowid,
                        'time'=>date('c')
                    ]);
                    // verify written length using ROWID
                    try {
                        $verSqlC = "SELECT id, dbms_lob.getlength(certificate) AS L FROM guardian_certificates WHERE ROWID = :rid";
                        $vstc = oci_parse($conn, $verSqlC);
                        oci_bind_by_name($vstc, ':rid', $g_rowid);
                        if (oci_execute($vstc)) {
                            $rc = oci_fetch_array($vstc, OCI_ASSOC+OCI_RETURN_NULLS);
                            $llenc = $rc && isset($rc['L']) ? intval($rc['L']) : 0;
                            $idc = $rc && isset($rc['ID']) ? $rc['ID'] : null;
                            write_debug_error('temp_debug_certificate_verify.json', ['db_id'=>$idc,'rowid'=>$g_rowid,'db_length'=>$llenc,'expected_size'=>strlen($cert_blob),'time'=>date('c')]);
                            if ($llenc === 0) {
                                $savedc = null;
                                try { if (!empty($cert_raw)) { $savedc = saveBase64File($cert_raw); } } catch (Exception $e) { $savedc = null; }
                                write_debug_error('temp_debug_certificate_zero_length.json', ['message'=>'guardian certificate blob length is zero after update','rowid'=>$g_rowid,'db_id'=>$idc,'db_length'=>$llenc,'saved_fallback'=>$savedc,'time'=>date('c')]);
                                if ($savedc) $fallback_saved_files[] = ['type'=>'guardian_cert','certificate_name'=>$c_name,'file'=>$savedc];
                            }
                        }
                        oci_free_statement($vstc);
                    } catch (Exception $e) { write_debug_error('temp_debug_certificate_verify_error.json', ['error'=> (string)$e, 'time'=>date('c')]); }
                } else {
                    $e = oci_error($upSt);
                    write_debug_error('temp_debug_certificate_blobs_error.json', ['stage'=>'guardian_certificate_update_failed','error'=>$e,'certificate'=>$ce,'time'=>date('c')]);
                    try { if (!empty($cert_raw)) { $savedc = saveBase64File($cert_raw); if ($savedc) { $fallback_saved_files[] = ['type'=>'guardian_cert','certificate_name'=>$c_name,'file'=>$savedc]; write_debug_error('temp_debug_certificate_fallback_saved.json', ['file'=>$savedc,'time'=>date('c')]); } } } catch (Exception $ee) { write_debug_error('temp_debug_certificate_fallback_error.json', ['error'=> (string)$ee,'time'=>date('c')]); }
                }
                oci_free_statement($upSt);
                try { if (isset($lob_cert_desc) && is_object($lob_cert_desc)) $lob_cert_desc->free(); } catch (Exception $e) {}
            } catch (Exception $e) { write_debug_error('temp_debug_certificate_forupdate_error.json', ['error'=> (string)$e, 'time'=>date('c')]); }
        }
        oci_free_statement($stidc);
    }
}

// ——— 3. INSERT guardian_job_details (work/support/skills/category) ———
function insertGuardianDetail($conn, $guardian_id, $type, $value) {
    $sql = "INSERT INTO user_profile (guardian_id, type, value)
            VALUES (:guardian_id, :type, :value)";
    $stid = oci_parse($conn, $sql);
    oci_bind_by_name($stid, ':guardian_id', $guardian_id);
    oci_bind_by_name($stid, ':type', $type);
    oci_bind_by_name($stid, ':value', $value);
    $ok = oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if (!$ok) {
        $err = oci_error($stid);
        $GLOBALS['allGood'] = false;
        global $lastError;
        $lastError = $err;
        write_debug_error('temp_debug_registration_sql_error_user_profile.json', [
            'stage'=>'user_profile_insert', 'error'=>$err, 'guardian_id'=>$guardian_id, 'type'=>$type, 'value'=>$value, 'time'=>date('c')
        ]);
    }
    oci_free_statement($stid);
}

if ($allGood) {
    $work_type        = json_decode($data['selected_work_experience'] ?? '[]', true);
    $skills1_selected = json_decode($data['skills1_selected'] ?? '[]', true);
    $job_category     = json_decode($data['jobPreferences'] ?? '[]', true);
    $workplace        = json_decode($data['workplace'] ?? '[]', true);

    foreach ($work_type as $v) insertGuardianDetail($conn, $user_guardian_id, 'work_experience', $v);
    foreach ($skills1_selected as $v) insertGuardianDetail($conn, $user_guardian_id, 'skills', $v);
    foreach ($job_category as $v) insertGuardianDetail($conn, $user_guardian_id, 'job_preference', $v);
    foreach ($workplace as $v) insertGuardianDetail($conn, $user_guardian_id, 'workplace', $v);
}

// ——— FINAL COMMIT OR ROLLBACK ———
// Write a final debug snapshot to help trace silent failures
try {
    $finalDbg = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_registration_final_state.json';
    $dbgPayload = [
        'allGood' => $allGood,
        'lastError' => is_array($lastError) ? $lastError : (is_object($lastError)? (method_exists($lastError,'getMessage')?$lastError->getMessage():(string)$lastError) : $lastError),
        'timestamp' => date('c'),
        'fallback_saved_files' => $fallback_saved_files ?? [],
        'expected_debug_files' => [
            'temp_debug_med_blob_written.json' => file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_med_blob_written.json'),
            'temp_debug_pwd_blob_written.json' => file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_pwd_blob_written.json'),
            'temp_debug_job_certificate_blobs.json' => file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_job_certificate_blobs.json'),
            'temp_debug_certificate_blobs.json' => file_exists(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_certificate_blobs.json'),
        ]
    ];
    @file_put_contents($finalDbg, json_encode($dbgPayload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
} catch (Exception $e) { /* ignore */ }

if ($allGood) {
    $commitOk = @oci_commit($conn);
    if (!$commitOk) {
        $ce = oci_error($conn) ?: oci_error();
        write_debug_error('temp_debug_registration_commit_error.json', ['error'=>$ce, 'time'=>date('c')]);
        http_response_code(500);
        echo json_encode(['success'=>false,'error'=>'Commit failed','debug'=>$ce]);
    } else {
        http_response_code(200);
        echo json_encode([
            'success' => true,
            'guardian_id' => $user_guardian_id,
            'files' => ['proof' => $proof, 'certs' => $certs]
        ]);
    }
} else {
    oci_rollback($conn);
    http_response_code(500);
    // provide last error details in debug field while keeping top-level message concise
    $msg = 'Transaction failed';
    if (isset($lastError) && is_array($lastError) && !empty($lastError['message'])) {
        $msg = $lastError['message'];
    }
    echo json_encode(['success' => false, 'error' => $msg, 'debug' => $lastError]);
}

// ——— CLEANUP ———
if (isset($stid1) && is_resource($stid1)) oci_free_statement($stid1);
if (isset($stid2) && is_resource($stid2)) oci_free_statement($stid2);
oci_close($conn);

// free LOB descriptors if allocated
try { if (isset($lob_med) && is_object($lob_med)) $lob_med->free(); } catch(Exception $e) {}
try { if (isset($lob_pwd) && is_object($lob_pwd)) $lob_pwd->free(); } catch(Exception $e) {}
?>
