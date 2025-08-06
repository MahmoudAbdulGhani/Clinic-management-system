<?php
session_start();
if ($_SESSION['role'] != 1 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';

// Handle date filtering
$filterDate = isset($_POST['filterDate']) ? $_POST['filterDate'] : '';
$filterDate = mysqli_real_escape_string($conn, $filterDate);

// SQL query with optional date filter
$sql_select = "SELECT systemlog.*, user.FullName 
               FROM systemlog 
               INNER JOIN user ON systemlog.UserID = user.ID";

if (!empty($filterDate)) {
    $sql_select .= " WHERE DATE(systemlog.Timestamp) = '$filterDate'";
}

$sql_select .= " ORDER BY systemlog.Timestamp DESC";

$result = $conn->query($sql_select);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Logs and Audit Trails</title>
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

        .filter-container {
            margin-bottom: 20px;
            background-color: #ffffff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
        }

        .filter-container label {
            margin-right: 10px;
        }

        .filter-container input[type="date"] {
            margin-right: 10px;
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
            text-align: left;
        }

        .table th {
            background-color: #f0f0f0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .no-logs-animation {
            animation: fadeIn 0.6s ease-in-out;
            color: #888;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="header">
        <div class="logo-container">
            <a href="../Admin/admin-home.php"><img src="../images/logo.jpeg" alt="Clinic Logo"></a>
        </div>
        <h1>System Logs and Audit Trails</h1>
    </div>

    <div class="filter-container">
        <form method="POST" class="d-flex align-items-center">
            <label for="filterDate">Filter by Date:</label>
            <input type="date" id="filterDate" name="filterDate" value="<?php echo htmlspecialchars($filterDate); ?>">
            <button class="btn btn-primary ms-2" type="submit">Filter</button>
        </form>
    </div>

    <div class="table-container">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User Name</th>
                    <th>Action</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['ID']}</td>
                                <td>{$row['FullName']}</td>
                                <td>{$row['Action']}</td>
                                <td>{$row['Timestamp']}</td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center no-logs-animation'>No logs found for selected date.</td></tr>";

                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>