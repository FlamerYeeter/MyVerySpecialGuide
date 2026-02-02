<?php
define('DB_USER', 'MVSG');
define('DB_PASS', 'MICA@PASSWORD123!');
define('DB_CONN', '(DESCRIPTION =
    (ADDRESS = (PROTOCOL = TCP)(HOST = 206.237.107.55)(PORT = 1521))
    (CONNECT_DATA = (SERVICE_NAME = APXPDB))
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
