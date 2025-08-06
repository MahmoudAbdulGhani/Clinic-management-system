<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 3) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql_update = "UPDATE `patient_medicine` SET `Status` = 'Canceled' WHERE id = '$id'";
    if ($conn->query($sql_update) == TRUE) {
        header('Location:pharmacy-Request-History.php');
        exit();
    }
} else {
    echo "<script>
    window.aler('Invalid ID!!!');
    window.location.href='pharmacy-Request-History.php';
    </script>";
}