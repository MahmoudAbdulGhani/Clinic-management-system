<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 4) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';
$id = $_GET['id'];
$sql = "SELECT * FROM medicines WHERE id = '$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Medicine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #80deea);
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        .header-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .back-button {
            background: none;
            border: none;
            cursor: pointer;
            margin-right: 15px;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            display: block;
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-group textarea {
            resize: vertical;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header-container">
            <h2>Edit Medicine</h2>
        </div>

        <form method="post" action="update-medicine.php?id=<?= $id ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?= $row['name'] ?>" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="3"><?= $row['description'] ?></textarea>
            </div>

            <div class="form-group">
                <label for="dose">Medication Dose:</label>
                <input type="text" id="dose" name="dose" value="<?= $row['dose'] ?>">
            </div>

            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" value="<?= $row['stock'] ?>" required>
            </div>

            <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="date" id="expiry_date" name="expiry_date" value="<?= $row['expiry_date'] ?>" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-secondary"
                    onclick="window.location.href='Pharmacy-home.php'">Cancel</button>


            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>