<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = "SELECT FullName, ID, Email FROM user WHERE ID = '$id'";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Delete Receptionist</title>
        <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
        <style>
            body {
                font-family: sans-serif;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                background: linear-gradient(135deg, #e0f7fa, #80deea);
                /* Gradient background */
            }

            .delete-container {
                background-color: white;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
                text-align: center;
                width: 450px;
                max-width: 95%;
            }

            .delete-container h2 {
                color: #dc3545;
                margin-bottom: 25px;
                font-size: 1.8em;
            }

            .delete-container p {
                margin-bottom: 20px;
                font-size: 1.1em;
                line-height: 1.6;
            }

            .delete-container strong {
                font-weight: 600;
            }

            .delete-container .delete-details {
                margin-bottom: 25px;
                border: 1px solid #e0e0e0;
                padding: 15px;
                border-radius: 8px;
                background-color: #f9f9f9;
            }

            .delete-container .delete-buttons {
                display: flex;
                justify-content: center;
                gap: 15px;
            }

            .delete-container .delete-button {
                background-color: #dc3545;
                color: white;
                padding: 12px 25px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 1em;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                text-decoration: none;
                /* Removed underline */

            }

            .delete-container .cancel-button {
                background-color: #e0e0e0;
                color: #333;
                padding: 12px 25px;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 1em;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
                text-decoration: none;
                /* Removed underline */
            }
        </style>
    </head>

    <body>
        <div class="delete-container">
            <h2>Delete Receptionist</h2>
            <p>Are you sure you want to delete the following receptionist?</p>
            <div class="delete-details">
                <p><strong>Name:</strong> <?= $row['FullName'] ?></p>
                <p><strong>ID:</strong> <?= $row['ID'] ?></p>
                <p><strong>Email:</strong> <?= $row['Email'] ?></p>
            </div>
            <div class="delete-buttons">
                <a href="deleteReceptionestconf.php?id=<?= $id ?>" class=" delete-button">Delete</a>
                <a href="manage-Receptionest.php" class="cancel-button">Cancel</a>
            </div>
        </div>
    </body>

    </html>
    <?php
}