<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    $id = $_GET['id'];


    $sql_del_user = "DELETE FROM user WHERE ID = '$id'";
    if ($conn->query($sql_del_user)) {
        echo "<script>
                alert('Receptionest Was Deleted');
                window.location.href = 'manage-Receptionest.php'
                </script>";
    } else {
        echo "<script>
                alert('Something Went Wrong Please Try Again Later');
                window.location.href = 'manage-Receptionest.php'
                </script>";
    }
}
