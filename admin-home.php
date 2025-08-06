<?php
session_start();
if ($_SESSION['role'] != 1 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
        <style>
            body {
                background-image: url('../images/adminback.webp');
                background-size: cover;
                background-repeat: no-repeat;
                background-position: center;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                color: #fff;
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                margin: 0;
            }

            .header {
                background-color: rgba(0, 0, 0, 0.6);
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 20px;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .logo-container {
                margin-right: 15px;
            }

            .logo-container img {
                max-width: 90px;
                border-radius: 50%;
            }

            .header-text {
                color: #fff;
                font-size: 1.8rem;
                margin-left: 20px;
                margin-right: 20px;
                text-transform: capitalize;
            }

            .dashboard-container {
                padding: 20px;
                flex: 1;
                display: flex;
                justify-content: center;
                align-items: center;
                flex-wrap: wrap;
            }

            .dashboard-item {
                background-color: rgba(0, 0, 0, 0.7);
                padding: 25px;
                border-radius: 10px;
                text-align: center;
                margin: 15px;
                width: 280px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
                transition: transform 0.3s ease;
            }

            .dashboard-item:hover {
                transform: translateY(-8px);
            }

            .dashboard-item h3 {
                color: #00bcd4;
                margin-bottom: 15px;
                font-size: 1.3rem;
            }

            .dashboard-item p {
                font-size: 15px;
                line-height: 1.6;
            }

            .footer {
                text-align: center;
                background-color: rgba(0, 0, 0, 0.6);
                border-top: 1px solid rgba(255, 255, 255, 0.1);
            }

            .btn-primary {
                background-color: #00bcd4;
                border-color: #00bcd4;
            }

            .btn-primary:hover {
                background-color: #0097a7;
                border-color: #0097a7;
            }

            .btn-danger {
                background-color: #dc3545;
                border-color: #dc3545;
            }

            .btn-danger:hover {
                background-color: #c82333;
                border-color: #bd2130;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <div class="logo-container">
                <a href="admin-home.php"><img src="../images/logo.jpeg" alt="Clinic Logo"></a>
            </div>
            <h1 class="header-text">Admin Dashboard</h1>
            <h1 class="header-text">Welcome <?= $_SESSION['name'] ?>!</h1>
            <div>
                <a href="../logout.php" class="btn btn-danger">Logout</a>
            </div>
        </div>

        <div class="dashboard-container">
            <div class="dashboard-item">
                <h3>Manage Receptionists</h3>
                <p>Add, edit, or remove receptionists.</p>
                <a href="manage-Receptionest.php" class="btn btn-primary mt-3">Go to Manage</a>
            </div>
            <div class="dashboard-item">
                <h3>View All Appointments</h3>
                <p>View all scheduled appointments.</p>
                <a href="view-appointments.php" class="btn btn-primary mt-3">View Appointments</a>
            </div>
            <div class="dashboard-item">
                <h3>View System Logs</h3>
                <p>View system logs and activity.</p>
                <a href="system-logs.php" class="btn btn-primary mt-3">View Logs</a>
            </div>
            <div class="dashboard-item">
                <h3>Change Password</h3>
                <p>Change Your Password</p>
                <a href="change-admin-password.php" class="btn btn-primary mt-3">Change Password</a>
            </div>
        </div>

        <div class="footer">
            <p>&copy; <?php echo date("Y");?> Clinic Admin Dashboard</p>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
<?php
}
?>