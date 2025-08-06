<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_delete_medical_records = "DELETE FROM medical_records WHERE appointment_id = '$id'";
        $conn->query($sql_delete_medical_records);
        $sql_delete = "DELETE FROM appointment WHERE AppointmentID = '$id'";//delete appointment details if it's status is canceled
        $conn->query($sql_delete);
        header('Location:appointments.php');
        exit();
    } else {
        echo "<script>
        alert('Something Went Wrong Try Again Later!');
        window.location.href = 'appointments.php';
        </script>";
    }
}