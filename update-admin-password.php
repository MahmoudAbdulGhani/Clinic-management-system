<?php
session_start();
if ($_SESSION['role'] != 1 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (
        isset($_POST['oldPassword']) && !empty($_POST['oldPassword'])
        && isset($_POST['newPassword']) && !empty($_POST['newPassword'])
        && isset($_POST['confirmPassword']) && !empty($_POST['confirmPassword'])
    ) {
        $oldpass = md5($_POST['oldPassword']);
        $newpass = md5($_POST['newPassword']);
        $confPass = md5($_POST['confirmPassword']);
        $id = $_SESSION['id']; //stored in login.php
        $sql_check = "SELECT FullName, Password FROM user WHERE Password = '$oldpass' AND ID = '$id'";
        $result = $conn->query($sql_check);
        $row = $result->fetch_assoc();
        $name = $row['FullName'];
        $old_password = $row["Password"];
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $timestamp = date('Y-m-d H:i:s');
        if ($result->num_rows > 0) {
            if ($newpass == $confPass && $newpass != $old_password) {
                $sql_update = "UPDATE user SET Password = '$confPass' WHERE ID = '$id'";
                if ($conn->query($sql_update) == TRUE) {
                    $sql_insert = "INSERT INTO systemlog(Timestamp, UserID, Action, IPAddress) 
                    VALUES('$timestamp', '$id', 'Admin $name Change His Password', '$ip_address')";
                    $conn->query($sql_insert);
                    echo "<script>
            alert('The Password Has Been Changed');
            window.location.href = 'admin-home.php';
            </script>";
                } else {
                    echo "<script>
            alert('The new Password shouldn't be the old password!');
            window.location.href = 'change-admin-password.php';
            </script>";
                }
            }
        } else {
            echo "<script>
            alert('The Old Password Is Incorrect');
            window.location.href = 'change-admin-password.php';
            </script>";
        }
    }
}