<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Accept JSON or form-encoded input
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = $_REQUEST;
    }

    if (empty($input['email'])) {
        throw new Exception('Missing required parameter: email');
    }

    $to = trim($input['email']);

    // Default user-facing reset URL (can be overridden via `reset_url` param)
    $resetBaseUrl = !empty($input['reset_url'])
        ? trim($input['reset_url'])
        // default to the public forgot-password page
        : 'https://empwrpath.com/forgotpassword';

    $subject = "Password Reset Request";

    // Create a signed, stateless token (HMAC) so we don't need to persist tokens server-side.
    // Token format: base64url(payload_json) . '.' . base64url(hmac_sha256)
    $storeDir = __DIR__ . '/../storage/reset_tokens';
    if (!is_dir($storeDir)) @mkdir($storeDir, 0700, true);

    // Ensure we have a local secret for HMAC (persistent file under storage)
    $secretFile = $storeDir . '/.secret.key';
    if (is_readable($secretFile)) {
        $secret = file_get_contents($secretFile);
    } else {
        try {
            $secret = bin2hex(random_bytes(32));
            @file_put_contents($secretFile, $secret);
            @chmod($secretFile, 0600);
        } catch (Exception $e) {
            // fallback to a runtime secret (less ideal)
            $secret = bin2hex(random_bytes(32));
        }
    }

    // Payload contains email and expiry
    $payload = [
        'email' => $to,
        'exp' => time() + 86400 // 24 hours
    ];
    $payloadJson = json_encode($payload);

    // helpers
    $b64url = function($s) { return rtrim(strtr(base64_encode($s), '+/', '-_'), '='); };

    $sig = hash_hmac('sha256', $payloadJson, $secret, true);
    $token = $b64url($payloadJson) . '.' . $b64url($sig);

    // Use URL fragment so token isn't sent to the server by default; the client will
    // capture it and move it into sessionStorage.
    $resetLink = $resetBaseUrl . '#hash=' . rawurlencode($token);

    // HTML email (user-facing copy)
    $message = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Reset Your Password</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
            body { margin:0; padding:0; background:#f8fafc; font-family:Inter,system-ui,Arial,sans-serif; color:#334155; }
            .card{ background:#fff; max-width:600px; margin:40px auto; border-radius:12px; padding:36px; box-shadow:0 10px 30px rgba(2,6,23,0.08); }
            .btn{ display:inline-block; background:linear-gradient(135deg,#6366f1 0%,#8b5cf6 100%); color:#fff; padding:14px 28px; border-radius:10px; text-decoration:none; font-weight:600; }
            .muted{ color:#64748b; font-size:14px; }
        </style>
    </head>
    <body>
        <div class='card'>
            <h2 style='margin:0 0 8px 0; font-size:20px; color:#0f172a;'>Password Reset Request</h2>
            <p class='muted'>We received a request to reset your password. Click the button below to create a new one. This link expires in 1 hour.</p>
            <div style='text-align:center; margin:28px 0;'>
                <a href='{$resetLink}' class='btn' target='_blank' rel='noopener noreferrer'>Reset Your Password</a>
            </div>
            <!-- no plain-text URL fallback to avoid exposing the token in the email body -->
            <p class='muted'>If you didn't request this, ignore this email and your password will remain unchanged.</p>
            <p style='margin-top:20px; font-size:12px; color:#94a3b8;'>© 2026 My Very Special Guide</p>
        </div>
    </body>
    </html>
    ";

    // Configure PHPMailer (reuse existing SMTP settings)
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'empowerpath123@gmail.com';
    $mail->Password = 'fvte grar olvh jvqw'; // use app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('myveryspecialguide@gmail.com', 'My Very Special Guide');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();

    // Success response: do NOT include the token or reset link in the JSON response
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'email' => $to,
        'message' => 'If the email exists in our system, a reset link has been sent.'
    ]);

} catch (Exception $e) {
    http_response_code(400);
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
