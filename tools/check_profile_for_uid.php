<?php
require_once __DIR__ . '/../public/db/oracledb.php';
$uid = isset($argv[1]) ? intval($argv[1]) : 2;
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo json_encode(['ok'=>false,'error'=>$e->getMessage()]); exit(1); }

$out=['ok'=>true,'uid'=>$uid,'profile'=>[],'guardian'=>null];
// profile rows
$sql = 'SELECT * FROM MVSG_USER_PROFILE WHERE GUARDIAN_ID = :id';
$stid = @oci_parse($conn, $sql);
if ($stid) {
    oci_bind_by_name($stid, ':id', $uid);
    @oci_execute($stid);
    while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) { $out['profile'][] = $r; }
    @oci_free_statement($stid);
} else { $out['profile_error']='parse_failed'; }

// guardian
$sql2 = 'SELECT * FROM MVSG_USER_GUARDIAN WHERE ID = :id';
$st2 = @oci_parse($conn, $sql2);
if ($st2) {
    oci_bind_by_name($st2, ':id', $uid);
    @oci_execute($st2);
    $g = @oci_fetch_array($st2, OCI_ASSOC+OCI_RETURN_NULLS);
    @oci_free_statement($st2);
    if ($g) $out['guardian'] = $g;
} else { $out['guardian_error']='parse_failed'; }

echo json_encode($out, JSON_PRETTY_PRINT);
