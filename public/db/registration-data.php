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

// ——— READ & VALIDATE JSON ———
$json = file_get_contents('php://input');
$data = json_decode($json, true);
if (!$data) {
    http_response_code(400);
    die(json_encode(['success' => false, 'error' => 'Invalid JSON']));
}

// ——— EXTRACT DATA ———
$user_info         = json_decode($data['rpi_personal'] ?? '{}', true);
$education_level   = $data['education'] ?? null;
$main_course       = $data['school_name'] ?? null;
$is_graduate       = $data['review_certs'] ?? null;
$license_type      = $data['selected_work_year'] ?? null;
$status            = $data['workplace'] ?? null;
$proof = saveBase64File($data['uploadedProofData0'] ?? '');
$certs = saveBase64File($data['uploadedProofData1'] ?? '');

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

// ——— 1. INSERT user_guardian ———
$sql1 = "INSERT INTO user_guardian (
    id, role, first_name, last_name, email, contact_number, password,
    age, education, school, certificate,
    guardian_first_name, guardian_last_name, guardian_email,
    guardian_contact_number, relationship_to_user, created_at, updated_at,
    address, types_of_ds, proof_of_membership, certificates, username
) VALUES (
    :v0,'User',:v2,:v3,:v4,:v5,:v6,
    :v7,:v8,:v9,:v10,
    :v11,:v12,:v13,:v14,:v15,SYSDATE,SYSDATE,
    :v16,:v17,:v18,:v19,:v20
)";

$stid1 = oci_parse($conn, $sql1);
oci_bind_by_name($stid1, ':v0',  $user_guardian_id);
// oci_bind_by_name($stid1, ':v1',  $status);
oci_bind_by_name($stid1, ':v2',  $firstName);
oci_bind_by_name($stid1, ':v3',  $lastName);
oci_bind_by_name($stid1, ':v4',  $email);
oci_bind_by_name($stid1, ':v5',  $phone);
oci_bind_by_name($stid1, ':v6',  $password);
oci_bind_by_name($stid1, ':v7',  $age);
oci_bind_by_name($stid1, ':v8',  $education_level);
oci_bind_by_name($stid1, ':v9',  $main_course);
oci_bind_by_name($stid1, ':v10', $is_graduate);
oci_bind_by_name($stid1, ':v11', $gf);
oci_bind_by_name($stid1, ':v12', $gl);
oci_bind_by_name($stid1, ':v13', $ge);
oci_bind_by_name($stid1, ':v14', $gp);
oci_bind_by_name($stid1, ':v15', $gr);
oci_bind_by_name($stid1, ':v16', $address);
oci_bind_by_name($stid1, ':v17', $types_of_ds);
oci_bind_by_name($stid1, ':v18', $proof);
oci_bind_by_name($stid1, ':v19', $certs);
oci_bind_by_name($stid1, ':v20', $username);

if (!oci_execute($stid1, OCI_NO_AUTO_COMMIT)) {
    $e = oci_error($stid1);
    $allGood = false;
}

// ——— 2. INSERT job_experiences ———
if ($allGood) {
    $work_exp = json_decode($data['job_experiences'] ?? '[]', true);
    foreach ($work_exp as $work) {
        $sql2 = "INSERT INTO job_experiences (
                    guardian_id, job_title, company_name, work_year, job_description
                ) VALUES (
                    :v1,:v2,:v3,:v4,:v5
                )";
        $stid2 = oci_parse($conn, $sql2);
        oci_bind_by_name($stid2, ':v1', $user_guardian_id);
        oci_bind_by_name($stid2, ':v2', $work['title']);
        oci_bind_by_name($stid2, ':v3', $work['company']);
        oci_bind_by_name($stid2, ':v4', $work['year']);
        oci_bind_by_name($stid2, ':v5', $work['description']);
        if (!oci_execute($stid2, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($stid2);
            $allGood = false;
            break;
        }
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
    $support          = json_decode($data['support'] ?? '[]', true);

    foreach ($work_type as $v) insertGuardianDetail($conn, $user_guardian_id, 'work_experience', $v);
    foreach ($skills1_selected as $v) insertGuardianDetail($conn, $user_guardian_id, 'skills', $v);
    foreach ($job_category as $v) insertGuardianDetail($conn, $user_guardian_id, 'job_category', $v);
    foreach ($support as $v) insertGuardianDetail($conn, $user_guardian_id, 'support', $v);
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
