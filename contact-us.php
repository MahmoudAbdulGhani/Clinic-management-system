<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';
$result = $conn->query("SELECT * FROM contact_us ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Contact Messages - Receptionist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background-color: #f4f6f9;
            overflow-x: hidden;
        }

        .sidebar {
            width: 250px;
            background-color: #2c3e50;
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1030;
            transition: transform 0.3s ease-in-out;
        }

        .sidebar .nav-link {
            color: white;
            padding: 1rem;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: #1abc9c;
            color: white;
        }

        .sidebar-header {
            padding: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
            background-color: #34495e;
        }

        .sidebar-header img {
            height: 40px;
            border-radius: 50%;
        }

        .content {
            margin-left: 250px;
            padding: 2rem;
        }

        @media (max-width: 1000px) {
            .sidebar {
                transform: translateX(-100%);
                position: absolute;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .content {
                margin-left: 0;
                padding-top: 5rem;
            }

            #hamburger {
                display: block;
                position: fixed;
                top: 15px;
                left: 15px;
                z-index: 1050;
                background-color: #1abc9c;
                border: none;
                padding: 10px;
                border-radius: 5px;
                color: white;
            }
        }
    </style>
</head>

<body>

    <button id="hamburger"><i class="fas fa-bars"></i></button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="receptionest-home.php" class="d-flex align-items-center gap-2 text-white text-decoration-none">
                <img src="../images/logo.jpeg" alt="Logo" class="rounded-circle" height="45">
                <span class="fw-bold fs-5">Medicare Hub</span>
            </a>
        </div>
        <nav class="nav flex-column">
            <a class="nav-link" href="receptionest-home.php"><i class="fas fa-home me-2"></i> Home</a>
            <a class="nav-link" href="manageUsers.php"><i class="fas fa-users me-2"></i> Manage Users</a>
            <a class="nav-link" href="appointments.php"><i class="fas fa-calendar-alt me-2"></i> Appointments</a>
            <a class="nav-link" href="patient-Queries.php"><i class="fas fa-question-circle me-2"></i> Patient
                Queries</a>
            <a class="nav-link active" href="contact-us.php"><i class="fas fa-envelope me-2"></i> Contact Us</a>
            <a class="nav-link" href="pharmacy-Request.php"><i class="fas fa-prescription me-2"></i> Pharmacy
                Requests</a>
            <a class="nav-link" href="change-Password.php"><i class="fas fa-lock me-2"></i> Change Password</a>
            <a class="nav-link text-danger" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </nav>
    </div>

    <div class="content">
        <div class="container-fluid">
            <h2 class="mb-4">📨 Contact Messages</h2>
            <div class="table-responsive">
                <table class="table table-bordered table-hover bg-white shadow-sm">
                    <thead class="table-dark">
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Reply</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['name'] ?></td>
                                <td><?= $row['email'] ?></td>
                                <td><?= $row['message'] ?></td>
                                <td>
                                    <?php if (!empty($row['reply'])): ?>
                                        <div class="text-success">
                                            <strong>Sent:</strong><br><?= $row['reply'] ?>
                                        </div>
                                    <?php else: ?>
                                        <form method="POST" action="send_reply.php">
                                            <input type="hidden" name="id" value="<?= $row['ID'] ?>">
                                            <div class="mb-2">
                                                <textarea name="reply" class="form-control" rows="3"
                                                    placeholder="Type your reply..." required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Send Reply</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script>
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.getElementById('hamburger');

        function toggleSidebar() {
            sidebar.classList.toggle('show');
        }

        hamburger.addEventListener('click', toggleSidebar);

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1000) {
                sidebar.classList.remove('show');
            }
        });
    </script>

</body>

</html>