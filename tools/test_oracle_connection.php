<?php
// Simple Oracle connectivity test script.
// Usage: php tools/test_oracle_connection.php

// Load DB constants from existing helper (does not call getOracleConnection to avoid die()).
require_once __DIR__ . '/../public/db/oracledb.php';

header_remove(); // prevent any accidental headers when run in CLI

$out = [
    'ok' => false,
    'oci8_available' => function_exists('oci_connect'),
    'connect' => null,
    'query' => null,
];

if (!$out['oci8_available']) {
    echo json_encode(['ok' => false, 'reason' => 'oci8_extension_missing', 'message' => 'PHP OCI8 extension not available (oci_connect missing).']);
    exit(0);
}

// Attempt to connect directly using constants defined in oracledb.php
$conn = @oci_connect(defined('DB_USER') ? DB_USER : null, defined('DB_PASS') ? DB_PASS : null, defined('DB_CONN') ? DB_CONN : null);
if (!$conn) {
    $e = oci_error();
    $msg = is_array($e) && isset($e['message']) ? $e['message'] : 'unknown';
    echo json_encode(['ok' => false, 'reason' => 'connect_failed', 'message' => $msg]);
    exit(0);
}

// Try a minimal test query
$stid = @oci_parse($conn, 'SELECT 1 FROM DUAL');
if (!$stid) {
    $e = oci_error($conn);
    $msg = is_array($e) && isset($e['message']) ? $e['message'] : 'parse_failed';
    @oci_close($conn);
    echo json_encode(['ok' => false, 'reason' => 'parse_failed', 'message' => $msg]);
    exit(0);
}

$exec = @oci_execute($stid);
if (!$exec) {
    $e = oci_error($stid);
    $msg = is_array($e) && isset($e['message']) ? $e['message'] : 'execute_failed';
    @oci_free_statement($stid);
    @oci_close($conn);
    echo json_encode(['ok' => false, 'reason' => 'execute_failed', 'message' => $msg]);
    exit(0);
}

$row = @oci_fetch_array($stid, OCI_NUM+OCI_RETURN_NULLS);
@oci_free_statement($stid);
@oci_close($conn);

echo json_encode(['ok' => true, 'value' => isset($row[0]) ? $row[0] : null]);
