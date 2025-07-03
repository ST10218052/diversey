<?php
// Load Composer's autoloader if using Composer
require 'vendor/autoload.php';

// Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Instantiate PHPMailer object
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->SMTPDebug = 0;                      // Disable verbose debug output (set to 2 for debugging)
    $mail->isSMTP();                           // Set mailer to use SMTP
    $mail->Host       = 'smtp.example.com';    // Specify your SMTP server
    $mail->SMTPAuth   = true;                  // Enable SMTP authentication
    $mail->Username   = 'your-email@example.com'; // SMTP username
    $mail->Password   = 'your-password';       // SMTP password
    $mail->SMTPSecure = 'tls';                 // Enable TLS encryption, `ssl` also accepted
    $mail->Port       = 587;                   // TCP port to connect to

    // Recipients
    $mail->setFrom('your-email@example.com', 'Your Name');   // Your email and name
    $mail->addAddress('Mulaudziitani16@gmail.com', 'Itani Mulaudzi'); // Recipient's email and name

    // Content
    $mail->isHTML(true);                       // Set email format to HTML
    $mail->Subject = 'Test Email from PHPMailer';
    $mail->Body    = 'This is a test email sent using PHPMailer.';
    $mail->AltBody = 'This is the plain text version of the email content.';

    // Send email
    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
