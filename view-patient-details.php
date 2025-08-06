<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 2) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        echo "<script>
        window.alert('Invalid ID!!!');
        window.location.href = 'viewPatient-records.php';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #80deea);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            background-color: #ffffff;
            width: 200px;
            padding: 20px;
            border-right: 1px solid #e0e0e0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
        }

        .sidebar .logo-container {
            margin-bottom: 20px;
        }

        .sidebar .logo-container img {
            max-width: 100px;
            border-radius: 50%;
        }

        .sidebar .nav-link {
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border-radius: 5px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #007bff;
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .content {
            flex-grow: 1;
            padding: 30px;
        }

        .report-container {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .section-title {
            font-weight: 600;
            margin-bottom: 20px;
        }

        .record-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-left: 5px solid #007bff;
            border-radius: 8px;
        }

        button a {
            text-decoration: none;
            color: #fff;
        }

        @media (max-width: 768px) {
            .report-container {
                padding: 20px;
            }
        }

        @media print {
            .btn {
                display: none !important;
            }

            .sidebar {
                display: none !important;
            }

            body {
                background: white;
                display: block;
            }
        }

        .set-history-link {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s ease;
            margin-top: 10px;
        }

        .set-history-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo-container">
            <a href="Doctor-home.php"><img src="../images/logo.jpeg" alt="Clinic Logo"></a>
        </div>
        <a href="viewPatient-records.php" class="nav-link"><i class="fas fa-notes-medical"></i> View Patient Records</a>
        <a href="../logout.php" class="nav-link text-danger mt-4">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
    <?php
    $sql_patientInfo = "SELECT FullName, Gender, DateOfBirth FROM user WHERE ID = '$id'";
    $result = $conn->query($sql_patientInfo);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $dob = new DateTime($row['DateOfBirth']);
        $today = new DateTime();
        $age = $today->diff($dob)->y;
    } else {
        echo "<script>alert('Patient not found.'); window.location.href = 'viewPatient-records.php';</script>";
        exit();
    }
    ?>
    <div class="content">
        <div id="print-section" class="report-container">
            <h2 class="mb-4">Patient Medical Report</h2>
            <div class="mb-4">
                <h5 class="section-title"><i class="fas fa-user me-2 text-primary"></i>Basic Information</h5>
                <p><strong>Patient Name:</strong> <?= $row['FullName'] ?></p>
                <p><strong>Age:</strong> <?= $age ?></p>
                <p><strong>Gender:</strong> <?= $row['Gender'] ?></p>
            </div>
            <?php
            $sql_medicalInfo = "SELECT * FROM medical_records WHERE patient_id = '$id' ORDER BY created_at DESC LIMIT 1";
            $result = $conn->query($sql_medicalInfo);
            $sql_Select_id = "SELECT AppointmentID 
                  FROM appointment 
                  WHERE PatientID = '$id' 
                  ORDER BY appointment_date DESC 
                  LIMIT 1";
            $resultID = $conn->query($sql_Select_id);
            if ($resultID->num_rows > 0) {
                $rowID = $resultID->fetch_assoc();
                $appointment_id = $rowID['AppointmentID'];

            }

            echo "<div class='mb-4'>
                <h5 class='section-title'><i class='fas fa-notes-medical me-2 text-danger'></i>Medical History</h5>";
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                echo "<div class='record-section'>
                <p><strong>Diagnosis:</strong> " . $row['diagnosis'] . "</p>
                <p><strong>Prescribed Medicine:</strong> " . $row['prescription'] . "</p>";
                if (!empty($row['note'])) {
                    echo "<p><strong>Notes:</strong> " . $row['note'] . "</p>";
                } else {
                    echo "<p style='color:red;'><strong>Notes:</strong> No Additional Notes</p>";
                }
                echo "</div>";
            } else {
                echo "<div class='record-section text-center text-muted'>
                <p class='mb-0'><strong>This patient has no medical history on record.</strong></p>
                </div>";
            }
            echo "<div class='d-flex flex-wrap gap-2 mt-3'>
            <a href='add-medical-record.php?id=$id&appointment_id=$appointment_id' class='btn btn-outline-primary'>
        <i class='fas fa-plus me-2'></i>Add Medical Record
      </a>
            <a href='all-medical-records.php?id=$id' class='btn btn-outline-info'>
            <i class='fas fa-folder-open me-2'></i>View All Medical Records
            </a>
            </div>
            </div>";

            $sql_appointmentInfo = "SELECT appointment.AppointmentID, appointment.appointment_date, user.FullName AS doctor_name, appointment.Status 
                FROM appointment
                JOIN doctor ON doctor.UserID = appointment.DoctorID
                JOIN user ON user.ID = doctor.UserID
                WHERE appointment.PatientID = '$id'
                ORDER BY appointment.appointment_date DESC";

            $result = $conn->query($sql_appointmentInfo);

            echo "<div class='mb-3'>
            <h5 class='section-title'><i class='fas fa-calendar-alt me-2 text-success'></i>Last Visit</h5>";
            $appointmentFound = false;
            while ($row = $result->fetch_assoc()) {
                // Check for a completed appointment
                if ($row['Status'] == 'Completed') {
                    echo "<p><strong>Date:</strong> " . $row['appointment_date'] . "</p>
                    <p><strong>Doctor:</strong> " . $row['doctor_name'] . "</p>";
                    $appointmentFound = true;
                    break;  // Show the first completed appointment found
                }
            }

            if (!$appointmentFound) {
                echo "<p class='text-muted mb-0'><strong>No previous visits on record.</strong></p>";
            }
            echo "</div>";
            ?>

            <div class='text-end'>
                <button class='btn btn-primary' onclick='printReport()'>
                    <i class='fas fa-print me-2'></i>Print Report
                </button>
                <a href='viewPatient-records.php' class='btn btn-secondary ms-2'>
                    <i class='fas fa-arrow-left me-2'></i>Back to Records
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function printReport() {
            const printContents = document.getElementById('print-section').innerHTML;
            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Print Report</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
            printWindow.document.write('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">');
            printWindow.document.write('<style>@media print {.btn { display: none; }}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write(printContents);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }
    </script>

</body>

</html>