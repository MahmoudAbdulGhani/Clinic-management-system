<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 2) {
    header('Location:../login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Home - View Schedule</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #80deea);
            min-height: 100vh;
        }

        .sidebar {
            background-color: #ffffff;
            border-right: 1px solid #e0e0e0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .logo-container img {
            max-width: 120px;
            border-radius: 50%;
        }

        .nav-link {
            padding: 1rem 1.5rem;
            text-decoration: none;
            color: #333;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
            margin-bottom: 0.75rem;
        }

        .nav-link.active,
        .nav-link:hover {
            background-color: #007bff;
            color: white;
        }

        .nav-link i {
            margin-right: 1rem;
        }

        .content {
            flex-grow: 1;
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1.5rem;
        }

        .schedule-table th,
        .schedule-table td {
            padding: 1.25rem 1.5rem;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .schedule-table th {
            background-color: #f0f0f0;
            font-weight: 600;
        }

        .schedule-table tr:hover {
            background-color: #f9f9f9;
        }

        .no-schedule {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            color: #f44336;
            padding: 3rem 1.5rem;
            background-color: #ffebee;
            border: 2px dashed #f44336;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 2s ease-in-out;
        }

        .unavailable {
            border: 2px dashed #f44336 !important;
            background-color: #ffebee !important;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #e0e0e0;
            }

            .content {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <div class="sidebar col-md-3">
            <div class="p-3">
                <div class="logo-container mb-3">
                    <a href="Doctor-home.php"><img src="../images/logo.jpeg" alt="Clinic Logo"></a>
                </div>
                <a href="Doctor-home.php" class="nav-link active mb-2">
                    <i class="fas fa-calendar-alt"></i> View Schedule
                </a>
                <a href="viewPatient-records.php" class="nav-link">
                    <i class="fas fa-notes-medical"></i> View Patient Records
                </a>

                <a href="change-password.php" class="nav-link">
                    <i class="fas fa-key"></i> Change Password
                </a>

                <a href="../logout.php" class="nav-link text-danger mt-4">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <div class="content col-md-9">
            <h2 class="mb-4 text-center">Welcome Doctor <?= $_SESSION['name'] ?></h2>
            <h2 class="mb-4 text-center">This Is Your Schedule</h2>
            <?php
            require_once '../connection.php';
            $id = $_SESSION['id'];
            $sql_select = "SELECT * FROM schedule WHERE DoctorID = '$id'";
            $result = $conn->query($sql_select);
            if ($result->num_rows > 0) {
                echo "<div class='table-responsive'>
                <table class='schedule-table'>
                    <thead>
                        <tr>
                            <th>Day</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>";
                while ($row = $result->fetch_assoc()) {
                    // Check if the status is Unavailable and set start/end time to '-----'
                    $startTime = ($row['status'] == 'Unavailable') ? '-----' : $row['StartTime'];
                    $endTime = ($row['status'] == 'Unavailable') ? '-----' : $row['EndTime'];
                    $status_class = ($row['status'] == 'Unavailable') ? 'unavailable' : '';

                    echo "
                    <tbody>
                        <tr class='$status_class'>
                            <td>" . $row['DayOfWeek'] . "</td>
                            <td>" . $startTime . "</td>
                            <td>" . $endTime . "</td>
                            <td>" . $row['status'] . "</td>
                        </tr>
                    </tbody>";
                }
                echo "</table>
                </div>";
            } else {
                echo "<div class='no-schedule'>
                        <i class='fas fa-exclamation-triangle'></i> You don't have a schedule. Please go to the receptionist to get one.
                    </div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>