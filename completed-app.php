<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';

// Handle search

$searchQuery = '';
if (isset($_POST['search']) && !empty($_POST['search_query'])) {
    $searchQuery = $_POST['search_query'];
    $sql = "SELECT appointment.*, doctor.Specialization, doctor.doctor_name, patient_name FROM appointment
            INNER JOIN doctor ON appointment.DoctorID = doctor.UserID
            INNER JOIN patient ON appointment.PatientID = patient.UserID
            WHERE appointment.Status = 'Completed' AND appointment_date LIKE '%$searchQuery%'";

} else {
    $sql = "SELECT appointment.*, doctor.Specialization, doctor.doctor_name, patient_name
            FROM appointment
            INNER JOIN doctor ON appointment.DoctorID = doctor.UserID
            INNER JOIN patient ON appointment.PatientID = patient.UserID
            WHERE appointment.Status = 'Completed'";

}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Appointment Offer - Medicare Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #a5f3ff);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
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
            border-radius: 0;
            transition: background-color 0.3s ease;
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
            position: relative;
        }

        .sidebar-header img {
            height: 45px;
            border-radius: 50%;
        }

        .sidebar-header a {
            transition: background-color 0.3s ease, transform 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .sidebar-header a:hover {
            background-color: #1abc9c;
            transform: scale(1.02);
            text-decoration: none;
            color: white;
        }

        /* Responsive Styles */
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

            .sidebar.show+.content #hamburger {
                display: none;
            }

            .close-btn {
                position: absolute;
                top: 10px;
                right: 10px;
                background: transparent;
                border: none;
                color: white;
                font-size: 20px;
                cursor: pointer;
            }
        }

        #hamburger {
            display: none;
        }

        .content {
            margin-left: 250px;
            padding: 2rem;
            transition: margin-left 0.3s ease-in-out;
        }

        .table-responsive {
            background: white;
            border-radius: 0.75rem;
            padding: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .table {
            width: 100%;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 0.75rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
            padding: 1rem;
        }

        .table th {
            background-color: #1abc9c;
            color: white;
            font-weight: bold;
        }

        .table td {
            background-color: #f9f9f9;
        }

        .table td a {
            color: #1abc9c;
            text-decoration: none;
            font-size: 1.2rem;
        }

        .table td a:hover {
            color: #16a085;
        }

        .table .fa-pencil-alt,
        .table .fa-trash-alt {
            font-size: 1.2rem;
        }

        .table tbody tr:nth-child(odd) {
            background-color: #f1f1f1;
        }

        .table tbody tr:hover {
            background-color: #e0f7fa;
        }

        .no-appointments {
            margin-top: 50px;
            opacity: 0;
            animation: fadeIn 1s forwards;
        }

        .no-appointments-message {
            background-color: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
        }

        .no-appointments h3 {
            font-size: 1.8rem;
            color: #333;
            font-weight: bold;
        }

        .no-appointments p {
            color: #555;
        }

        .no-appointments .btn {
            background-color: #1abc9c;
            border: none;
            color: white;
            font-size: 1.1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .no-appointments .btn:hover {
            background-color: #16a085;
        }

        .add-offer-btn {
            background-color: #1abc9c;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .add-offer-btn:hover {
            background-color: #16a085;
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
</head>

<body>

    <button id="hamburger"><i class="fas fa-bars"></i></button>

    <div class="sidebar" id="sidebar">
        <div class="sidebar-header w-100 d-flex justify-content-between align-items-center">
            <a href="receptionest-home.php" class="d-flex align-items-center gap-2 text-white text-decoration-none">
                <img src="../images/logo.jpeg" alt="Logo" class="rounded-circle" height="45">
                <span class="fw-bold fs-5">Medicare Hub</span>
            </a>
            <button class="close-btn d-md-none" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link" href="receptionest-home.php"><i class="fas fa-home me-2"></i> Home</a>
            <a class="nav-link" href="manageUsers.php"><i class="fas fa-users me-2"></i> Manage Users</a>
            <a class="nav-link active" href="appointments.php"><i class="fas fa-calendar-alt me-2"></i> Appointments</a>
            <a class="nav-link" href="patient-Queries.php"><i class="fas fa-question-circle me-2"></i> Patient
                Queries</a>
            <a class="nav-link" href="contact-us.php"><i class="fas fa-envelope me-2"></i> Contact Us</a>
            <a class="nav-link" href="pharmacy-Request.php"><i class="fas fa-prescription me-2"></i> Pharmacy
                Requests</a>
            <a class="nav-link" href="change-Password.php"><i class="fas fa-lock me-2"></i> Change Password</a>
            <a class="nav-link text-danger" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </nav>
    </div>

    <div class="content" id="content">
        <div class="container-fluid">
            <h2 class="text-center mb-4">Appointment</h2>
            <div class="row mb-3">
                <div class="col-md-6">
                    <form method="post" class="d-flex">
                        <input type="date" name="search_query" class="fo rm-control me-2" placeholder="Search by Date"
                            value="<?php echo isset($_POST['search_query']) ? $_POST['search_query'] : '' ?>">
                        <button name="search" type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <a href="appointments.php" class="btn btn-success add-offer-btn"><i class="fas fa-eye"></i> View

                        Appointments</a>
                </div>
            </div>

            <?php if ($result->num_rows > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Patient Name</th>
                                <th>Doctor Name</th>
                                <th>Department</th>
                                <th>Date</th>
                                <th>Day Of Week</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $row['AppointmentID'] ?></td>
                                    <td><?= $row['patient_name'] ?></td>
                                    <td><?= $row['doctor_name'] ?></td>
                                    <td><?= $row['Specialization'] ?></td>
                                    <td><?= $row['appointment_date'] ?></td>
                                    <td><?= $row['DayOfWeek'] ?></td>
                                    <td><?= $row['appointment_startTime'] ?></td>
                                    <td><?= $row['appointment_endTime'] ?></td>
                                    <td><?= $row['Status'] ?></td>
                                    <td><a href="delete-app.php?id=<?= $row['AppointmentID'] ?>"
                                            onclick="return confirm('Are you sure you want to delete this appointment?')"><i
                                                class="fas fa-trash-alt"></i></a></td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="no-appointments text-center">
                    <div class="no-appointments-message">
                        <h3>No Completed Appointments Found</h3>
                        <p>It looks like there are no Completed appointments at the moment.</p>

                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        const sidebar = document.getElementById('sidebar');
        const hamburger = document.getElementById('hamburger');
        const closeBtn = document.querySelector('.close-btn');

        hamburger.addEventListener('click', function () {
            sidebar.classList.add('show');
        });

        closeBtn?.addEventListener('click', function () {
            sidebar.classList.remove('show');
        });
    </script>
</body>

</html>