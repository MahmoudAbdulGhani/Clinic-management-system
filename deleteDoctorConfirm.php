<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    $id = $_GET['id'];
    $sql = "DELETE FROM user WHERE ID = '$id'";
    if ($conn->query($sql) == TRUE) {
        header('Location:manageDoctor.php');
    } else {
        echo "<script>
        alert('Failed To Delete Doctor!!!');
        window.location.href = 'manageDoctor.php';
        </script>";
    }
}
