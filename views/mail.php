<?php

// mail
// mail@sonnieshub.com
// mail password
// $7QHPVr9Z5Md

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// function sendEmail($gmail, $subject, $htmlFilePath)

function sendEmail($to, $subject, $htmlFilePath, $emailAddress)
{
    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        $mail->isSMTP();
        $mail->Host       = 'sonnieshub.com/';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mail@sonnieshub.com';
        $mail->Password   = '$7QHPVr9Z5Md'; // Update with your Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('mail@sonnieshub.com', 'Sonnie\'s Hub');
        $mail->addAddress($to);
        $mail->addReplyTo('mail@sonnieshub.com', 'Sonnie\'s Hub');

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;

        // Load HTML content from file
        $htmlContent = file_get_contents($htmlFilePath);

        // Replace the placeholder with the actual email address
        $htmlContent = str_replace('{email}', $emailAddress, $htmlContent);

        $mail->Body    = $htmlContent;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
