<?php
require_once __DIR__ . '/public/db/oracledb.php';
putenv('TNS_ADMIN=C:\\oracle\\network\\admin');
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo "CONNECT: " . $e->getMessage() . PHP_EOL; exit(1); }
$sql = "SELECT OWNER, CONSTRAINT_NAME, SEARCH_CONDITION FROM ALL_CONSTRAINTS WHERE TABLE_NAME = 'EXPERTS' AND CONSTRAINT_TYPE = 'C'";
$stid = @oci_parse($conn, $sql);
@oci_execute($stid);
$rows = [];
while ($r = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)) {
    $rows[] = $r;
}
@oci_free_statement($stid);
echo json_encode(['constraints' => $rows], JSON_PRETTY_PRINT) . PHP_EOL;
