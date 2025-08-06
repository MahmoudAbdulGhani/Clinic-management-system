<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 2) {
    header('Location: ../login.html');
    exit();
}

require_once '../connection.php';

if (!isset($_GET['id']) || !isset($_GET['appointment_id'])) {
    echo "<script>
        alert('Invalid patient or appointment ID!');
        window.location.href = 'viewPatient-records.php';
    </script>";
    exit();
}

$patient_id = $_GET['id'];
$appointment_id = $_GET['appointment_id'];
$doctor_id = $_SESSION['id'];
$doctor_name = $_SESSION['name'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['diagnosis']) && !empty($_POST['prescription']) && !empty($_POST['Date']) && !empty($_POST['time'])) {
        $diagnosis = $_POST['diagnosis'];
        $note = $_POST['note'];
        $prescription = $_POST['prescription'];
        $date = $_POST['Date'];
        $time = $_POST['time'];
        $quantity = $_POST['quantity'];
        $sql_insert = "INSERT INTO `medical_records` 
(`patient_id`, `doctor_id`, `doctor_name`, `appointment_id`, `prescription`, `quantity`, `diagnosis`, `note`, `Date`, `created_at`, `status`) 
VALUES 
('$patient_id', '$doctor_id', '$doctor_name', '$appointment_id', '$prescription', '$quantity', '$diagnosis', '$note', '$date', NOW(), 'Pending')";

        if ($conn->query($sql_insert)) {
            $sql_update_appointment_status = "UPDATE `appointment` 
                                              SET `Status` = 'Completed' 
                                              WHERE `AppointmentID` = '$appointment_id'";
            $conn->query($sql_update_appointment_status);

            header("Location: view-patient-details.php?id=$patient_id");
            exit();
        } else {
            echo "<script>
                alert('Failed to add medical record.');
                window.location.href = 'view-patient-details.php?id=$patient_id';
            </script>";
        }
    } else {
        echo "<script>
            alert('All required fields must be filled.');
            window.location.href = 'view-patient-details.php?id=$patient_id';
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Medical Report</title>
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <a href="javascript:history.back()" class="btn btn-link text-decoration-none mb-3">
                            <i class="bi bi-arrow-left"></i> Back
                        </a>
                        <h3 class="card-title mb-4 text-center">Add Medical Report</h3>
                        <form method="post">
                            <div class="mb-3">
                                <label for="diagnosis" class="form-label">Diagnosis</label>
                                <input type="text" class="form-control" name="diagnosis" id="diagnosis" required>
                            </div>
                            <div class="mb-3">
                                <label for="prescription" class="form-label">Prescription</label>
                                <input type="text" class="form-control" name="prescription" id="prescription" required>
                            </div>
                            <div class="mb-3">
                                <label for="quantity" class="form-label">Quantity</label>
                                <input type="number" class="form-control" name="quantity" id="quantity" required>
                            </div>
                            <div class="mb-3">
                                <label for="note" class="form-label">Additional Note</label>
                                <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                            </div>
                            <input type="hidden" name="Date" value="<?= date("Y-m-d") ?>">
                            <input type="hidden" name="time" value="<?= date('H:i') ?>">
                            <button type="submit" class="btn btn-primary w-100">Add Report</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>