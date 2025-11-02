<?php
require __DIR__ . '/../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    $to = $_POST['email'] ?? 'default@example.com';
    $subject = $_POST['subject'] ?? 'No Subject';
    $message = $_POST['message'] ?? 'No message.';

    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'myveryspecialguide@gmail.com';
    $mail->Password = 'mlgs dsug zwuk rqlk';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('myveryspecialguide@gmail.com', 'My Very Special Guide');
    $mail->addAddress($to);

    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;

    $mail->send();
    echo '✅ Email sent successfully!';
} catch (Exception $e) {
    echo '❌ Failed: ', $mail->ErrorInfo;
}
