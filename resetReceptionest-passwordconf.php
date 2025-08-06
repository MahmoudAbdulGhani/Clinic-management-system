<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (
        isset($_POST['newPassword']) && !empty($_POST['newPassword'])
        && isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword'])
        && isset($_GET['id'])
    ) {
        $id = $_GET['id'];
        $newPass = md5($_POST['newPassword']);
        $confPass = md5($_POST['confirmPassword']);
        if ($newPass == $confPass) {
            $updatedPass = md5($_POST['confirmPassword']);
            $sql = "UPDATE user SET Password = '$updatedPass' WHERE ID = '$id'";
            if ($conn->query($sql) == TRUE) {
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $timestamp = date('Y-m-d H:i:s');
                $user_name = $_SESSION['name'];
                $user_id = $_SESSION['id'];
                $select_recep = "SELECT recep_name FROM receptionist WHERE UserID = '$id'";
                $result = $conn->query($select_recep);
                $row = $result->fetch_assoc();
                $recep_name = $row['recep_name'];
                $sql_insert = "INSERT INTO `systemlog`(`Timestamp`, `UserID`, `Action`, `IPAddress`) 
                VALUES ('$timestamp','$user_id','Admin $user_name Reset Password for Receptionist $recep_name','$ip_address')";
                $conn->query($sql_insert);
                echo "<script>
                alert('Password Changed Successsfully');
                window.location.href = 'manage-Receptionest.php';
                </script>";
            } else {
                echo "<script>
                alert('Something Went Wrong, Please Try Again Later');
                window.location.href = 'manage-Receptionest.php';
                </script>";
            }
        } else {
            echo "<script>
                alert('Password Doesn't Match')
                window.location.href = 'resetReceptionest.php';
                </script>";
        }
    }
}