<?php
session_start();

// Ensure the user is logged in and has the right role (role 4)
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 4) {
    header('Location: ../login.html');
    exit();
}

require_once '../connection.php';

// Check if the necessary form data and id are provided
if (
    isset($_POST['name']) && !empty($_POST['name'])
    && isset($_POST['description']) && !empty($_POST['description'])
    && isset($_POST['dose']) && !empty($_POST['dose'])
    && isset($_POST['stock']) && !empty($_POST['stock'])
    && isset($_POST['expiry_date']) && !empty($_POST['expiry_date'])
    && isset($_GET['id'])
) {
    // Sanitize input data
    $id = $_GET['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $dose = $_POST['dose'];
    $stock = intval($_POST['stock']);  // Ensure stock is an integer
    $expiry_date = $_POST['expiry_date'];
    $pharmacist_id = $_SESSION['id'];
    $pharmacist_name = $_SESSION['name'];
    // Update query to modify the medicine record
    $sql_update = "UPDATE `medicines` SET 
                    `name` = '$name', 
                    `description` = '$description',
                    `dose` = '$dose',
                    `stock` = '$stock',
                    `expiry_date` = '$expiry_date',
                    `pharmacist_id` = '$pharmacist_id',
                    `added_by` = '$pharmacist_name'
                  WHERE `id` = '$id'";

    // Execute the query and check if it was successful
    if ($conn->query($sql_update) === TRUE) {
        // Redirect to pharmacy home with a success message
        header('Location: Pharmacy-home.php?status=success');
        exit();
    } else {
        // Handle query failure and provide an error message
        echo "<script>
                alert('Error updating record: " . $conn->error . "');
                window.location.href = 'Pharmacy-home.php?status=error';
              </script>";
        exit();
    }
} else {
    // Redirect to pharmacy home if required fields are missing
    echo "<script>
            alert('Some required fields are missing.');
            window.location.href = 'Pharmacy-home.php?status=error';
          </script>";
    exit();
}
