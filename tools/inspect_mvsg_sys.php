<?php
require_once __DIR__ . '/../public/db/oracledb.php';
$conn = null;
try { $conn = getOracleConnection(); } catch (Throwable $e) { echo json_encode(['ok'=>false,'error'=>'connect_failed','message'=>$e->getMessage()], JSON_PRETTY_PRINT); exit(1); }

$result = ['ok'=>true,'dba_tables'=>null,'all_tables'=>null,'counts'=>[]];

// Try DBA_TABLES (may require privileges)
$sql = "SELECT OWNER, TABLE_NAME FROM DBA_TABLES WHERE OWNER='SYS' AND TABLE_NAME LIKE 'MVSG%'";
$stid = @oci_parse($conn, $sql);
if ($stid) {
    if (@oci_execute($stid)) {
        $rows = [];
        while ($r = @oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) $rows[] = $r;
        $result['dba_tables'] = $rows;
    } else {
        $result['dba_tables'] = ['error' => 'execute_failed'];
    }
    @oci_free_statement($stid);
} else {
    $result['dba_tables'] = ['error'=>'parse_failed'];
}

// Try ALL_TABLES for SYS
$sql2 = "SELECT OWNER, TABLE_NAME FROM ALL_TABLES WHERE OWNER='SYS' AND TABLE_NAME LIKE 'MVSG%'";
$stid2 = @oci_parse($conn, $sql2);
if ($stid2) {
    if (@oci_execute($stid2)) {
        $rows = [];
        while ($r = @oci_fetch_array($stid2, OCI_ASSOC+OCI_RETURN_NULLS)) $rows[] = $r;
        $result['all_tables'] = $rows;
    } else {
        $result['all_tables'] = ['error' => 'execute_failed'];
    }
    @oci_free_statement($stid2);
} else {
    $result['all_tables'] = ['error'=>'parse_failed'];
}

// Direct counts for common owner-qualified names
$to_check = ['"SYS"."MVSG_ADMIN"','"SYS"."MVSG_JOB_POSTINGS"','"SYS"."MVSG_USER_GUARDIAN"','"SYS"."MVSG_USER_PROFILE"'];
foreach ($to_check as $qname) {
    $sqlc = "SELECT COUNT(*) CNT FROM " . $qname;
    $stidc = @oci_parse($conn, $sqlc);
    if ($stidc) {
        $ok = @oci_execute($stidc);
        if ($ok) {
            $r = @oci_fetch_array($stidc, OCI_NUM+OCI_RETURN_NULLS);
            $cnt = intval($r[0] ?? 0);
            $result['counts'][$qname] = $cnt;
        } else {
            $e = oci_error($stidc);
            $result['counts'][$qname] = ['error' => $e['message'] ?? 'execute_failed'];
        }
        @oci_free_statement($stidc);
    } else {
        $result['counts'][$qname] = ['error' => 'parse_failed'];
    }
}

echo json_encode($result, JSON_PRETTY_PRINT);
