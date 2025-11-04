<?php
// One-off seeder to insert test rows into RECOMMENDATION for user_id=7
// Safe: uses conservative INSERT and commits; id is computed as MAX(ID)+1 if no sequence
require_once __DIR__ . '/public/db/oracledb.php';
putenv('TNS_ADMIN=C:\\oracle\\network\\admin');
try {
    $conn = getOracleConnection();
} catch (Throwable $e) {
    echo "CONNECT_ERROR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
$uid = 7;
$maxToInsert = 6;
// fetch up to $maxToInsert job IDs to attach recommendations to
$jobIds = [];
$js = @oci_parse($conn, 'SELECT ID FROM JOB_LISTINGS WHERE ROWNUM <= :lim');
oci_bind_by_name($js, ':lim', $maxToInsert);
if (!@oci_execute($js)) {
    $err = oci_error($js) ?: oci_error($conn);
    echo "JOB_FETCH_ERROR: " . json_encode($err) . PHP_EOL;
}
while ($r = oci_fetch_array($js, OCI_ASSOC+OCI_RETURN_LOBS)) {
    $jobIds[] = $r['ID'];
}
@oci_free_statement($js);
if (empty($jobIds)) {
    echo "No job IDs found to create recommendations; aborting.\n";
    exit(1);
}
$inserted = 0;
// Prepare an insert that computes ID as NVL(MAX(ID),0)+1 to avoid needing a sequence name
$insSql = "INSERT INTO RECOMMENDATION (ID, USER_ID, JOB_ID, FIT_SCORE, GROWTH_SCORE, EXPLANATION, STATUS) VALUES ((SELECT NVL(MAX(ID),0)+1 FROM RECOMMENDATION), :uid, :jobid, :fit, :growth, :explain, :status)";
$ins = oci_parse($conn, $insSql);
oci_bind_by_name($ins, ':uid', $uid);
oci_bind_by_name($ins, ':jobid', $jobid);
oci_bind_by_name($ins, ':fit', $fit);
oci_bind_by_name($ins, ':growth', $growth);
oci_bind_by_name($ins, ':explain', $explain);
oci_bind_by_name($ins, ':status', $status);
foreach ($jobIds as $i => $jid) {
    $jobid = $jid;
    $fit = round(0.9 - ($i * 0.1), 3);
    $growth = round(0.1 + ($i * 0.05), 3);
    $explain = "Test recommendation {$i} for uid={$uid} job={$jid}";
    // match allowed values: 'Pending', 'Accepted', 'Rejected'
    $status = 'Pending';
    // Use a literal INSERT to avoid bind-name parsing issues in this one-off script.
    $explainEsc = str_replace("'", "''", $explain);
    $sql = "INSERT INTO RECOMMENDATION (ID, EXPERTS_ID, JOB_ID, FIT_SCORE, GROWTH_SCORE, EXPLANATION, STATUS) VALUES ((SELECT NVL(MAX(ID),0)+1 FROM RECOMMENDATION), {$uid}, {$jobid}, {$fit}, {$growth}, '{$explainEsc}', '{$status}')";
    $q = @oci_parse($conn, $sql);
    $ok = @oci_execute($q, OCI_COMMIT_ON_SUCCESS);
    if (!$ok) {
        $e = oci_error($q) ?: oci_error($conn);
        echo "INSERT_ERR for job {$jobid}: " . json_encode($e) . PHP_EOL;
    } else {
        $inserted++;
    }
    @oci_free_statement($q);
}
@oci_free_statement($ins);
// Show inserted rows for uid
$check = @oci_parse($conn, 'SELECT ID, JOB_ID, FIT_SCORE, GROWTH_SCORE, EXPLANATION, STATUS FROM RECOMMENDATION WHERE USER_ID = :uid ORDER BY FIT_SCORE DESC');
oci_bind_by_name($check, ':uid', $uid, -1, SQLT_INT);
@oci_execute($check);
$rows = [];
while ($r = oci_fetch_array($check, OCI_ASSOC+OCI_RETURN_LOBS)) {
    $rows[] = $r;
}
@oci_free_statement($check);
oci_commit($conn);
echo json_encode(['uid' => $uid, 'inserted' => $inserted, 'rows' => $rows], JSON_PRETTY_PRINT) . PHP_EOL;
