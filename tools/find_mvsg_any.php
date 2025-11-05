<?php
require_once __DIR__ . '/../public/db/oracledb.php';
$conn = null;
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo json_encode(['ok'=>false,'error'=>$e->getMessage()]); exit(1); }

$sql = "SELECT OWNER, TABLE_NAME FROM ALL_TABLES WHERE TABLE_NAME LIKE '%MVSG%' ORDER BY OWNER, TABLE_NAME";
$stid = @oci_parse($conn, $sql);
$out = ['ok'=>true,'tables'=>[]];
if ($stid) {
    @oci_execute($stid);
    while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
        $out['tables'][] = $r;
    }
    @oci_free_statement($stid);
}

echo json_encode($out, JSON_PRETTY_PRINT);
