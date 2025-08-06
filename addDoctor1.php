<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 3) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (
        isset($_POST['username']) && !empty($_POST['username'])
        && isset($_POST['password']) && !empty($_POST['password'])
        && isset($_POST['fullName']) && !empty($_POST['fullName'])
        && isset($_POST['email']) && !empty($_POST['email'])
        && isset($_POST['phone']) && !empty($_POST['phone'])
        && isset($_POST['gender']) && !empty($_POST['gender'])
        && isset($_POST['dob']) && !empty($_POST['dob'])
        && isset($_POST['specialty']) && !empty($_POST['specialty'])
        && isset($_POST['experience']) && !empty($_POST['experience'])
    ) {
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $name = ucwords(strtolower($_POST['fullName']));
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $gender = $_POST['gender'];
        $birth = $_POST['dob'];
        $specialty = $_POST['specialty'];
        $exp = $_POST['experience'];
        // Calculate age
        $today = date("Y-m-d");
        $age = date_diff(date_create($birth), date_create($today))->y;

        if ($age < 25) {
            echo "<script>
                alert('Doctor must be at least 25 years old.');
                window.location.href = 'addDoctor.php';
                </script>";
            exit();
        }

        // Check if username already exists
        $checkUsername = "SELECT * FROM user WHERE Username = '$username' OR Email = '$email'";
        $checkResult = $conn->query($checkUsername);

        if ($checkResult->num_rows > 0) {
            // Username already taken
            echo "<script>
                alert('Username OR Email is already taken. Please choose another one.');
                window.location.href = 'addDoctor.php';
                </script>";
            exit();
        }

        $sql_insert = "INSERT INTO `user`(`FullName`, `DateOfBirth`, `PhoneNumber`, `Gender`, `Email`, `Username`, `Password`, `role_id`, `status`) 
        VALUES ('$name','$birth','$phone','$gender','$email','$username','$password',2,'verified')";

        if ($conn->query($sql_insert)) {
            $sql_select = "SELECT ID FROM user WHERE Username = '$username'";
            $result = $conn->query($sql_select);
            $row = $result->fetch_assoc();
            $id = $row['ID'];
            $sql = "INSERT INTO `doctor`(`UserID`,`doctor_name` ,`Specialization`, `experience`) VALUES ('$id','$name' ,'$specialty', '$exp')";
            $conn->query($sql);
            $timestamp = date("Y-m-d H:i:s");
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $id = $_SESSION['id'];
            $user_name = $_SESSION['name'];
            $sql_system_log = "INSERT INTO `systemlog`(`Timestamp`, `UserID`, `Action`, `IPAddress`) 
            VALUES ('$timestamp','$id',' Receptionist $user_name Added Doctor $name','$ip_address')";
            $conn->query($sql_system_log);
            header('Location:manageDoctor.php');
        } else {
            echo "<script>
                alert('Failed To Add Doctor!');
                window.location.href = 'manageDoctor.php';
                </script>";
        }
    } else {
        echo "<script>
            alert('Something Went Wrong. Please Try Again Later!');
            window.location.href = 'manageDoctor.php';
            </script>";
    }
}
