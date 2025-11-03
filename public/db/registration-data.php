<?php
require_once 'oracledb.php'; 

$conn = getOracleConnection(); 
$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data) {
    http_response_code(400);
    die("Invalid data");
}


?>
