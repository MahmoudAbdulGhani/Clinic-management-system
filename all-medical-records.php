<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 2) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid Patient ID'); window.location.href='viewPatient-records.php';</script>";
    exit();
}
$PatientID = $_GET['id'];
$search_date = isset($_POST['search_date']) ? $_POST['search_date'] : '';

// Modify the SQL query based on the search input
$sql = "SELECT diagnosis, prescription, note, Date, id, appointment_id FROM medical_records WHERE patient_id = '$PatientID'";

if ($search_date) {
    $sql .= " AND Date = '$search_date'";  // Filter by the selected date
}

$sql .= " ORDER BY Date DESC";  // Order by date in descending order

$result = $conn->query($sql);
$sql_patient_name = "SELECT patient_name, UserID FROM patient WHERE UserID = '$PatientID'";
$result_patient = $conn->query($sql_patient_name);
$rowPatient = $result_patient->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Medical Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            padding-top: 30px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            padding: 0 15px;
        }

        .card-custom {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #ffffff;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .card-custom:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-custom .card-header {
            font-size: 1.25rem;
            font-weight: bold;
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }

        .card-custom .card-body {
            font-size: 1rem;
            line-height: 1.6;
        }

        .back-button {
            font-size: 1rem;
            padding: 8px 15px;
            background-color: #6c757d;
            border-color: #6c757d;
            text-decoration: none;
            color: white;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
        }

        .back-button:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
            font-size: 1rem;
            padding: 10px 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        h3 {
            color: #343a40;
            font-weight: 600;
        }

        .card-custom p {
            margin-bottom: 10px;
        }

        .card-custom p strong {
            color: #007bff;
        }

        .search-form input {
            max-width: 200px;
        }

        /* Styled delete button */
        .delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .delete-btn:hover {
            background-color: #c82333;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 6px 12px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .edit-btn:hover {
            background-color: #0056b3;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="text-center mb-4">All Medical Records</h3>
        <h3>Patient Name: <?= $rowPatient['patient_name'] ?></h3>

        <!-- Search form -->
        <form method="POST" class="search-form mb-3">
            <label for="search_date">Search by Date: </label>
            <input type="date" name="search_date" id="search_date" value="<?= $search_date ?>"
                class="form-control d-inline-block" />
            <button type="submit" class="btn btn-primary ms-2">Search</button>
        </form>

        <a href="view-patient-details.php?id=<?= $rowPatient['UserID'] ?>" class="back-button mb-3"><i
                class="fas fa-arrow-left me-2"></i>Back</a>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='card-custom'>
                        <p><strong>Date:</strong> " . $row['Date'] . "</p>
                        <p><strong>Diagnosis:</strong> " . $row['diagnosis'] . "</p>
                        <p><strong>Prescription:</strong> " . $row['prescription'] . "</p>
                        <p><strong>Note:</strong> " . $row['note'] . "</p>
                        <a href='delete-record.php?id=" . $row['id'] . "' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this record?\");'>Delete</a>
                        <a href='edit-record.php?id=" . $row['id'] . "&appointment_id=" . $row['appointment_id'] . "' class='edit-btn ms-2'>Edit</a>
                    </div>";
            }
        } else {
            echo "<div class='alert alert-warning'>No medical records found for this patient.</div>";
        }
        ?>
    </div>
</body>

</html>