<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 4) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';
$id = $_GET['id'];

// Escape the ID to avoid SQL injection
$id = $conn->real_escape_string($id);

$sql = "SELECT name FROM medicines WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Medicine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #80deea);
            padding: 40px 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        .confirmation-message {
            margin-bottom: 30px;
            font-size: 1.2rem;
            color: #555;
        }

        .confirmation-actions a {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }

        .btn-cancel {
            background-color: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background-color: #5a6268;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Delete Medicine</h2>

        <div class="confirmation-message">
            Are you sure you want to delete <strong><?= $row['name'] ?></strong>?
        </div>

        <div class="confirmation-actions d-flex justify-content-center gap-3">
            <a href="confirm-delete-medicine.php?id=<?= $id ?>" class="btn-delete">Delete</a>
            <a href="Pharmacy-home.php" class="btn-cancel">Cancel</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>