<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 4) {
    header('Location../login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Medicine</title>
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
            /* Limit container width */
            margin: 0 auto;
            /* Center container */
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
            /* Make labels block-level */
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group textarea {
            width: calc(100% - 22px);
            /* Adjust width for padding and border */
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            /* Include padding and border in width */
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
            <button class="back-button"><a href="Pharmacy-home.php"><i class="fas fa-arrow-left"></i></a></button>
            <h2>Add New Medicine</h2>
        </div>

        <form method="post" action="add-medicine1.php">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="3"></textarea>
            </div>

            <div class="form-group">
                <label for="dose">Medication Dose:</label>
                <input type="text" id="dose" name="dose">
            </div>

            <div class="form-group">
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required>
            </div>
            <div class="form-group">
                <label for="date">Expiry Date:</label>
                <input type="date" id="date" name="expiry_date" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Medicine</button>
                <button type="reset" class="btn btn-secondary">Clear</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>