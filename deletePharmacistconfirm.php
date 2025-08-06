<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "DELETE FROM user WHERE ID = '$id'";
        if (!$conn->query($sql)) {
            echo "Failed To Delete Pharmacist ";
        } else {
            header('Location:managePharmacist.php');
            exit();
        }
    }
}