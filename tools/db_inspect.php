<?php
require_once __DIR__ . '/../public/db/oracledb.php';
$conn = null;
try { $conn = getOracleConnection(); } catch (Exception $e) { echo json_encode(['ok'=>false,'error'=>$e->getMessage()]); exit(1); }
$tables = ['MVSG_RECOMMENDATION','MVSG_JOB_POSTINGS','MVSG_USER_GUARDIAN','MVSG_USER_PROFILE'];
$out = [];
foreach ($tables as $t) {
    $sql = "SELECT COUNT(*) CNT FROM " . $t;
    $stid = @oci_parse($conn, $sql);
    if ($stid) { @oci_execute($stid); $r = @oci_fetch_array($stid, OCI_NUM+OCI_RETURN_NULLS); @oci_free_statement($stid); $out[$t] = intval($r[0] ?? 0); } else { $out[$t] = null; }
}
echo json_encode(['ok'=>true,'counts'=>$out], JSON_PRETTY_PRINT);
