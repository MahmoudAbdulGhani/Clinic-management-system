<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (
        isset($_GET['id']) && isset($_POST['username']) && !empty(trim($_POST['username']))
        && isset($_POST['fullName']) && !empty(trim($_POST['fullName']))
        && isset($_POST['email']) && !empty(trim($_POST['email']))
        && isset($_POST['phoneNumber']) && !empty(trim($_POST['phoneNumber']))
        && isset($_POST['dob']) && !empty(trim($_POST['dob']))
        && isset($_POST['gender']) && !empty(trim($_POST['gender']))
    ) {
        $id = $_GET['id'];
        $username = trim($_POST['username']);
        $name = trim($_POST['fullName']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phoneNumber']);
        $birth = trim($_POST['dob']);
        $gender = trim($_POST['gender']);

        // Use a prepared statement to avoid SQL injection
        $stmt_check = "SELECT Username FROM user WHERE ID != '$id' AND Username = '$username'";
        $result = $conn->query($stmt_check);
        if ($result->num_rows > 0) {
            echo "<script>
            alert('The username is already taken. Please try a different one.');
            window.location.href = 'editReceptionest.php';
            </script>";
            exit(); // Ensure script halts execution after alert
        } else {
            // Use a prepared statement for the update query
            $stmt_update = $conn->prepare("UPDATE `user` SET `FullName`=?, `DateOfBirth`=?, `PhoneNumber`=?, `Gender`=?, `Email`=?, `Username`=? WHERE ID=?");
            $stmt_update->bind_param("ssssssi", $name, $birth, $phone, $gender, $email, $username, $id);

            if ($stmt_update->execute()) {
                echo "<script>
                alert('Receptionist updated successfully.');
                window.location.href = 'manage-Receptionest.php';
                </script>";
                exit(); // Halt execution after successful alert
            } else {
                echo "<script>
                alert('Something went wrong. Please try again later.');
                window.location.href = 'editReceptionest.php';
                </script>";
                exit(); // Halt execution after error alert
            }
        }
    } else {
        echo "<script>
        alert('All fields are required. Please fill out the form completely.');
        window.location.href = 'editReceptionest.php';
        </script>";
        exit(); // Ensure redirection if validation fails
    }
}
?>