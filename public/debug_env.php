<?php
header('Content-Type: application/json');
$out = [];
$out['sapi'] = php_sapi_name();
$out['php_version'] = phpversion();
$out['php_ini'] = php_ini_loaded_file();
$out['oci8_loaded'] = extension_loaded('oci8');
$out['tns_admin_env'] = getenv('TNS_ADMIN') ?: null;
$out['tns_ora_exists'] = file_exists('C:\\oracle\\network\\admin\\sqlnet.ora');
$out['oracledb_path'] = __DIR__ . '/db/oracledb.php';
$out['oracledb_exists'] = file_exists(__DIR__ . '/db/oracledb.php');

if ($out['oracledb_exists']) {
    // Require the file to load DB_* constants but avoid calling getOracleConnection()
    require_once __DIR__ . '/db/oracledb.php';
    $out['defined_constants'] = [];
    foreach (['DB_USER','DB_PASS','DB_CONN'] as $c) {
        $out['defined_constants'][$c] = defined($c) ? true : false;
    }
    if (defined('DB_USER') && defined('DB_PASS') && defined('DB_CONN')) {
        // Try a safe oci_connect directly so failure doesn't call die() in helper
        $conn = @oci_connect(DB_USER, DB_PASS, DB_CONN);
        if ($conn) {
            $out['oracle_connect'] = ['success' => true];
            @oci_close($conn);
        } else {
            $err = @oci_error();
            $out['oracle_connect'] = ['success' => false, 'error' => $err];
        }
    }
}

// Provide some useful paths
$out['cwd'] = getcwd();
$out['script_path'] = __FILE__;

echo json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
