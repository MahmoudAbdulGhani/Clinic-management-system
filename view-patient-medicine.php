<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 4) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

if (!empty($search)) {
    $sql_select_patient_medicine = "SELECT pm.*, d.doctor_name
        FROM patient_medicine pm
        JOIN patient p ON pm.patient_id = p.UserID
        LEFT JOIN doctor d ON pm.doctor_id = d.UserID
        WHERE p.patient_name LIKE '%$search%' 
        OR pm.Medication LIKE '%$search%' 
        OR pm.Status LIKE '%$search%'";
} else {
    $sql_select_patient_medicine = "SELECT pm.*, d.doctor_name
FROM patient_medicine pm
LEFT JOIN doctor d ON pm.doctor_id = d.UserID
WHERE pm.Status = 'Pending'";
}

$result = $conn->query($sql_select_patient_medicine);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Medicine</title>
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
        .sidebar .nav--link:hover {
            background-color: #007bff;
            color: white;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }

        .search-container {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px 0 0 5px;
        }

        .search-container button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 0 5px 5px 0;
            cursor: pointer;
        }

        .patient-medicines-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            padding: 20px;
        }

        .patient-medicines-table {
            width: 100%;
            border-collapse: collapse;
        }

        .patient-medicines-table th,
        .patient-medicines-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .patient-medicines-table th {
            background-color: #f0f0f0;
            font-weight: 600;
        }

        .patient-medicines-table tr:hover {
            background-color: #f9f9f9;
        }

        .action-icons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-icons a {
            color: #007bff;
            text-decoration: none;
        }

        .action-icons a:hover {
            color: #0056b3;
        }

        .action-icons .delete-icon {
            color: #dc3545;
        }

        .action-icons .delete-icon:hover {
            color: #c82333;
        }

        .no-data-message {
            margin-top: 50px;
            font-size: 28px;
            font-weight: bold;
            text-align: center;
            color: #dc3545;
            animation: fadeScale 1s ease-out;
            background-color: #fff3f3;
            border: 2px dashed #dc3545;
            padding: 20px;
            border-radius: 10px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }

        @keyframes fadeScale {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }

        .view-history-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            /* Blue background */
            color: white;
            text-decoration: none;
            font-weight: 600;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
            margin-bottom: 20px;
            /* To give some space below */
        }

        .view-history-btn:hover {
            background-color: #0056b3;
            /* Darker blue on hover */
            transform: translateY(-2px);
            /* Slight lift effect */
        }

        .view-history-btn:active {
            transform: translateY(1px);
            /* Slight depression effect */
        }
    </style>
</head>

<body>
    <div class="sidebar d-flex flex-column p-3 shadow bg-white" style="width: 250px; height: 100vh;">
        <!-- Logo -->
        <div class="text-center mb-4">
            <a href="pharmacy-home.php">
                <img src="../images/logo.jpeg" alt="Logo" class="img-fluid rounded-circle" style="width: 100px;">
            </a>
        </div>

        <!-- Navigation -->
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="pharmacy-home.php" class="nav-link text-dark">
                    <i class="fas fa-pills me-2"></i> View Medicine
                </a>
            </li>
            <li>
                <a href="view-patient-medicine.php" class="nav-link active bg-primary text-white">
                    <i class=" fas fa-user-md me-2"></i> View Patient Medicine
                </a>
            </li>
            <li>
                <a href="change-password.php" class="nav-link text-dark">
                    <i class="fas fa-key me-2"></i> Change Password
                </a>
            </li>
            <li>
                <a href="../logout.php" class="nav-link text-dark">
                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>

    <div class="content">
        <div class="search-container">
            <form class="search-container" method="GET" action="">
                <input type="text" name="search" placeholder="Search by Patient or Medicine"
                    value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                <button type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <a href="view-patient-medicine-history.php" class="view-history-btn">View History</a>
        <div class="patient-medicines-container">
            <h2>Patient Medicine List</h2>
            <?php
            if ($result->num_rows > 0) {
                echo "<table class='patient-medicines-table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Medicine Name</th>
                        <th>Quantity</th>
                        <th>Note</th>
                        <th>Status</th>
                        <th>Cancelation Reason</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    // Fetch patient name
                    $sql = "SELECT patient_name FROM patient WHERE UserID = '" . $row['patient_id'] . "'";
                    $result2 = $conn->query($sql);
                    $row2 = $result2->fetch_assoc();
                    echo "<tr>
                    <td>" . $row['id'] . "</td>
                    <td>" . $row['date'] . "</td>
                    <td>" . $row2['patient_name'] . "</td>
                    <td>" . $row['doctor_name'] . "</td> <!-- Doctor's Name -->
                    <td>" . $row['Medication'] . "</td>
                    <td>" . $row['quantity'] . "</td>
                    <td>" . $row['note'] . "</td>
                    <td>" . $row['Status'] . "</td>";
                    if (!empty($row['cancelation_reason'])) {
                        echo "<td>" . $row['cancelation_reason'] . "</td>";
                    } else {
                        echo "<td style='text-align:center;'>------</td>";
                    }
                    echo "<td><div class='action-icons'><a href='edit-patient-medicine.php?id=" . $row['id'] . "'><i class='fas fa-edit'></i></a></div></td>
                    <td><div class='action-icons'><a href='delete-patient-medicine.php?id=" . $row['id'] . "' class='delete-icon'><i class='fas fa-trash-alt'></i></a></div></td>
                    </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<div class='no-data-message'>No Patient Medicine List</div>";
            }
            ?>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>