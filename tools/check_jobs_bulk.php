<?php
require_once __DIR__ . '/../public/db/oracledb.php';
try {
    $conn = getOracleConnection();
} catch (Throwable $e) { echo json_encode(['ok'=>false,'error'=>'connect_failed','message'=>$e->getMessage()]); exit(1); }
$sql = 'SELECT * FROM MVSG_JOB_POSTINGS WHERE ID IN (2,5,6,7,8,12,15,16,17,18)';
$stid = @oci_parse($conn, $sql);
$out=['ok'=>true,'rows'=>[],'sql'=>$sql];
if ($stid) {
    @oci_execute($stid);
    while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) { $out['rows'][] = $r; }
    @oci_free_statement($stid);
} else { $out['error']='parse_failed'; }

echo json_encode($out, JSON_PRETTY_PRINT);
