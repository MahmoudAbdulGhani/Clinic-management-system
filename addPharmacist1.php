<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';

    if (
        isset($_POST['fullname']) && !empty($_POST['fullname']) &&
        isset($_POST['username']) && !empty($_POST['username']) &&
        isset($_POST['email']) && !empty($_POST['email']) &&
        isset($_POST['password']) && !empty($_POST['password']) &&
        isset($_POST['phone']) && !empty($_POST['phone']) &&
        isset($_POST['dob']) && !empty($_POST['dob']) &&
        isset($_POST['gender']) && !empty($_POST['gender'])
    ) {
        // Sanitize inputs
        $name = ucwords(($_POST['fullname']));
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $phone = $_POST['phone'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];

        // Check age
        $dobDate = new DateTime($dob);
        $currentDate = new DateTime();
        $age = $currentDate->diff($dobDate)->y;

        if ($age < 20) {
            echo "<script>
            alert('The Pharmacist must be at least 20 years old!');
            window.location.href = 'managePharmacist.php';
            </script>";
            exit();
        } // Check if username is already taken
        $check = "SELECT ID FROM user WHERE Username = '$username' OR Email = '$email'";
        $res = $conn->query($check);
        if ($res->num_rows > 0) {
            echo "
    <script>
        alert('Username OR Email is already taken. Please choose another one.');
        window.location.href = 'managePharmacist.php';
    </script>";
            exit();
        }

        // Insert user
        $insert = "INSERT INTO user (FullName, DateOfBirth, PhoneNumber, Gender, Email, Username, Password, role_id, status)
    VALUES ('$name', '$dob', '$phone', '$gender', '$email', '$username', '$password', 4, 'verified')";

        if ($conn->query($insert) === TRUE) {
            $userId = $conn->insert_id;
            $insertPharmacist = "INSERT INTO pharmacist (UserID, pharmacist_name) VALUES ('$userId', '$name')";
            $conn->query($insertPharmacist);
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $timestamp = date("Y-m-d H:i:s");
            $user_id = $_SESSION['id'];
            $user_name = $_SESSION['name'];
            $sql_system_log = "INSERT INTO `systemlog`(`Timestamp`, `UserID`, `Action`, `IPAddress`) 
            VALUES ('$timestamp','$user_id','Receptionist $user_name Added Pharmacist $name','$ip_address')";
            $conn->query($sql_system_log);
            header('Location:managePharmacist.php');
        } else {
            echo "
    <script>
        alert('Failed to add pharmacist.');
        window.location.href = 'managePharmacist.php';
    </script>";
        }
    } else {
        echo "
    <script>
        alert('Please fill in all required fields.');
        window.location.href = 'managePharmacist.php';
    </script>";
    }
}
