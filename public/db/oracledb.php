<?php
define('DB_USER', 'MVSG_APP');
define('DB_PASS', 'mvsg123');
define('DB_CONN', '(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521))
    (CONNECT_DATA = (SERVICE_NAME = Xepdb1))
)');

function getOracleConnection() {
    static $conn; 

    if (!$conn) {
        // Add OCI_SYSDBA here
        $conn = oci_connect(DB_USER, DB_PASS, DB_CONN);

        if (!$conn) {
            $e = oci_error();
            die("Oracle connection failed: " . $e['message']);
        }
    }

    return $conn;
}
?>
