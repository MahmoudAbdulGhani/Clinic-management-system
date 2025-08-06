<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 3) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        // Redirect or show an error if no ID is provided
        header('Location:ManagePatient.php');
        exit();
    }
    $sql_Select = "SELECT patient_name FROM patient WHERE UserID = '$id'";
    $result = $conn->query($sql_Select);
    $row = $result->fetch_assoc();
    $patient_name = $row['patient_name'];
    // Delete related records
    $conn->query("DELETE FROM patient_medicine WHERE patient_id = '$id'");
    $conn->query("DELETE FROM medical_records WHERE patient_id = '$id'");
    $conn->query("DELETE FROM appointment WHERE PatientID = '$id'");
    $conn->query("DELETE FROM chat_with_us WHERE patient_id = '$id'");
    $conn->query("DELETE FROM systemlog WHERE UserID = '$id'");
    $conn->query("DELETE FROM patient WHERE UserID = '$id'");
    $conn->query("DELETE FROM user WHERE ID = '$id'");
    $timestamp = date("Y-m-d H:i:s");
    $ip_address = $_SERVER['REMOTE_ADDR'];
    $id = $_SESSION['id'];
    $user_name = $_SESSION['name'];
    $sql_system_log = "INSERT INTO systemlog(Timestamp, UserID, Action, IPAddress)VALUES('$timestamp', '$id', 'Receptionist $user_name deleted Patient $patient_name', '$ip_address')";
    $conn->query($sql_system_log);

    header('Location:ManagePatient.php');
    exit();
}
?>