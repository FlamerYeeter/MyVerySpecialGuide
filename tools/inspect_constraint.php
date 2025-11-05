<?php
require_once __DIR__ . '/../public/db/oracledb.php';
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo json_encode(['ok'=>false,'error'=>$e->getMessage()]); exit(1); }
$cons = 'FK_RECOMMENDATION_EXPERT';
$sql = "SELECT OWNER, CONSTRAINT_NAME, TABLE_NAME, R_CONSTRAINT_NAME FROM ALL_CONSTRAINTS WHERE CONSTRAINT_NAME = UPPER(:c)";
$stid = @oci_parse($conn, $sql);
$out=['ok'=>true,'sql'=>$sql,'rows'=>[]];
if ($stid) {
    oci_bind_by_name($stid, ':c', $cons);
    @oci_execute($stid);
    while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) { $out['rows'][] = $r; }
    @oci_free_statement($stid);
}
// For each row, resolve referenced table via R_CONSTRAINT_NAME
foreach ($out['rows'] as $i => $r) {
    if (!empty($r['R_CONSTRAINT_NAME'])) {
        $q = "SELECT OWNER, TABLE_NAME, CONSTRAINT_NAME FROM ALL_CONSTRAINTS WHERE CONSTRAINT_NAME = :c AND OWNER = :owner";
        $s2 = @oci_parse($conn, $q);
        if ($s2) { oci_bind_by_name($s2, ':c', $r['R_CONSTRAINT_NAME']); oci_bind_by_name($s2, ':owner', $r['OWNER']); @oci_execute($s2); $rr = @oci_fetch_array($s2, OCI_ASSOC+OCI_RETURN_NULLS); @oci_free_statement($s2); $out['rows'][$i]['ref'] = $rr ?: null; }
    }
}
echo json_encode($out, JSON_PRETTY_PRINT);
