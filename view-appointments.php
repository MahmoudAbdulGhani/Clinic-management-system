<?php
session_start();
if ($_SESSION['role'] != 1 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';
$sql = "SELECT appointment.*, patient_name FROM appointment INNER JOIN patient on patient.UserID = PatientID";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #80deea);
            padding: 20px;
        }

        .header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logo-container {
            margin-right: 20px;
        }

        .logo-container img {
            max-width: 100px;
            border-radius: 50%;
        }

        .table-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .table th {
            background-color: #f0f0f0;
        }

        .cancelled-reason {
            background-color: #ffe6e6;
            /* Light red for cancelled reasons */
            padding: 8px;
            border-radius: 5px;
            margin-top: 5px;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo-container">
            <a href="../Admin/admin-home.php"><img src="../images/logo.jpeg" alt="Clinic Logo"></a>
        </div>
        <h1>View All Appointments</h1>
    </div>
    <?php
    if ($result->num_rows > 0) {
        echo "<div class='table-container'>
            <table class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>Appointment ID</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Appointment Type</th>
                        <th>Department/Speciality</th>
                        <th>Appointment Date</th>
                        <th>Appointment Time</th>
                        <th>Status</th>
                        <th>Reason for Cancellation</th>
                    </tr>
                </thead>
                <tbody>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                        <td>" . $row['AppointmentID'] . "</td>";
            echo "<td>" . $row['patient_name'] . "</td>";
            echo "<td>" . $row['doctor_name'] . "</td>
                        <td>" . $row['type'] . "</td>
                        <td>" . $row['department'] . "</td>
                        <td>" . $row['appointment_date'] . "</td>
                        <td>" . $row['appointment_startTime'] . "</td>
                        <td>" . $row['Status'] . "</td>
                        <td>" . $row['cancelation_reason'] . "</td>
                    </tr>";
        }
        echo "</tbody>
            </table>";
    } else {
        echo "<h3>No Appointments Found</h3>";
    }

    ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>