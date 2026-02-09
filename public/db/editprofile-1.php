<?php
header('Content-Type: application/json; charset=utf-8');
session_start();
require_once __DIR__ . '/oracledb.php';

/* ------------------ Read & Validate JSON ------------------ */
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid JSON']);
    exit;
}

/* ------------------ DB Connection ------------------ */
$conn = getOracleConnection();
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'DB connection failed']);
    exit;
}

/* ------------------ Resolve Target User ------------------ */
$targetId = $_SESSION['guardian_id']
         ?? $_SESSION['user_guardian_id']
         ?? $_SESSION['user_id']
         ?? null;

$targetUsername = $_SESSION['username'] ?? null;
$emailMatch     = $_SESSION['email'] ?? null;

// fallback to payload if session missing
if (empty($targetId)) {
    if (!empty($data['username'])) $targetUsername = $data['username'];
    if (!empty($data['email']))    $emailMatch = $data['email'];
}

if (!$targetId && !$targetUsername && !$emailMatch) {
    http_response_code(403);
    echo json_encode(['success'=>false,'error'=>'Unable to identify user']);
    exit;
}

/* ------------------ Build Dynamic UPDATE ------------------ */
$sets  = [];
$binds = [];

/* User fields */
if (array_key_exists('first_name', $data)) { $sets[] = "first_name = :fn"; $binds[':fn'] = $data['first_name']; }
if (array_key_exists('last_name',  $data)) { $sets[] = "last_name = :ln"; $binds[':ln'] = $data['last_name']; }
if (array_key_exists('date_of_birth', $data)) {
    // store as DATE; accept empty string to mean NULL
    $sets[] = "date_of_birth = CASE WHEN :dob IS NULL OR :dob = '' THEN NULL ELSE TO_DATE(:dob,'YYYY-MM-DD') END";
    $binds[':dob'] = $data['date_of_birth'];
}
if (array_key_exists('email',      $data)) { $sets[] = "email = :email"; $binds[':email'] = $data['email']; }
if (array_key_exists('phone',      $data)) { $sets[] = "contact_number = :phone"; $binds[':phone'] = $data['phone']; }
if (array_key_exists('address',    $data)) { $sets[] = "address = :addr"; $binds[':addr'] = $data['address']; }
if (array_key_exists('r_dsType1',  $data)) { $sets[] = "types_of_ds = :types"; $binds[':types'] = $data['r_dsType1']; }

// Congenital/Developmental Disability (CDD)
if (array_key_exists('r_cddType1', $data) || array_key_exists('cddType', $data) || array_key_exists('cdd_type', $data)) {
    $cddVal = $data['r_cddType1'] ?? $data['cddType'] ?? $data['cdd_type'] ?? null;
    $sets[] = "cdd_type = :cdd";
    $binds[':cdd'] = $cddVal;
}

/* Guardian fields */
if (array_key_exists('g_first_name', $data)) { $sets[] = "guardian_first_name = :gf"; $binds[':gf'] = $data['g_first_name']; }
if (array_key_exists('g_last_name',  $data)) { $sets[] = "guardian_last_name = :gl"; $binds[':gl'] = $data['g_last_name']; }
if (array_key_exists('g_email',      $data)) { $sets[] = "guardian_email = :ge"; $binds[':ge'] = $data['g_email']; }
if (array_key_exists('g_phone',      $data)) { $sets[] = "guardian_contact_number = :gp"; $binds[':gp'] = $data['g_phone']; }
if (array_key_exists('guardian_relationship', $data)) {
    $sets[] = "relationship_to_user = :gr";
    $binds[':gr'] = $data['guardian_relationship'];
}

/* Username change */
if (array_key_exists('username', $data)) {
    $sets[] = "username = :newusername";
    $binds[':newusername'] = $data['username'];
}

/* Password change */
if (!empty($data['password'])) {
    $sets[] = "password = :pw";
    $binds[':pw'] = password_hash($data['password'], PASSWORD_DEFAULT);
}

if (empty($sets)) {
    echo json_encode(['success'=>false,'error'=>'No updatable fields']);
    exit;
}

/* Timestamp */
$sets[] = "updated_at = SYSDATE";

/* ------------------ Final SQL ------------------ */
$sql = "UPDATE user_guardian SET " . implode(', ', $sets) . " WHERE 1=0";
if ($targetId)       $sql .= " OR id = :idmatch";
if ($targetUsername) $sql .= " OR username = :usernamematch";
if ($emailMatch)     $sql .= " OR email = :emailmatch";

$stid = oci_parse($conn, $sql);

/* Bind values */
foreach ($binds as $k => $v) {
    oci_bind_by_name($stid, $k, $binds[$k]);
}

/* Bind identity */
if ($targetId)       oci_bind_by_name($stid, ':idmatch', $targetId);
if ($targetUsername) oci_bind_by_name($stid, ':usernamematch', $targetUsername);
if ($emailMatch)     oci_bind_by_name($stid, ':emailmatch', $emailMatch);

/* ------------------ Execute ------------------ */
$ok = @oci_execute($stid, OCI_NO_AUTO_COMMIT);
if (!$ok) {
    $e = oci_error($stid);
    oci_rollback($conn);
    oci_free_statement($stid);
    oci_close($conn);
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>$e['message'] ?? 'Update failed']);
    exit;
}

oci_commit($conn);
oci_free_statement($stid);
oci_close($conn);

echo json_encode(['success'=>true,'message'=>'Profile updated']);
exit;
?>
