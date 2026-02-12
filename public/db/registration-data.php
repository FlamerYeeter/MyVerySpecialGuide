<?php
require_once 'oracledb.php';

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

    // Try to decode as JSON array
    $items = json_decode($input, true);
    if (is_array($items)) {
    foreach ($items as $item) {
    if (!empty($item['data'])) {
    if (($pos = strpos($item['data'], ',')) !== false) {
    $item['data'] = substr($item['data'], $pos + 1);
    }
    $data = base64_decode($item['data'], true);
    if ($data !== false) {
    $binary .= $data; // append to single blob
    }
    }
    }
    return $binary !== '' ? $binary : null;
    }

    // Single Base64 string
    if (($pos = strpos($input, ',')) !== false) {
    $input = substr($input, $pos + 1);
    }
    $data = base64_decode($input, true);
    return $data !== false ? $data : null;
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
    // also write parsed rpi_personal for easy inspection
    if (!empty($data['rpi_personal'])) {
        $p = json_decode($data['rpi_personal'], true);
        $debugP = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'temp_debug_rpi_personal.json';
        @file_put_contents($debugP, json_encode(['received_at' => date('c'), 'rpi_personal_parsed' => $p], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
} catch (Exception $e) { /* ignore debug failures */ }

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
$medcerts = base64ToBlob($data['admin_uploaded_med_data'] ?? '');
$pwdid    = base64ToBlob($data['admin_uploaded_pwd_data'] ?? '');

$medBlob = $medcerts;
$pwdBlob = $pwdid;

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
// $lob_proof = oci_new_descriptor($conn, OCI_D_LOB);
$lob_med   = oci_new_descriptor($conn, OCI_D_LOB);
$lob_pwd   = oci_new_descriptor($conn, OCI_D_LOB);

/* Write Binary Data */

// if ($proofBlob) $lob_proof->writeTemporary($proofBlob, OCI_TEMP_BLOB);
if ($medBlob)   $lob_med->writeTemporary($medBlob, OCI_TEMP_BLOB);
if ($pwdBlob)   $lob_pwd->writeTemporary($pwdBlob, OCI_TEMP_BLOB);

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
    :med_certificates,
    :pwd_id,
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


/* ---------- BLOB BINDS ---------- */

oci_bind_by_name($stid1, ':med_certificates', $lob_med, -1, OCI_B_BLOB);
oci_bind_by_name($stid1, ':pwd_id',           $lob_pwd, -1, OCI_B_BLOB);

// EXECUTE
if (!oci_execute($stid1, OCI_NO_AUTO_COMMIT)) {
    $e = oci_error($stid1);
    $allGood = false;
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

        $sql2 = "INSERT INTO job_experience (
                    guardian_id, job_title, company_name, work_year, job_description
                ) VALUES (
                    :v1,:v2,:v3,:v4,:v5
                )";
        $stid2 = oci_parse($conn, $sql2);

        // bind normalized variables (not array keys directly)
        oci_bind_by_name($stid2, ':v1', $user_guardian_id);
        oci_bind_by_name($stid2, ':v2', $job_title);
        oci_bind_by_name($stid2, ':v3', $company);
        oci_bind_by_name($stid2, ':v4', $work_year);
        oci_bind_by_name($stid2, ':v5', $description);

        if (!oci_execute($stid2, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($stid2);
            $allGood = false;
            break;
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
            $candidate = substr(trim((string)$c_date), 0, 10);
            $dt = DateTime::createFromFormat('Y-m-d', $candidate);
            if ($dt && $dt->format('Y-m-d') === $candidate) {
                $yr = intval($dt->format('Y'));
                if ($yr !== 0) {
                    $c_date_norm = $dt->format('Y-m-d');
                    $extracted_year = $yr;
                }
            } else {
                // attempt to extract a 4-digit year; do not invent full date to avoid incorrect DB inserts
                if (preg_match('/(\d{4})/', $c_date, $m)) {
                    $yr = intval($m[1]);
                    if ($yr !== 0) {
                        $extracted_year = $yr;
                        // keep normalized date NULL to avoid inserting a guessed date
                        $c_date_norm = null;
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
        $sqlc = "INSERT INTO guardian_certificates (
                    guardian_id, name, issued_by, date_completed, what_learned, created_at, updated_at
                 ) VALUES (
                    :gid, :gname, :gissued,
                    CASE WHEN :gdate IS NULL OR :gdate = '' THEN NULL ELSE TO_DATE(:gdate,'YYYY-MM-DD') END,
                    :glearn, SYSDATE, SYSDATE
                 )";
        $stidc = oci_parse($conn, $sqlc);
        oci_bind_by_name($stidc, ':gid',   $user_guardian_id);
        oci_bind_by_name($stidc, ':gname', $c_name);
        oci_bind_by_name($stidc, ':gissued', $c_issued);
        // bind normalized date (or NULL) to avoid TO_DATE errors on malformed dates
        oci_bind_by_name($stidc, ':gdate', $c_date_norm);
        oci_bind_by_name($stidc, ':glearn', $c_learn);

        if (!oci_execute($stidc, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($stidc);
            $allGood = false;
            oci_free_statement($stidc);
            break;
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
    if (!$ok) $GLOBALS['allGood'] = false;
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
if ($allGood) {
    oci_commit($conn);
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'guardian_id' => $user_guardian_id,
        'files' => ['proof' => $proof, 'certs' => $certs]
    ]);
} else {
    oci_rollback($conn);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e['message'] ?? 'Transaction failed']);
}

// ——— CLEANUP ———
oci_free_statement($stid1);
if (isset($stid2)) oci_free_statement($stid2);
oci_close($conn);
?>
