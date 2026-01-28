<?php
session_start();
header('Content-Type: application/json');
require_once 'oracledb.php'; // getOracleConnection()

$input = json_decode(file_get_contents('php://input'), true);
$email = trim($input['email'] ?? '');
$password = $input['password'] ?? '';

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Email and password are required.']);
    exit;
}

$conn = getOracleConnection();
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit;
}

$sql = "SELECT id, email, password, first_name, last_name
        FROM user_guardian
        WHERE upper(email) = upper(:email)";

$stid = oci_parse($conn, $sql);
oci_bind_by_name($stid, ':email', $email);
oci_execute($stid);
$row = oci_fetch_assoc($stid);

if ($row && password_verify($password, $row['PASSWORD'])) {
    // ✅ Create session
    $_SESSION['user_id'] = $row['ID'];
    $_SESSION['user_email'] = $row['EMAIL'];

    echo json_encode([
        'success' => true,
        'session_id' => session_id(),
        'user' => [
            'id' => $row['ID'],
            'email' => $row['EMAIL'],
            'name' => $row['FIRST_NAME'] . ' ' . $row['LAST_NAME']
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
}

oci_free_statement($stid);
oci_close($conn);
?>
