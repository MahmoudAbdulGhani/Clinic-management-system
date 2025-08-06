<?php
session_start();
if ($_SESSION['role'] != 4 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    if (
        isset($_POST['name']) && !empty($_POST['name'])
        && isset($_POST['description']) && !empty($_POST['description'])
        && isset($_POST['dose']) && !empty($_POST['dose'])
        && isset($_POST['stock']) && !empty($_POST['stock'])
        && isset($_POST['expiry_date']) && !empty($_POST['expiry_date'])
    ) {
        require_once '../connection.php';
        $name = $_POST['name'];
        $description = $_POST['description'];
        $dose = $_POST['dose'];
        $stock = $_POST['stock'];
        $expiry_date = $_POST['expiry_date'];
        $pharmacist_id = $_SESSION['id'];
        $name = $_SESSION['name'];
        $sql_insert = "INSERT INTO `medicines`(`name`, `description`, `stock`, `dose`, `expiry_date`, `pharmacist_id`, `added_by`) 
    VALUES ('$name','$description','$stock','$dose','$expiry_date', $pharmacist_id, '$name')";
        if ($conn->query($sql_insert) == TRUE) {
            echo "<script>
        alert('Medicine Added Successfully!');
        window.location.href='Pharmacy-home.php';
        </script>";
        } else {
            echo "<script>
        alert('Something Went Wrong Please Try Again Later!');
        window.location.href='Pharmacy-home.php';
        </script>";
        }
    }
}
