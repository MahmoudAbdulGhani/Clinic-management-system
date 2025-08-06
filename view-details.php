<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 5) {
    header('Location:../login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Appointment Details</title>
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #1abc9c;
            color: white;
        }

        .alert-warning {
            font-size: 1.2rem;
            animation: fadeIn 1s ease-in, shake 0.3s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shake {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-10px);
            }

            50% {
                transform: translateX(10px);
            }

            75% {
                transform: translateX(-10px);
            }

            100% {
                transform: translateX(0);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card p-4">
            <h2 class="mb-4 text-center">Appointment Medical Record</h2>

            <!-- Back Button -->
            <div class="mb-3">
                <a href="appointment-history.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to
                    Appointments</a>
            </div>

            <?php
            require_once '../connection.php';
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
            }

            $sql_Status = "SELECT Status FROM appointment WHERE AppointmentID = '$id' AND Status = 'Completed'";
            $result_status = $conn->query($sql_Status);

            if ($result_status->num_rows == 0) {
                echo "<div class='alert alert-warning text-center'>You didn't visit the doctor yet.</div>";
            } else {
                $sql_select = "SELECT * FROM medical_records WHERE appointment_id = '$id'";
                $result = $conn->query($sql_select);

                if ($result->num_rows > 0) {
                    echo "
              <div class='table-responsive'>
                <table class='table table-bordered'>
                  <thead>
                    <tr>
                      <th>Diagnosis</th>
                      <th>Prescription</th>
                      <th>Quantity</th>
                      <th>Note</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Reason For Incomplete</th>
                    </tr>
                  </thead>
                  <tbody>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                    <td>{$row['diagnosis']}</td>
                    <td>{$row['prescription']}</td>
                    <td>{$row['quantity']}</td>
                    <td>{$row['note']}</td>
                    <td>{$row['Date']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['reason']}</td>
                  </tr>";
                    }
                    echo "</tbody></table></div>";
                } else {
                    echo "<div class='alert alert-info text-center'>No medical records found for this appointment.</div>";
                }
            }
            ?>
        </div>
    </div>
</body>

</html>