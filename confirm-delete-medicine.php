<?php
session_start();
if ($_SESSION['role'] != 4 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql_select = "SELECT name FROM medicines WHERE id = '$id'";
        $result = $conn->query($sql_select);
        $row = $result->fetch_assoc();
        $sql = "DELETE FROM medicines WHERE id = '$id'";
        if ($conn->query($sql) == TRUE) {
            echo "<script>
            alert('" . $row['name'] . " Deleted Successfully');
            window.location.href='Pharmacy-home.php'
            </script>";
        } else {
            echo "<script>
            alert('Something Went Wrong Please Try Again Later!')
            window.location.href = 'Pharmacy-home.php'
            </script>";
        }
    } else {
        echo "<script>
            alert('Invalid ID for" . $row['name'] . " Medicine')
            window.location.href = 'Pharmacy-home.php'
            </script>";
    }
}