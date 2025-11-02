<?php
require_once 'oracledb.php'; 

$conn = getOracleConnection(); 
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    die("Invalid data");
}

$sql = "INSERT INTO mvsg.audit_logs (
    id,
    actor_id,
    actor_type
) VALUES ( :v0,
           :v1,
           :v2
           )";
$stid = oci_parse($conn, $sql);

oci_bind_by_name($stid, ':v1',  $data['firstName']);
oci_bind_by_name($stid, ':v2',   $data['lastName']);
oci_bind_by_name($stid, ':v3',  $data['email']);

$r = oci_execute($stid);
if ($r) echo "✅ Saved successfully!";
else {
    $e = oci_error($stid);
    echo "Insert failed: " . $e['message'];
}

oci_free_statement($stid);
?>
