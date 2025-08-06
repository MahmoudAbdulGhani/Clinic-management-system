<?php
require_once 'connection.php';
$email = $_POST['email'];
$entered_otp = $_POST['otp'];

$query = $conn->prepare("SELECT otp, otp_send_time FROM user WHERE Email=?");
$query->bind_param("s", $email);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

if ($user && $user['otp'] == $entered_otp) {
    $otp_time = strtotime($user['otp_send_time']);
    if (time() - $otp_time <= 600) { // 10 min
        $update = $conn->prepare("UPDATE user SET verify_otp=1 WHERE Email=?");
        $update->bind_param("s", $email);
        $update->execute();
        header("Location: reset_password.php?email=$email");
    } else {
        echo "OTP expired.";
    }
} else {
    echo "Invalid OTP.";
}
?>
