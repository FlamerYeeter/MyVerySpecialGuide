<?php
require_once __DIR__ . '/public/db/oracledb.php';
putenv('TNS_ADMIN=C:\\oracle\\network\\admin');
try {
    $c = getOracleConnection();
} catch (Throwable $e) {
    echo "CONNECT_ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
function fetch($conn, $sql, $binds = []) {
    $stid = @oci_parse($conn, $sql);
    if (!$stid) return null;
    foreach ($binds as $name => $val) {
        oci_bind_by_name($stid, $name, $binds[$name]);
    }
    oci_execute($stid);
    $rows = [];
    while ($r = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_LOBS)) {
        $rows[] = $r;
    }
    @oci_free_statement($stid);
    return $rows;
}
$counts = [];
$rows = fetch($c, 'SELECT COUNT(*) AS CNT FROM RECOMMENDATION');
$counts['recommendation'] = $rows ? $rows[0]['CNT'] : null;
$rows = fetch($c, 'SELECT COUNT(*) AS CNT FROM JOB_LISTINGS');
$counts['job_listings'] = $rows ? $rows[0]['CNT'] : null;
$rows = fetch($c, 'SELECT ID, USER_ID, JOB_ID, FIT_SCORE, EXPLANATION FROM (SELECT * FROM RECOMMENDATION ORDER BY FIT_SCORE DESC) WHERE ROWNUM <= 5');
$sampleRec = $rows ?: [];
$rows = fetch($c, 'SELECT ID, TITLE, DESCRIPTION, COMPANY_NAME FROM JOB_LISTINGS WHERE ROWNUM <= 5');
$sampleJobs = $rows ?: [];
echo json_encode(['counts' => $counts, 'sample_recommendations' => $sampleRec, 'sample_jobs' => $sampleJobs], JSON_PRETTY_PRINT) . PHP_EOL;
