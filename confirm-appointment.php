<?php
session_start();
if ($_SESSION['role'] != 5 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (isset($_GET['id']) && isset($_POST['appType']) && !empty($_POST['appType'])) {
        $id = $_GET['id'];
        $appType = $_POST['appType'];
        $patient_id = $_SESSION['id'];
        $sql_update = "UPDATE `appointment` SET `Status`='Scheduled', `PatientID`='$patient_id',`type`='$appType'  WHERE AppointmentID = '$id'";
        if ($conn->query($sql_update) == TRUE) {
            echo "<script>
                window.alert('Appointment Scheduled Successfully');
                window.location.href = 'appointment-history.php';
                </script>";

        } else {
            echo "<script>
            window.alert('Failed To Scheduled!!!');
            window.location.href = 'APPointment.php';
            </script>";
        }
    } else {
        echo "<script>
            window.alert('Something Went Wrong Try Again Later!');
            window.location.href = 'APPointment.php';
            </script>";
    }
}