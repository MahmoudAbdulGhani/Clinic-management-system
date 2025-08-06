<?php
session_start();
if ($_SESSION['role'] != 5 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    $id = $_GET['id'];
    $sql = "DELETE FROM chat_with_us WHERE id = '$id'";
    if ($conn->query($sql) == TRUE) {
        header('Location:chat.php');
        exit();
    } else {
        echo "<script>
        alert('Failed To Delete!!!');
        window.location.href='chat.php';
        </script>";
    }
}
