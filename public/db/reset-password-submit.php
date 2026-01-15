<?php
require_once __DIR__ . '/oracledb.php';

header('Content-Type: application/json');

try {
    $raw = file_get_contents('php://input');
    $input = json_decode($raw, true);
    if (!is_array($input)) $input = $_REQUEST;

    $token_raw = isset($input['reset_hash']) ? $input['reset_hash'] : '';
    $token = trim(rawurldecode($token_raw));
    $password = isset($input['password']) ? $input['password'] : '';

    if (!$token) throw new Exception('Missing reset token');
    if (!$password) throw new Exception('Missing new password');

    // Validate stateless signed token (HMAC)
    $storeDir = __DIR__ . '/../storage/reset_tokens';
    $secretFile = $storeDir . '/.secret.key';

    // Ensure directory exists for debug logs
    if (!is_dir($storeDir)) @mkdir($storeDir, 0700, true);

    // Try primary secret path, otherwise attempt project-root storage path as fallback
    if (is_readable($secretFile)) {
        $secret = file_get_contents($secretFile);
    } else {
        $alt = __DIR__ . '/../../storage/reset_tokens/.secret.key';
        if (is_readable($alt)) {
            $secret = file_get_contents($alt);
            $secretFile = $alt; // for logging clarity
        } else {
            // log and return clearer error for debugging (don't include secret)
            $dbg = "[".date('c')."] Missing secret files checked: $secretFile , $alt -- called by " . ($_SERVER['REMOTE_ADDR'] ?? 'cli') . "\n";
            @file_put_contents($storeDir . '/debug.log', $dbg, FILE_APPEND | LOCK_EX);
            throw new Exception('Server misconfiguration (missing secret)');
        }
    }

    // token format: base64url(payload) . '.' . base64url(sig)
    if (strpos($token, '.') === false) throw new Exception('Invalid or expired token');
    list($bpayload, $bsig) = explode('.', $token, 2);
    $b64url_decode = function($s) {
        $pad = 4 - (strlen($s) % 4);
        if ($pad < 4) $s .= str_repeat('=', $pad);
        $s = strtr($s, '-_', '+/');
        return base64_decode($s);
    };

    $payloadJson = $b64url_decode($bpayload);
    $sig = $b64url_decode($bsig);
    if ($payloadJson === false || $sig === false) throw new Exception('Invalid or expired token');

    $expected = hash_hmac('sha256', $payloadJson, $secret, true);
    if (!hash_equals($expected, $sig)) {
        // log mismatch for debugging (do not include raw secret or sig)
        $log = "[".date('c')."] Token signature mismatch for email payload (truncated): " . substr($payloadJson,0,200) . " -- ip=" . ($_SERVER['REMOTE_ADDR'] ?? 'cli') . "\n";
        @file_put_contents($storeDir . '/debug.log', $log, FILE_APPEND | LOCK_EX);
        throw new Exception('Invalid or expired token');
    }

    $data = json_decode($payloadJson, true);
    if (!$data || !isset($data['email']) || !isset($data['exp'])) throw new Exception('Invalid token data');
    if (time() > intval($data['exp'])) throw new Exception('Token expired');

    $email = $data['email'];

    // Hash password securely
    $hash = password_hash($password, PASSWORD_DEFAULT);
    if ($hash === false) throw new Exception('Could not hash password');

    // Update Oracle USER_GUARDIAN password where email matches
    $conn = getOracleConnection();
    $sql = "UPDATE user_guardian SET password = :pwd, updated_at = SYSTIMESTAMP WHERE lower(email) = lower(:email)";
    $stid = oci_parse($conn, $sql);
    if (!$stid) throw new Exception('DB prepare failed');
    oci_bind_by_name($stid, ':pwd', $hash);
    oci_bind_by_name($stid, ':email', $email);
    $r = @oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
    if (!$r) {
        $e = oci_error($stid);
        throw new Exception('DB update failed: ' . ($e['message'] ?? ''));
    }

    // stateless token - nothing to consume server-side

    echo json_encode(['status' => 'success', 'message' => 'Password updated.']);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

?>
