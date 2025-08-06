<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 5) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_delete = "DELETE FROM chat_with_us WHERE id = '$id'";
        if ($conn->query($sql_delete) == TRUE) {
            header('Location:chat.php');
        } else {
            echo "<script>
            window.alert('Failed To Cancel The Question');
            window.location.href ='chat.php';
            </script>";
        }
    } else {
        echo "<script>
        window.alert('Invalid ID');
        window.location.href ='chat.php';
        </script>";
    }
}