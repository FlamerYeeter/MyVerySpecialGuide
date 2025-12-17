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
$proof = base64ToBlob($data['admin_uploaded_proof_data'] ?? '');
$medcerts = base64ToBlob($data['admin_uploaded_med_data'] ?? '');
$certs = base64ToBlob($data['uploadedProofs_proof'] ?? '');

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
$lob_proof = oci_new_descriptor($conn, OCI_D_LOB);
$lob_certs = oci_new_descriptor($conn, OCI_D_LOB);
$lob_med   = oci_new_descriptor($conn, OCI_D_LOB);

// Write binary data to LOB
$lob_proof->writeTemporary($proofBlob, OCI_TEMP_BLOB);
$lob_certs->writeTemporary($certsBlob, OCI_TEMP_BLOB);
$lob_med->writeTemporary($medBlob, OCI_TEMP_BLOB);

// ——— 1. INSERT user_guardian ———
$sql1 = "INSERT INTO user_guardian (
    id, role, first_name, last_name, email, contact_number, password,
    age, education, school,
    guardian_first_name, guardian_last_name, guardian_email,
    guardian_contact_number, relationship_to_user, created_at, updated_at,
    address, types_of_ds, proof_of_membership, certificates, username, med_certificates
) VALUES (
    :v0,'User',:v2,:v3,:v4,:v5,:v6,
    :v7,:v8,:v9,
    :v11,:v12,:v13,:v14,:v15,SYSDATE,SYSDATE,
    :v16,:v17,:v18,:v19,:v20,:v21
)";

$stid1 = oci_parse($conn, $sql1);

// ----- TEXT BINDS -----
oci_bind_by_name($stid1, ':v0',  $user_guardian_id);
oci_bind_by_name($stid1, ':v2',  $firstName);
oci_bind_by_name($stid1, ':v3',  $lastName);
oci_bind_by_name($stid1, ':v4',  $email);
oci_bind_by_name($stid1, ':v5',  $phone);
oci_bind_by_name($stid1, ':v6',  $password);
oci_bind_by_name($stid1, ':v7',  $age);
oci_bind_by_name($stid1, ':v8',  $edu_level);
oci_bind_by_name($stid1, ':v9',  $school_name);
oci_bind_by_name($stid1, ':v11', $gf);
oci_bind_by_name($stid1, ':v12', $gl);
oci_bind_by_name($stid1, ':v13', $ge);
oci_bind_by_name($stid1, ':v14', $gp);
oci_bind_by_name($stid1, ':v15', $gr);
oci_bind_by_name($stid1, ':v16', $address);
oci_bind_by_name($stid1, ':v17', $types_of_ds);
oci_bind_by_name($stid1, ':v20', $username);

// ----- BLOB BINDS -----
oci_bind_by_name($stid1, ':v18', $lob_proof, -1, OCI_B_BLOB);
oci_bind_by_name($stid1, ':v19', $lob_certs, -1, OCI_B_BLOB);
oci_bind_by_name($stid1, ':v21', $lob_med,   -1, OCI_B_BLOB);

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
        oci_bind_by_name($stidc, ':gdate', $c_date);
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
