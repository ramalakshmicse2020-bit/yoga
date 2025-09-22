<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$name = htmlspecialchars($_POST['name']);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars($_POST['phone']);
$subject = htmlspecialchars($_POST['subject']);
$message = htmlspecialchars($_POST['message']);

$mailContent = "
  <h2>Contact Form Submission</h2>
  <p><strong>Name:</strong> $name</p>
  <p><strong>Email:</strong> $email</p>
  <p><strong>Phone:</strong> $phone</p>
  <p><strong>Subject:</strong> $subject</p>
  <p><strong>Message:</strong><br>$message</p>
";

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'santosh@noolmedia.in'; // Your Gmail address
    $mail->Password   = 'sjqo kiux sgyy ywts'; // Your Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // 👇 Disable SSL verification for localhost
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true,
        ],
    ];

    $mail->setFrom('santosh@noolmedia.in', 'Website Contact');
    $mail->addAddress('santosh@noolmedia.in');

    $mail->isHTML(true);
    $mail->Subject = 'New Contact Form Submission';
    $mail->Body    = $mailContent;

    $mail->send();

    // ✅ On success, redirect to contact.html with success flag
    header("Location: /yoga/contact.html?status=success");
    exit();

} catch (Exception $e) {
    // ❌ On error, redirect with error message
    $error = urlencode($mail->ErrorInfo);
    header("Location: /yoga/contact.html?status=error&message=$error");
    exit();
}
