<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // 1️⃣ Get input (JSON or form)
    $input = json_decode(file_get_contents('php://input'), true);
    if (!is_array($input)) {
        $input = $_REQUEST; // fallback
    }

    // 2️⃣ Required parameter
    if (empty($input['email'])) {
        throw new Exception('Missing required parameter: email');
    }

    $to = trim($input['email']);

    // 3️⃣ Optional dynamic reset URL
    $resetBaseUrl = !empty($input['reset_url'])
        ? trim($input['reset_url'])
        : 'http://mvsg.arkiease.com/_/r/mvsg/adminhub/reset-password';
    $subject = "Password Reset";

    // 4️⃣ Generate a secure hash
    $hash = bin2hex(random_bytes(16));

    // 5️⃣ Build the reset link
    $resetLink = $resetBaseUrl . '?hash=' . $hash;

    // 6️⃣ BEAUTIFUL PROFESSIONAL EMAIL TEMPLATE 🎨
    $message = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Reset Your Password</title>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
            
            body {
                margin: 0;
                padding: 0;
                background-color: #f8fafc;
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                line-height: 1.6;
                color: #334155;
            }
            .wrapper {
                width: 100%;
                table-layout: fixed;
                background-color: #f8fafc;
                padding: 40px 0;
            }
            .main {
                background-color: #ffffff;
                margin: 0 auto;
                width: 100%;
                max-width: 600px;
                border-radius: 16px;
                overflow: hidden;
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
                border: 1px solid #e2e8f0;
            }
            .header {
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                padding: 48px 40px;
                text-align: center;
            }
            .logo {
                width: 64px;
                height: 64px;
                background-color: rgba(255,255,255,0.2);
                border-radius: 16px;
                margin: 0 auto 20px;
                display: flex;
                align-items: center;
                justify-content: center;
                backdrop-filter: blur(10px);
            }
            .logo svg {
                width: 36px;
                height: 36px;
                fill: white;
            }
            .header h1 {
                color: white;
                font-size: 28px;
                font-weight: 700;
                margin: 0;
                letter-spacing: -0.5px;
            }
            .content {
                padding: 48px 40px;
                text-align: center;
            }
            .greeting {
                font-size: 18px;
                font-weight: 600;
                color: #1e293b;
                margin-bottom: 12px;
            }
            .message {
                font-size: 16px;
                color: #475569;
                margin-bottom: 32px;
            }
            .button {
                display: inline-block;
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                color: white;
                font-weight: 600;
                font-size: 17px;
                text-decoration: none;
                padding: 16px 36px;
                border-radius: 12px;
                box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.4);
                transition: all 0.2s ease;
                margin-bottom: 32px;
            }
            .button:hover {
                transform: translateY(-2px);
                box-shadow: 0 20px 25px -5px rgba(99, 102, 241, 0.5);
            }
            .info {
                background-color: #f1f5f9;
                border-radius: 12px;
                padding: 20px;
                margin: 32px 0;
                font-size: 14px;
                color: #64748b;
            }
            .security {
                font-size: 14px;
                color: #94a3b8;
                margin-top: 40px;
            }
            .footer {
                background-color: #0f172a;
                color: #94a3b8;
                padding: 40px;
                text-align: center;
                font-size: 13px;
            }
            .footer a {
                color: #c084fc;
                text-decoration: none;
            }
            @media (max-width: 600px) {
                .content { padding: 32px 24px !important; }
                .header { padding: 40px 24px !important; }
            }
        </style>
    </head>
    <body>
        <center class='wrapper'>
            <table class='main' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                <!-- Header -->
                <tr>
                    <td class='header'>
                        <div class='logo'>
                            <svg viewBox='0 0 24 24'><path d='M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z'/></svg>
                        </div>
                        <h1>Password Reset Request</h1>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td class='content'>
                        <h2 class='greeting'>Hi there,</h2>
                        <p class='message'>
                            We received a request to reset your password. Click the button below to create a new one. 
                            This link will expire in 1 hour for security.
                        </p>
                        
                        <a href='{$resetLink}' class='button'>Reset Your Password</a>
                        
                        <div class='info'>
                            <strong>Security tip:</strong> Use a unique password with letters, numbers, and symbols. 
                            Never share this link with anyone.
                        </div>
                        
                        <p class='security'>
                            If you didn't request this, you can safely ignore this email. 
                            Your password will remain unchanged.
                        </p>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td class='footer'>
                        <p style='margin:0 0 8px;'>
                            © 2025 My Very Special Guide. All rights reserved.
                        </p>
                        <p style='margin:0;'>
                            Need help? Contact <a href='mailto:support@myveryspecialguide.com'>support@myveryspecialguide.com</a>
                        </p>
                    </td>
                </tr>
            </table>
        </center>
    </body>
    </html>
    ";

    // 7️⃣ Configure PHPMailer (example with Gmail SMTP)
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'myveryspecialguide@gmail.com';
    $mail->Password = 'mlgs dsug zwuk rqlk'; // use app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('myveryspecialguide@gmail.com', 'Support');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;

    // 8️⃣ Send email
    $mail->send();

    // 9️⃣ Return JSON response
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'success',
        'email' => $to,
        'reset_link' => $resetLink,
        'hash' => $hash
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>