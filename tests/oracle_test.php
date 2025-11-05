<?php
// Safe CLI Oracle connection test. Uses public/db/oracledb.php but does not call the helper that dies.
// Run from PowerShell: php tests\oracle_test.php

require_once __DIR__ . '/../public/db/oracledb.php';

echo "PHP CLI test - Oracle/OCI8 availability\n";
echo "oci_connect exists: ".(function_exists('oci_connect') ? 'yes' : 'no')."\n";

$user = defined('DB_USER') ? DB_USER : null;
$pass = defined('DB_PASS') ? DB_PASS : null;
$connstr = defined('DB_CONN') ? DB_CONN : null;

echo "DB_USER=" . ($user ?? '(null)') . "\n";
echo "DB_CONN (first 120 chars): " . (is_string($connstr) ? substr($connstr,0,120) : '(null)') . "\n";

if (!function_exists('oci_connect')) {
    echo "OCI8 is not available in this PHP binary.\n";
    exit(10);
}

echo "Attempting oci_connect() with @ to suppress warnings...\n";
$conn = @oci_connect($user, $pass, $connstr);
if ($conn) {
    echo "Connected: yes\n";
    oci_close($conn);
    exit(0);
} else {
    $err = oci_error();
    echo "Connected: no\n";
    echo "oci_error: " . json_encode($err) . "\n";
    exit(2);
}
