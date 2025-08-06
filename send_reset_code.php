<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'connection.php';

// Load PHPMailer
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


$email = $_POST['email'];
$otp = rand(100000, 999999);
$send_time = date("Y-m-d H:i:s");

// Check if email exists
$stmt = $conn->prepare("SELECT * FROM user WHERE Email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Save OTP and time
    $update = $conn->prepare("UPDATE user SET otp=?, otp_send_time=?, verify_otp= 0 WHERE Email=?");
    $update->bind_param("sss", $otp, $send_time, $email);
    $update->execute();

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Change this
        $mail->SMTPAuth = true;
        $mail->Username = 'amdatxpa@gmail.com';
        $mail->Password = 'cbhkmjadmhuvqpwq';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        //Recipients
        $mail->setFrom('amdatxpa@gmail.com', 'medicareHub');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Reset Password OTP';
        $mail->Body = "Your OTP code is: <b>$otp</b>. It will expire in 10 minutes.";

        $mail->send();
        header("Location: verify_otp.php?email=$email");
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

} else {
    echo "Email not found.";
}
