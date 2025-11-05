<?php
require_once __DIR__ . '/../public/db/oracledb.php';
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo json_encode(['ok'=>false,'error'=>$e->getMessage()]); exit(1); }
$sql = 'SELECT DISTINCT EXPERT_ID FROM MVSG_RECOMMENDATION WHERE ROWNUM <= 100';
$stid = @oci_parse($conn, $sql);
$out=['ok'=>true,'rows'=>[], 'sql'=>$sql];
if ($stid) {
    @oci_execute($stid);
    while ($r = @oci_fetch_array($stid, OCI_NUM+OCI_RETURN_NULLS)) { $out['rows'][] = $r[0]; }
    @oci_free_statement($stid);
} else { $out['error']='parse_failed'; }
echo json_encode($out, JSON_PRETTY_PRINT);
