<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 2) {
    header('Location:../login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Patient Records</title>
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
            width: 220px;
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
            margin-bottom: 10px;
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
            padding: 20px;
        }

        .search-container {
            margin-bottom: 20px;
            display: flex;
            align-items: center;
        }

        .search-container label {
            margin-right: 10px;
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

        .records-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            padding: 20px;
        }

        .records-table {
            width: 100%;
            border-collapse: collapse;
        }

        .records-table th,
        .records-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }

        .records-table th {
            background-color: #f0f0f0;
            font-weight: 600;
        }

        .records-table tr:hover {
            background-color: #f9f9f9;
        }

        .no-records {
            text-align: center;
            padding: 40px 20px;
            color: #555;
            background-color: #fdfdfd;
            border: 2px dashed #ccc;
            border-radius: 12px;
            animation: fadeInZoom 1s ease forwards;
            margin-top: 30px;
        }

        .no-records i {
            font-size: 48px;
            margin-bottom: 10px;
            color: #aaa;
        }

        @keyframes fadeInZoom {
            0% {
                opacity: 0;
                transform: scale(0.9);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="logo-container">
            <a href="Doctor-home.php"><img src="../images/logo.jpeg" alt="Clinic Logo"></a>
        </div>
        <a href="Doctor-home.php" class="nav-link">
            <i class="fas fa-calendar-alt"></i> View Schedule
        </a>
        <a href="viewPatient-records.php" class="nav-link active">
            <i class="fas fa-notes-medical"></i> View Patient Records
        </a>
        <a href="change-password.php" class="nav-link">
            <i class="fas fa-key"></i> Change Password
        </a>
        <a href="../logout.php" class="nav-link text-danger mt-4">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <div class="content">
        <div class="search-container">
            <form action="" method="post">
                <label for="searchName">Search by Name:</label>
                <input name="search_query" type="text" id="searchName" placeholder="Enter patient name" value="<?php echo isset($_POST['search_query']) ? $_POST['search_query'] : ''; ?>">
                <button type="submit" name="search"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <div class="records-container">
            <h2>Patient Records</h2>
            <?php
            require_once '../connection.php';
            $doctor_id = $_SESSION['id'];
            $search_query = isset($_POST['search_query']) ? $_POST['search_query'] : '';

            if (!empty($search_query)) {
                $sql = "SELECT 
                            user.ID,
                            user.FullName,
                            user.Email,
                            user.PhoneNumber,
                            user.DateOfBirth,
                            user.Gender,
                            MAX(appointment.AppointmentID) AS AppointmentID
                        FROM 
                            appointment
                        JOIN 
                            patient ON appointment.PatientID = patient.UserID
                        JOIN 
                            user ON patient.UserID = user.ID
                        WHERE 
                            appointment.DoctorID = '$doctor_id'
                            AND user.FullName LIKE '%$search_query%'
                        GROUP BY 
                            user.ID, user.FullName, user.Email, user.PhoneNumber, user.DateOfBirth, user.Gender";
            } else {
                $sql = "SELECT 
                            user.ID,
                            user.FullName,
                            user.Email,
                            user.PhoneNumber,
                            user.DateOfBirth,
                            user.Gender,
                            MAX(appointment.AppointmentID) AS AppointmentID
                        FROM 
                            appointment
                        JOIN 
                            patient ON appointment.PatientID = patient.UserID
                        JOIN 
                            user ON patient.UserID = user.ID
                        WHERE 
                            appointment.DoctorID = '$doctor_id'
                        GROUP BY 
                            user.ID, user.FullName, user.Email, user.PhoneNumber, user.DateOfBirth, user.Gender";
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table class='records-table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Date Of Birth</th>
                        <th>Gender</th>
                        <th>Details</th>
                    </tr>
                </thead><tbody>";
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                    <td>" . $row['ID'] . "</td>
                    <td>" . $row['FullName'] . "</td>
                    <td>" . $row['Email'] . "</td>
                    <td>" . $row['PhoneNumber'] . "</td>
                    <td>" . $row['DateOfBirth'] . "</td>
                    <td>" . $row['Gender'] . "</td>
                    <td><a href='view-patient-details.php?id=" . $row['ID'] . "' class='btn btn-primary btn-sm'>View Details</a></td>
                </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<div class='no-records'>
                    <i class='fas fa-folder-open'></i>
                    <h1>There Are No Patient Records</h1>
                  </div>";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>