<?php
session_start();
if ($_SESSION['role'] != 1 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {

    if (!isset($_GET['id'])) {
        header('Location:manage-Receptionest.php');
        exit();
    }

    $id = $_GET['id'];
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #e0f7fa, #80deea);
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                color: #333;
            }

            .reset-container {
                background-color: rgba(255, 255, 255, 0.9);
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                width: 400px;
                max-width: 90%;
                position: relative;
            }

            .reset-container h2 {
                text-align: center;
                margin-bottom: 30px;
                color: #007bff;
            }

            .form-group {
                margin-bottom: 20px;
                position: relative;
            }

            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
            }

            .form-group input {
                width: 100%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
            }

            .form-group input:focus {
                outline: none;
                border-color: #007bff;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            .btn-reset {
                background-color: #007bff;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 100%;
                font-size: 16px;
            }

            .btn-reset:hover {
                background-color: #0056b3;
            }

            .error-message {
                color: #dc3545;
                margin-top: 10px;
                text-align: center;
            }

            .back-icon {
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 20px;
                color: #007bff;
                cursor: pointer;
            }

            .toggle-password {
                position: absolute;
                top: 60%;
                right: 15px;
                cursor: pointer;
                color: #007bff;
            }
        </style>
    </head>

    <body>
        <div class="reset-container">
            <a href="manage-Receptionest.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <h2>Reset Password</h2>
            <form id="resetForm" method="post" action="resetReceptionest-passwordconf.php?id=<?= $id ?>">
                <div class="form-group">
                    <label for="newPassword">New Password:</label>
                    <input type="password" id="newPassword" name="newPassword" required minlength="8">
                    <i class="fas fa-eye toggle-password" toggle="#newPassword"></i>
                </div>
                <div class="form-group">
                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" id="confirmPassword" name="confirmPassword" required minlength="8">
                    <i class="fas fa-eye toggle-password" toggle="#confirmPassword"></i>
                </div>
                <div id="errorMessage" class="error-message"></div>
                <button type="submit" class="btn-reset">Reset Password</button>
            </form>
        </div>

        <script>
            document.getElementById('resetForm').addEventListener('submit', function (event) {
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;
                const errorMessage = document.getElementById('errorMessage');

                if (newPassword !== confirmPassword) {
                    event.preventDefault(); // stop submission
                    errorMessage.textContent = "Passwords do not match.";
                }
            });

            // Password toggle functionality
            document.querySelectorAll('.toggle-password').forEach(icon => {
                icon.addEventListener('click', function () {
                    const input = document.querySelector(this.getAttribute('toggle'));
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    this.classList.toggle('fa-eye');
                    this.classList.toggle('fa-eye-slash');
                });
            });
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <?php
}
?>