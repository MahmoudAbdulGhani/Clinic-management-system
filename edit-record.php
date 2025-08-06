<?php
session_start();
if ($_SESSION['role'] != 2 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}
if (isset($_GET['id']) && isset($_GET['appointment_id'])) {
    $id = $_GET['id'];
    $appointment_id = $_GET['appointment_id'];
}
require_once '../connection.php';
$sql_Select = "SELECT diagnosis, patient_id,prescription, note FROM medical_records WHERE id = '$id' AND appointment_id = '$appointment_id'";
$result = $conn->query($sql_Select);
$row = $result->fetch_assoc();
$patient_id = $row['patient_id'];
if (isset($_POST['diagnosis']) && !empty($_POST['diagnosis']) && isset($_POST['prescription']) && !empty($_POST['prescription'])) {
    $diagnosis = $_POST['diagnosis'];
    $prescription = $_POST['prescription'];
    $note = $_POST['note'];
    $sql_update = "UPDATE `medical_records` SET `prescription`='$prescription',`diagnosis`='$diagnosis',`note`='$note' WHERE id = '$id' AND appointment_id = '$appointment_id'";
    if ($conn->query($sql_update) == TRUE) {
        echo "<script>
        window.alert('Record Updated Successfully');
        window.location.href='all-medical-records.php?id=$patient_id';
        </script>";
    } else {
        echo "<script>
        window.alert('Failed To Update');
        window.location.href='all-medical-records.php?id=$patient_id';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Record</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            background-color: #f4f6f9;
            padding-top: 50px;
            font-family: 'Segoe UI', sans-serif;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-title {
            font-weight: 600;
            margin-bottom: 25px;
            color: #343a40;
        }

        .btn-primary {
            width: 100%;
        }

        textarea {
            resize: none;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h3 class="form-title text-center">Edit Medical Record</h3>
        <form action="" method="post">
            <div class="mb-3">
                <label for="diagnosis" class="form-label">Diagnosis</label>
                <input type="text" name="diagnosis" id="diagnosis" value="<?= $row['diagnosis'] ?>" class="form-control"
                    required>
            </div>

            <div class="mb-3">
                <label for="prescription" class="form-label">Prescribed Medicine</label>
                <input type="text" value="<?= $row['prescription'] ?>" name="prescription" id="prescription"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea name="note" id="note" rows="4" class="form-control"><?= $row['note'] ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Record</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>