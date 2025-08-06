<?php
session_start();
if ($_SESSION['role'] != 4 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';

if (
    isset($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password']) &&
    !empty($_POST['current_password']) &&
    !empty($_POST['new_password']) &&
    !empty($_POST['confirm_password'])
) {
    $userID = $_SESSION['id'];
    $current_password = md5($_POST['current_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    $sql_select_password = "SELECT Password FROM user WHERE ID = '$userID'";
    $result = $conn->query($sql_select_password);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['Password'] !== $current_password) {
            echo "<script>
                alert('Current password is incorrect!');
                window.location.href='change-password.php';
            </script>";
        } elseif ($current_password === $new_password) {
            echo "<script>
                alert('New password must not be the same as current password!');
                window.location.href='change-password.php';
            </script>";
        } elseif ($new_password !== $confirm_password) {
            echo "<script>
                alert('New password and confirm password do not match!');
                window.location.href='change-password.php';
            </script>";
        } else {
            $sql_update = "UPDATE user SET Password = '$new_password' WHERE ID = '$userID'";
            if ($conn->query($sql_update) === TRUE) {
                $name = $_SESSION['name'];
                $ip_address = $_SERVER['REMOTE_ADDR'];
                $timestamp = date('Y-m-d H:i:s');
                $sql_insert_systemlog = "INSERT INTO systemlog(`Timestamp`, `UserID`, `Action`, `IPAddress`) 
                VALUES ('$timestamp','$userID','Pharmacist $name Changed His Password','$ip_address')";
                $conn->query($sql_insert_systemlog);
                echo "<script>
                    alert('Password changed successfully!');
                    window.location.href='change-password.php';
                </script>";
            } else {
                echo "<script>
                    alert('Failed to change password!');
                    window.location.href='change-password.php';
                </script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Pharmacy - Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            background: linear-gradient(to right, #e0f7fa, #80deea);
            min-height: 100vh;
            display: flex;
        }

        .sidebar {
            width: 250px;
            background: #fff;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }

        .sidebar .logo-container img {
            width: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .nav-link {
            margin-bottom: 10px;
            color: #333;
            display: flex;
            align-items: center;
        }

        .nav-link.active,
        .nav-link:hover {
            background: #007bff;
            color: #fff;
            border-radius: 5px;
        }

        .nav-link i {
            margin-right: 10px;
        }

        .content {
            flex: 1;
            padding: 40px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column p-3 shadow bg-white" style="width: 250px; height: 100vh;">
        <!-- Logo -->
        <div class="text-center mb-4">
            <a href="pharmacy-home.php">
                <img src="../images/logo.jpeg" alt="Logo" class="img-fluid rounded-circle" style="width: 100px;">
            </a>
        </div>

        <!-- Navigation -->
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="pharmacy-home.php" class="nav-link text-dark">
                    <i class="fas fa-pills me-2"></i> View Medicine
                </a>
            </li>
            <li>
                <a href="view-patient-medicine.php" class="nav-link text-dark">
                    <i class="fas fa-user-md me-2"></i> View Patient Medicine
                </a>
            </li>
            <li>
                <a href="change-password.php" class="nav-link active bg-primary text-white">
                    <i class="fas fa-key me-2"></i> Change Password
                </a>
            </li>
            <li>
                <a href="../logout.php" class="nav-link text-dark">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- Sidebar End -->


    <!-- Main Content -->
    <div class="content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0"><i class="fas fa-key"></i> Change Password</h4>
                        </div>
                        <div class="card-body">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>

                            <?php if (isset($success)): ?>
                                <div class="alert alert-success"><?= $success ?></div>
                            <?php endif; ?>

                            <form method="post">
                                <div class="mb-3 position-relative">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="current_password"
                                            name="current_password" required>
                                        <span class="input-group-text">
                                            <i class="fa fa-eye toggle-password" data-target="current_password"
                                                style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <label for="new_password" class="form-label">New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="new_password"
                                            name="new_password" required>
                                        <span class="input-group-text">
                                            <i class="fa fa-eye toggle-password" data-target="new_password"
                                                style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="mb-3 position-relative">
                                    <label for="confirm_password" class="form-label">Confirm New Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="confirm_password"
                                            name="confirm_password" required>
                                        <span class="input-group-text">
                                            <i class="fa fa-eye toggle-password" data-target="confirm_password"
                                                style="cursor: pointer;"></i>
                                        </span>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-muted text-center">
                            Please choose a strong password for better security.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.toggle-password').forEach(function (eyeIcon) {
            eyeIcon.addEventListener('click', function () {
                const targetInput = document.getElementById(this.dataset.target);
                const isPassword = targetInput.getAttribute('type') === 'password';
                targetInput.setAttribute('type', isPassword ? 'text' : 'password');
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });
        });
    </script>

</body>

</html>