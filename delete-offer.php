<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}

require_once '../connection.php';

if (isset($_GET['id'])) {
    $appointmentId = $_GET['id'];

    // Check if the appointment exists
    $checkSql = "SELECT * FROM appointment WHERE AppointmentID = $appointmentId";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // Delete the appointment
        $deleteSql = "DELETE FROM appointment WHERE AppointmentID = $appointmentId AND Status = 'Available'";
        if ($conn->query($deleteSql) === TRUE) {
            header('Location:appointments-offer.php');
        } else {
            echo "<script>alert('Error deleting appointment.'); window.location.href='appointments-offer.php';</script>";
        }
    } else {
        echo "<script>alert('Appointment not found.'); window.location.href='appointments-offer.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='appointments-offer.php';</script>";
}
?>