<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if (isset($_POST['submitContact'])) {
    $fullname = $_POST['full_name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Create an instance of PHPMailer
    $mail = new PHPMailer(true);

    try {
        // SMTP settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ticketlessentrysystembyteamx@gmail.com';
        $mail->Password   = 'pdikzlmjxehowpib'; // ✅ No spaces!
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('ticketlessentrysystembyteamx@gmail.com', 'Mailer');
        $mail->addAddress('ticketlessentrysystembyteamx@gmail.com', 'Joe User');

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Digital Ticket';
        $mail->Body    = "
            <h3>Here is your digital ticket:</h3>
            <h4>Fullname: {$fullname}</h4>
            <h4>Email: {$email}</h4>
            <h4>Subject: {$subject}</h4>
            <h4>Message: {$message}</h4>
        ";

        if ($mail->send()) {
            $_SESSION['status'] = "Thank you for contacting us - Team X";
        } else {
            $_SESSION['status'] = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } catch (Exception $e) {
        $_SESSION['status'] = "Message failed. Error: {$mail->ErrorInfo}";
    }

    header("Location: index.php?status=success");
    exit(0);
} else {
    header("Location: index.php");
    exit(0);
}
