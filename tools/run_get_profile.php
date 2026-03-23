<?php
// Temporary runner to invoke get_profile.php with a requested guardian_id
// Usage: php run_get_profile.php
$_REQUEST['guardian_id'] = '177424853338588085';
// Ensure no session overrides
if (session_status() === PHP_SESSION_ACTIVE) session_unset();
require __DIR__ . '/../public/db/get_profile.php';
