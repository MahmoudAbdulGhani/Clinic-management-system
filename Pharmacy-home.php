<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 4) {
    header('Location:../login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pharmacy Home - View Medicine</title>
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
            padding: 20px;
        }

        .search-add-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-container {
            display: flex;
            align-items: center;
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

        .medicines-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
            padding: 20px;
        }

        .medicines-table {
            width: 100%;
            border-collapse: collapse;
        }

        .medicines-table th,
        .medicines-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #e0e0e0;
        }

        .medicines-table th {
            background-color: #f0f0f0;
            font-weight: 600;
        }

        .medicines-table tr:hover {
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

        .low-stock {
            background-color: #f8d7da !important;
            /* Light red */
            color: #721c24;
            font-weight: bold;
        }

        .medium-stock {
            background-color: #fff3cd !important;
            /* Light orange/yellow */
            color: #856404;
            font-weight: bold;
        }

        .high-stock {
            background-color: #d4edda !important;
            /* Light green */
            color: #155724;
            font-weight: bold;
        }


        .no-medicines-container {
            text-align: center;
            padding: 50px;
            animation: fadeInUp 1s ease-out forwards;
            opacity: 0;
        }

        .no-medicines-icon {
            width: 150px;
            opacity: 0.7;
            animation: bounceIn 1.5s ease-in-out 0.5s forwards;
        }

        .no-medicines-heading {
            margin-top: 20px;
            color: #555;
            font-size: 24px;
            animation: fadeInUp 1s ease-out 0.5s forwards;
        }

        .no-medicines-description {
            color: #777;
            font-size: 16px;
            animation: fadeInUp 1s ease-out 1s forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% {
                transform: translateY(-50px);
                opacity: 0;
            }

            50% {
                transform: translateY(10px);
                opacity: 1;
            }

            100% {
                transform: translateY(0);
            }
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
                <a href="pharmacy-home.php" class="nav-link active bg-primary text-white">
                    <i class="fas fa-pills me-2"></i> View Medicine
                </a>
            </li>
            <li>
                <a href="view-patient-medicine.php" class="nav-link text-dark">
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
        <div class="search-add-container">
            <div class="search-container">
                <form method="post">
                    <input type="text" name="search_query" placeholder="Search Medicine"
                        value="<?php echo isset($_POST['search_query']) ? $_POST['search_query'] : '' ?>">

                    <button type="submit" name="search"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <a href="add-medicine.php" class="btn btn-primary">Add Medicine</a>
        </div>

        <div class="medicines-container">
            <h2>Medicine List</h2>
            <?php
            require_once '../connection.php';

            // Helper function for stock class
            function getStockClass($stock)
            {
                if ($stock <= 10) {
                    return 'low-stock';
                } elseif ($stock <= 50) {
                    return 'medium-stock';
                } else {
                    return 'high-stock';
                }
            }

            if (isset($_POST['search']) && !empty($_POST['search_query'])) {
                $searchQuery = $_POST['search_query'];
                $sql = "SELECT * FROM medicines WHERE name LIKE '%$searchQuery%'";
            } else {
                $sql = "SELECT * FROM medicines";
            }

            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                echo "<table class='medicines-table'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Medication Dose</th>
                        <th>Stock</th>
                        <th>Expiry Date</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>";
                echo "<tbody>";
                while ($row = $result->fetch_assoc()) {
                    $stockClass = getStockClass($row['stock']);
                    echo "<tr>
                        <td>" . $row['id'] . "</td>
                        <td>" . $row['name'] . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>" . $row['dose'] . "</td>
                        <td class='$stockClass'>" . $row['stock'] . "</td>
                        <td>" . $row['expiry_date'] . "</td>
                        <td><a href='edit-medicine.php?id=" . $row['id'] . "'><i class='fas fa-edit'></i></a></td>
                        <td><a href='delete-medicine.php?id=" . $row['id'] . "' class='delete-icon icon-btn'><i class='fas fa-trash-alt'></i></a></td>
                    </tr>";
                }
                echo "</tbody>
            </table>";
            } else {
                echo "
                <div class='no-medicines-container'>
                    <img src='../images/empty-box.png' alt='No Medicines' class='no-medicines-icon'>
                    <h3 class='no-medicines-heading'>No Medicines Available</h3>
                    <p class='no-medicines-description'>You can add new medicines by clicking the 'Add Medicine' button above.</p>
                </div>
                ";
            }
            ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>