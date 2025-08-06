<?php
session_start();
if ($_SESSION['role'] != 2 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_Select_Patient = "SELECT patient_id FROM medical_records WHERE id = '$id'";
        $result = $conn->query($sql_Select_Patient);
        $row = $result->fetch_assoc();
        $PatientID = $row['patient_id'];
        $sql_delete = "DELETE FROM `medical_records` WHERE id= '$id'";
        if ($conn->query($sql_delete) == TRUE) {
            header("Location:all-medical-records.php?id=$PatientID");
        } else {
            echo "<script>
            window.alert('Failed To Delete Record!');
            window.location.href='all-medical-records.php?id=$patient_id';
            </script>";
        }
    }
}