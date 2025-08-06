<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Doctor - Medicare Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }

        .card h2 {
            color: #e74c3c;
            margin-bottom: 20px;
            font-weight: bold;
        }

        .btn-danger {
            background-color: #e74c3c;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-secondary {
            background-color: #95a5a6;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #7f8c8d;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Confirm Doctor Deletion</h2>
        <?php
        require_once '../connection.php';
        $id = $_GET['id'];
        $sql_select = "SELECT FullName FROM user WHERE ID = '$id'";
        $result = $conn->query($sql_select);
        $row = $result->fetch_assoc();
        ?>
        <p>Are you sure you want to delete Patient <?= $row['FullName'] ?>? This action cannot be undone.</p>

        <div class="d-flex justify-content-center gap-3 mt-4">
            <form method="post" action="deletePatientconf.php?id=<?= $_GET['id'] ?>">
                <button type="submit" class="btn btn-danger px-4">Delete</button>
            </form>
            <a href="managePatient.php" class="btn btn-secondary px-4">Cancel</a>
        </div>
    </div>

</body>

</html>