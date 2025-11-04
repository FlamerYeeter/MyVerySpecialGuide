<?php
require_once __DIR__ . '/public/db/oracledb.php';
putenv('TNS_ADMIN=C:\\oracle\\network\\admin');
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo "CONNECT: " . $e->getMessage() . PHP_EOL; exit(1); }
$id = 7;
$fname = 'Test';
$lname = 'User7';
$email = 'test7@example.com';
$sql = "INSERT INTO EXPERTS (ID, FIRST_NAME, LAST_NAME, EMAIL, PASSWORD, APPROVAL_STATUS, EMAIL_VERIFIED, ROLE) VALUES ({$id}, '{$fname}', '{$lname}', '{$email}', 'pwd', 'Y', 'N', 'Mentor')";
$q = @oci_parse($conn, $sql);
$ok = @oci_execute($q, OCI_COMMIT_ON_SUCCESS);
if (!$ok) {
    $e = oci_error($q) ?: oci_error($conn);
    echo "EXPERT_INSERT_ERR: " . json_encode($e) . PHP_EOL;
} else {
    echo "Inserted EXPERTS id={$id}\n";
}
@oci_free_statement($q);
