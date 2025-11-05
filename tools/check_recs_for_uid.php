<?php
require_once __DIR__ . '/../public/db/oracledb.php';
$uid = isset($argv[1]) ? intval($argv[1]) : 2;
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo json_encode(['ok'=>false,'error'=>$e->getMessage()]); exit(1); }
$sql = 'SELECT * FROM MVSG_RECOMMENDATION WHERE EXPERT_ID = :uid AND ROWNUM <= 50';
$stid = @oci_parse($conn, $sql);
$out=['ok'=>true,'uid'=>$uid,'rows'=>[],'sql'=>$sql];
if ($stid) {
    oci_bind_by_name($stid, ':uid', $uid);
    @oci_execute($stid);
    while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) { $out['rows'][] = $r; }
    @oci_free_statement($stid);
} else { $out['error']='parse_failed'; }

echo json_encode($out, JSON_PRETTY_PRINT);
