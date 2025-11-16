<?php
header('Content-Type: application/json');

try {
    $password = $_REQUEST['pass']; // works with both GET and POST

    if (empty($password)) {
        throw new Exception('No password provided');
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);

    if ($hash === false) {
        throw new Exception('Generate Password Failed');
    }

    // Return JSON
    echo json_encode(['hash' => $hash]);

} catch (Exception $e) {
    echo json_encode(['error' => 'Generate Password Failed']);
}
