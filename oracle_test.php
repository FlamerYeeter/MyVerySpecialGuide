<?php
// quick test — does NOT modify oracledb.php
// Save this as oracle_test.php in the repo root and run it with php.exe

error_reporting(E_ALL);
ini_set('display_errors', '1');

$path = __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'db' . DIRECTORY_SEPARATOR . 'oracledb.php';
if (! file_exists($path)) {
    echo "ERROR: cannot find $path\n";
    exit(2);
}

// Ensure Oracle client uses local TNS_ADMIN (matches controller quick-test override)
@putenv('TNS_ADMIN=C:\\oracle\\network\\admin');

require $path;

try {
    $conn = getOracleConnection();
    if ($conn) {
        echo "OCI CONNECTED\n";
        // Print a short oci resource description if possible
        var_export($conn);
    } else {
        $err = oci_error();
        echo "OCI connect failed:\n";
        var_export($err);
    }
} catch (Throwable $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
?>
