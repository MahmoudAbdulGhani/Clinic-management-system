<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'connection.php';

// Load PHPMailer
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

if (isset($_POST['send'])) {
    // Get and sanitize user input
    $name = $conn->real_escape_string(ucwords($_POST['fullName']));
    $phone = $conn->real_escape_string($_POST['phoneNumber']);
    $email = $conn->real_escape_string($_POST['email']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = md5($_POST['password']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $otp = rand(100000, 999999);
    $ip_address = $_SERVER['REMOTE_ADDR'];

    // ✅ Check if user is at least 18 years old
    $dobDate = new DateTime($dob);
    $today = new DateTime();
    $age = $today->diff($dobDate)->y;

    if ($age < 18) {
        echo "
        <script>
            alert('You must be at least 18 years old to register.');
            window.location.href = 'register.html';
        </script>
        ";
        exit();
    }

    // Check for existing username
    $checkQuery = "SELECT * FROM `user` WHERE Username = '$username' OR Email = '$email'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        echo "
        <script>
            alert('Username or Email is already registered!');
            window.location.href = 'register.html';
        </script>
        ";
        exit();
    }

    // Insert into database
    $sql = "INSERT INTO `user`(`FullName`, `DateOfBirth`, `PhoneNumber`, `Gender`, `Email`, `Username`, `Password`, `role_id`, `otp`, `otp_send_time`, `ip`, `status`) 
            VALUES ('$name', '$dob', '$phone', '$gender', '$email', '$username', '$password', 5, '$otp', NOW(), '$ip_address', 'pending')";

    if ($conn->query($sql) === TRUE) {
        $mail = new PHPMailer(true);

        try {
            // Email configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'amdatxpa@gmail.com'; // Your Gmail
            $mail->Password = 'cbhkmjadmhuvqpwq';   // App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender and recipient
            $mail->setFrom('amdatxpa@gmail.com', 'medicareHub');
            $mail->addAddress($email);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Your OTP Verification Code';

            $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f7fc;
                        color: #333;
                        padding: 20px;
                    }
                    .email-container {
                        background-color: #ffffff;
                        border-radius: 8px;
                        padding: 30px;
                        border: 1px solid #ddd;
                        max-width: 600px;
                        margin: 0 auto;
                    }
                    .header {
                        background-color: #007bff;
                        color: white;
                        padding: 20px;
                        text-align: center;
                        border-radius: 8px 8px 0 0;
                    }
                    .content {
                        margin-top: 20px;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 30px;
                        font-size: 12px;
                        color: #aaa;
                    }
                    .button {
                        background-color: #007bff;
                        color: white;
                        padding: 12px 30px;
                        border-radius: 5px;
                        text-decoration: none;
                        color: #ffffff;
                    }
                    .button:hover {
                        background-color: #0056b3;
                    }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>
                        <h2>OTP Verification Code</h2>
                    </div>
                    <div class='content'>
                        <p>Hello <strong>$name</strong>,</p>
                        <p>Thank you for registering with us! To complete your registration, please use the following Verification Code to verify your email address:</p>
                        <h3 style='color: #007bff;'>Your Verification Code: $otp</h3>
                        <p>This Verification code is valid for the next 15 minutes. Please do not share it with anyone.</p>
                        <p>If you didn't request this, please ignore this email.</p>
                        <p>Best regards,<br><strong>MedicareHub Team</strong></p>
                        <a href='http://localhost/medicarehub/verify.php' class='button'>Verify Now</a>
                    </div>
                    <div class='footer'>
                        <p>For support, contact us at <a href='mailto:support@medicarehub.com'>support@medicarehub.com</a></p>
                    </div>
                </div>
            </body>
            </html>
            ";

            // Send email
            $mail->send();
            echo "
            <script>
                alert('Verification code has been sent to your email.');
                window.location.href='verify.php';
            </script>
            ";
        } catch (Exception $e) {
            echo "
            <script>
                alert('Email sending failed. Error: {$mail->ErrorInfo}');
                window.location.href='index.php';
            </script>
            ";
        }
    } else {
        echo "
        <script>
            alert('Error inserting data: {$conn->error}');
            window.location.href = 'index.php';
        </script>
        ";
    }
}
