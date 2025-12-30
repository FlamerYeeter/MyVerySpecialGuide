<?php
// CLI test harness for get-job-details.php
$_GET['id'] = $argv[1] ?? '64863154910990791131715580598838685407';
require __DIR__ . '/get-job-details.php';
// dump any buffered output
echo "\n--- CLI DONE ---\n";
?>