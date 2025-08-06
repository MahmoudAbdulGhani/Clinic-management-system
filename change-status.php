<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 3) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_status = $_POST['status'];
        $user_id = $_SESSION['id'];
        $reason = $_POST['reason'];
        $sql_update = "UPDATE medical_records SET status = '$new_status', recep_id = '$user_id', reason = '$reason' WHERE id = $id";
        if ($conn->query($sql_update)) {
            header("Location: view-patient-records.php");
            exit();
        } else {
            echo "Error updating status: " . $conn->error;
        }
    }

    $sql_fetch = "SELECT * FROM medical_records WHERE id = '$id'";
    $result = $conn->query($sql_fetch);
    if ($result->num_rows === 1) {
        $record = $result->fetch_assoc();
    } else {
        echo "Record not found.";
        exit();
    }
} else {
    echo "Invalid request.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Status</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .card {
            max-width: 500px;
            margin: 80px auto;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #0d6efd;
            color: white;
            font-weight: bold;
        }

        .form-select {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-header text-center">
            Edit Medical Record Status
        </div>
        <div class="card-body">
            <form method="POST">
                <div class="mb-3">
                    <label for="status" class="form-label">Select New Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="Completed" <?php if ($record['status'] == 'Completed')
                            echo 'selected'; ?>>
                            Completed</option>
                        <option value="Pending" <?php if ($record['status'] == 'Pending')
                            echo 'selected'; ?>>Pending
                        </option>
                        <option value="Incompleted" <?php if ($record['status'] == 'Incompleted')
                            echo 'selected'; ?>>
                            Incompleted</option>
                    </select>
                    <label for="reason">Reason For Incompleted</label>
                    <input type="text" value="<?= $record['reason'] ?>" name="reason" id="reason">
                </div>
                <div class="d-flex justify-content-between">
                    <a href="view-patient-records.php" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>