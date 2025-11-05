<?php
// Seed some MVSG_RECOMMENDATION rows for a given expert (uid) to test collaborative scoring.
// Usage: php tools/seed_recs_for_uid.php uid=2

require_once __DIR__ . '/../public/db/oracledb.php';

$options = [];
foreach (array_slice($argv,1) as $a) {
    if (strpos($a,'=')!==false) { list($k,$v)=explode('=', $a, 2); $options[$k]=$v; }
}
$uid = isset($options['uid']) ? intval($options['uid']) : 0;
if (!$uid) { echo json_encode(['ok'=>false,'error'=>'invalid_uid','message'=>'pass uid=N']); exit(1); }

$conn = null;
try { $conn = getOracleConnection(); } catch (\Throwable $e) { $conn = null; }
if (!$conn) { echo json_encode(['ok'=>false,'error'=>'oracle_connect_failed']); exit(2); }

$toInsert = [
    ['job'=>2,'score'=>4.5],
    ['job'=>5,'score'=>3.0],
    ['job'=>6,'score'=>2.0]
];

$inserted = 0;
foreach ($toInsert as $r) {
    $sql = "INSERT INTO MVSG_RECOMMENDATION (EXPERT_ID, JOB_ID, COMMENT_SCORE, CREATED_AT) VALUES (:eid, :jid, :score, SYSDATE)";
    $stid = @oci_parse($conn, $sql);
    if (!$stid) continue;
    oci_bind_by_name($stid, ':eid', $uid);
    oci_bind_by_name($stid, ':jid', $r['job']);
    oci_bind_by_name($stid, ':score', $r['score']);
    $ok = @oci_execute($stid, OCI_NO_AUTO_COMMIT);
    if ($ok) { $inserted++; }
    else {
        $err = oci_error($stid) ?: oci_error($conn);
        $errors[] = $err ?: ['message'=>'unknown'];
    }
    @oci_free_statement($stid);
}

if ($inserted>0) {
    @oci_commit($conn);
    echo json_encode(['ok'=>true,'inserted'=>$inserted]);
} else {
    echo json_encode(['ok'=>false,'inserted'=>0,'message'=>'no rows inserted','errors'=>$errors]);
}
