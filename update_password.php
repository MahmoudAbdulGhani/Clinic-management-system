<?php
require_once 'connection.php';
$email = $_POST['email'];
$password = md5($_POST['new_password']);

// Check OTP verified
$check = $conn->prepare("SELECT verify_otp FROM user WHERE Email=?");
$check->bind_param("s", $email);
$check->execute();
$result = $check->get_result();
$user = $result->fetch_assoc();

if ($user && $user['verify_otp'] == 1) {
    $update = $conn->prepare("UPDATE user SET Password=?, otp=NULL, otp_send_time=NULL, verify_otp=0 WHERE Email=?");
    $update->bind_param("ss", $password, $email);
    $update->execute();
    echo "<script>
    alert('Password Update Successfully');
    window.location.href='login.html';
    </script>";
} else {
    echo "OTP not verified.";
}
?>