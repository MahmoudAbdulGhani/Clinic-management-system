<?php
session_start();

// Check if the user is logged in and has the appropriate role (4)
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 4) {
    header('Location: ../login.html');
    exit();
}

require_once '../connection.php';

// Get the ID of the record to delete
$medicine_id = $_GET['id'];

// Check if the record exists in the database
$sql_check = "SELECT * FROM patient_medicine WHERE id = '$medicine_id'";
$result_check = $conn->query($sql_check);

if ($result_check->num_rows == 0) {
    // Record doesn't exist
    header('Location: view-patient-medicine.php');
    exit();
}

// If the form is submitted, delete the record
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    // Delete the record from the patient_medicine table
    $sql_delete = "DELETE FROM patient_medicine WHERE id = '$medicine_id'";

    if ($conn->query($sql_delete) === TRUE) {
        // Redirect back to the list with a success message
        header('Location: view-patient-medicine.php?message=success');
        exit();
    } else {
        // If an error occurred, redirect with an error message
        header('Location: view-patient-medicine.php?message=error');
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Deletion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        /* General Styling */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }

        /* Container */
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-top: 50px;
        }

        /* Header */
        h2 {
            color: #dc3545;
            font-size: 24px;
            text-align: center;
        }

        /* Warning Alert */
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
            border-radius: 5px;
            padding: 15px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Information about the Medicine */
        h4 {
            color: #007bff;
            font-size: 20px;
            margin-bottom: 10px;
        }

        /* Medicine Details */
        p {
            font-size: 16px;
            line-height: 1.5;
        }

        /* Buttons */
        .btn {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            width: 45%;
            margin: 10px 2%;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        /* Responsive Adjustments */
        @media (max-width: 576px) {
            .container {
                margin-top: 20px;
                padding: 20px;
            }

            .btn {
                width: 100%;
                margin: 10px 0;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center text-danger">Confirm Deletion</h2>
        <div class="alert alert-warning text-center">
            <strong>Warning!</strong> Are you sure you want to delete this medicine record? This action cannot be
            undone.
        </div>

        <?php
        // Fetch the ID of the record to delete
        $medicine_id = isset($_GET['id']) ? $_GET['id'] : '';

        // Check if ID exists
        if (!empty($medicine_id)) {
            // Fetch medicine data for confirmation
            $sql = "SELECT pm.*, p.patient_name, d.doctor_name
                    FROM patient_medicine pm
                    LEFT JOIN patient p ON pm.patient_id = p.UserID
                    LEFT JOIN doctor d ON pm.doctor_id = d.UserID
                    WHERE pm.id = '$medicine_id'";
            $result = $conn->query($sql);
            $medicine = $result->fetch_assoc();

            if ($medicine) {
                // Display the medicine info for confirmation
                echo "<h4>Medicine: " . $medicine['Medication'] . "</h4>";
                echo "<p><strong>Patient Name:</strong> " . $medicine['patient_name'] . "</p>";
                echo "<p><strong>Doctor Name:</strong> " . $medicine['doctor_name'] . "</p>";
            } else {
                echo "<div class='alert alert-danger'>Medicine record not found!</div>";
            }
        }
        ?>

        <form action="delete-patient-medicine.php" method="GET" class="text-center">
            <input type="hidden" name="id" value="<?php echo $medicine_id; ?>">
            <input type="hidden" name="action" value="delete">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="view-patient-medicine.php" class="btn btn-secondary">No, Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>