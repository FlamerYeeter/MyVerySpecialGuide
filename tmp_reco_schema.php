<?php
require_once __DIR__ . '/public/db/oracledb.php';
putenv('TNS_ADMIN=C:\\oracle\\network\\admin');
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo "CONNECT: " . $e->getMessage() . PHP_EOL; exit(1); }
$sql = "SELECT COLUMN_NAME FROM USER_TAB_COLUMNS WHERE TABLE_NAME = 'RECOMMENDATION' ORDER BY COLUMN_ID";
$stid = @oci_parse($conn, $sql);
@oci_execute($stid);
$cols = [];
while ($r = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)) {
    $cols[] = $r['COLUMN_NAME'];
}
@oci_free_statement($stid);
echo json_encode(['table' => 'RECOMMENDATION', 'columns' => $cols], JSON_PRETTY_PRINT) . PHP_EOL;
