<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (
        isset($_POST['fullName']) && !empty($_POST['fullName'])
        && isset($_POST['email']) && !empty($_POST['email'])
        && isset($_POST['phoneNumber']) && !empty($_POST['phoneNumber'])
        && isset($_POST['username']) && !empty($_POST['username'])
        && isset($_POST['password']) && !empty($_POST['password'])
        && isset($_POST['dob']) && !empty($_POST['dob'])
        && isset($_POST['gender']) && !empty($_POST['gender'])
    ) {
        $name = $_POST['fullName'];
        $email = $_POST['email'];
        $phone = $_POST['phoneNumber'];
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $birth = $_POST['dob'];
        $gender = $_POST['gender'];
        $sql = "SELECT Username FROM user WHERE Username = '$username' OR Email = '$email'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<script>
                alert('The Username OR Email Is Taken');
                window.location.href = 'add-Receptionest.php'
                </script>";
        } else {
            $sql_insert = "INSERT INTO `user`(`FullName`, `DateOfBirth`, `PhoneNumber`, `Gender`, `Email`, `Username`, `Password`, `role_id`, `status`)
             VALUES ('$name','$birth','$phone','$gender','$email','$username','$password',3,'verified')";
            if ($conn->query($sql_insert) == TRUE) {
                $sql_select = "SELECT ID FROM user WHERE Username = '$username'";
                $result = $conn->query($sql_select);
                $row = $result->fetch_assoc();
                $recep_id = $row['ID'];
                $sql_insert = "INSERT INTO `receptionist`(`UserID`, `recep_name`) VALUES ('$recep_id', '$name')";
                $conn->query($sql_insert);
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $timestamp = date('Y-m-d H:i:s');
                $id = $_SESSION['id'];
                $user_name = $_SESSION['name'];
                $sql_insert_systemlog = "INSERT INTO `systemlog`(`Timestamp`, `UserID`, `Action`, `IPAddress`) 
                VALUES ('$timestamp','$id','Admin $user_name Added Receptionest $name','$ip_address')";
                $conn->query($sql_insert_systemlog);
                echo "<script>
                alert('Receptionest Added Successfully');
                window.location.href = 'manage-Receptionest.php'
                </script>";
            }
        }
    }
}