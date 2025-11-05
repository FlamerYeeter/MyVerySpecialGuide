<?php
// Add profile key/value rows to MVSG_USER_PROFILE for a guardian to test content scoring.
// Usage: php tools/seed_profile_tokens.php uid=2

require_once __DIR__ . '/../public/db/oracledb.php';
$options = [];
foreach (array_slice($argv,1) as $a) {
    if (strpos($a,'=')!==false) { list($k,$v)=explode('=', $a, 2); $options[$k]=$v; }
}
$uid = isset($options['uid']) ? intval($options['uid']) : 0;
if (!$uid) { echo json_encode(['ok'=>false,'error'=>'invalid_uid']); exit(1); }

try { $conn = getOracleConnection(); } catch (Throwable $e) { echo json_encode(['ok'=>false,'error'=>'oracle_connect_failed','message'=>$e->getMessage()]); exit(2); }

$tokens = ['Therapist','Service Technician','Customer Service'];
$inserted = 0; $errors = [];
foreach ($tokens as $t) {
    $sql = "INSERT INTO MVSG_USER_PROFILE (GUARDIAN_ID, KEY, VALUE, CREATED_AT) VALUES (:gid, :k, :v, SYSDATE)";
    $stid = @oci_parse($conn, $sql);
    if (!$stid) { $errors[] = ['message'=>'parse_failed','sql'=>$sql]; continue; }
    $key = 'Skill'; $val = $t; oci_bind_by_name($stid, ':gid', $uid); oci_bind_by_name($stid, ':k', $key); oci_bind_by_name($stid, ':v', $val);
    $ok = @oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if ($ok) { $inserted++; } else { $err = oci_error($stid) ?: oci_error($conn); $errors[] = $err; }
    @oci_free_statement($stid);
}
if ($inserted>0) { @oci_commit($conn); echo json_encode(['ok'=>true,'inserted'=>$inserted]); }
else { echo json_encode(['ok'=>false,'inserted'=>0,'errors'=>$errors]); }
