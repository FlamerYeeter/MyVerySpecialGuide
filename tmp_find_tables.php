<?php
require_once __DIR__ . '/public/db/oracledb.php';
putenv('TNS_ADMIN=C:\\oracle\\network\\admin');
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo "CONNECT: " . $e->getMessage() . PHP_EOL; exit(1); }
$sql = "SELECT TABLE_NAME FROM USER_TABLES WHERE TABLE_NAME LIKE '%EXPERT%'";
$stid = @oci_parse($conn, $sql);
@oci_execute($stid);
$tables = [];
while ($r = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)) {
    $tables[] = $r['TABLE_NAME'];
}
@oci_free_statement($stid);
echo json_encode(['tables' => $tables], JSON_PRETTY_PRINT) . PHP_EOL;
