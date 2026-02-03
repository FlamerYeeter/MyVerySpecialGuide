<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // ✅ Get inputs
    $input = json_decode(file_get_contents('php://input'), true);

    // Get values with defaults if missing
    $to       = $input['email']    ?? 'default@example.com';
    $username = $input['username'] ?? 'NewAdmin';
    $subject  = 'Your Account Is Ready';
    $baseUrl  = 'http://mvsg.arkiease.com/_/r/mvsg/adminhub/login';

    // ✅ Generate a secure random password
    $plainPassword = bin2hex(random_bytes(4)); // e.g., "A7f3b9c2"
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // ✅ Build HTML message
    $message = "
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #f7f9fc;
                color: #333;
                padding: 20px;
            }
            .container {
                background: #fff;
                border-radius: 8px;
                padding: 30px;
                max-width: 600px;
                margin: auto;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }
            h2 { color: #0066cc; }
            a.button {
                background-color: #0066cc;
                color: #fff;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
                margin-top: 20px;
            }
            .footer {
                margin-top: 40px;
                font-size: 12px;
                color: #999;
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class='container'>
            <h2>Welcome, $username!</h2>
            <p>You have been granted access to the <strong>Staff Portal</strong>.</p>
            <p><strong>Username:</strong> $username</p>
            <p><strong>Temporary Password:</strong> $plainPassword</p>
            <p>Please log in using the button below and change your password immediately.</p>
            <a href='$baseUrl' class='button'>Login to Staff Portal</a>
            <div class='footer'>
                <p>This is an automated message. Please do not reply.</p>
            </div>
        </div>
    </body>
    </html>
    ";

    // ✅ Configure SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'myveryspecialguide@gmail.com';
    $mail->Password   = 'mlgs dsug zwuk rqlk'; // app password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // ✅ Email setup
    $mail->setFrom('myveryspecialguide@gmail.com', 'My Very Special Guide');
    $mail->addAddress($to);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body    = $message;

    // ✅ Send it
    $mail->send();

    // ✅ Return JSON response for APEX or frontend
    echo json_encode([
        'success' => true,
        'email'   => $to,
        'username'=> $username,
        'password'=> $plainPassword,
        'hash'    => $hashedPassword
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error'   => $mail->ErrorInfo
    ]);
}
?>
