<?php
// Example: assume you already queried the database for user info
// $row contains ['password_hash' => '$2y$10$...'] from DB

$userInput = $_GET['password'];      // plain text password from URL
$storedHash = $_GET['password_hash']; // hashed password from DB

if ($storedHash && password_verify($userInput, $storedHash)) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
