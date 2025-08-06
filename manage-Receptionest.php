<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Manage Receptionists</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                padding: 20px;
                background: linear-gradient(135deg, #e0f7fa, #80deea);
            }

            .reception {
                background-color: #fff0f0;
                color: #c0392b;
                padding: 20px 40px;
                border: 1px solid #f5c6cb;
                border-radius: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                font-size: 24px;
                text-align: center;
                animation: pulse 1.5s infinite;
            }

            @keyframes pulse {
                0% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(192, 57, 43, 0.4);
                }

                70% {
                    transform: scale(1.05);
                    box-shadow: 0 0 0 10px rgba(192, 57, 43, 0);
                }

                100% {
                    transform: scale(1);
                    box-shadow: 0 0 0 0 rgba(192, 57, 43, 0);
                }
            }

            .header {
                background-color: #ffffff;
                padding: 15px;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
            }

            .logo-container img {
                max-width: 100px;
                border-radius: 50%;
            }

            .search-container input {
                border: 1px solid #ccc;
                padding: 8px;
            }

            .search-container button {
                background-color: #007bff;
                border: 1px solid #007bff;
                color: white;
                padding: 8px 12px;
                cursor: pointer;
            }

            .table {
                background-color: #ffffff;
                border-radius: 8px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            .table th,
            .table td {
                vertical-align: middle;
                text-align: center;
            }

            .btn-primary {
                background-color: #28a745;
                border-color: #28a745;
            }

            .btn-warning {
                background-color: #ffc107;
                border-color: #ffc107;
            }

            .btn-danger {
                background-color: #dc3545;
                border-color: #dc3545;
            }

            .btn-info {
                background-color: #17a2b8;
                border-color: #17a2b8;
            }

            .icon-btn {
                padding: 5px 10px;
                border-radius: 5px;
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <div class="header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-3 mb-2 mb-md-0">
                        <div class="logo-container">
                            <a href="../Admin/admin-home.php"><img src="../images/logo.jpeg" alt="Clinic Logo"></a>
                        </div>
                    </div>
                    <div class="col-md-6 text-center">
                        <h1>View All Receptionists</h1>
                    </div>
                    <div class="col-md-3">
                        <!-- Search Form -->
                        <form method="POST" class="search-container d-flex">
                            <input type="text" class="form-control" name="search_query" placeholder="Search..."
                                value="<?php echo isset($_POST['search_query']) ? $_POST['search_query'] : ''; ?>">
                            <button type="submit" name="search" class="btn btn-primary"><i
                                    class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <a href="add-Receptionest.php"><button class="btn btn-primary mb-3">Add Receptionist</button></a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <tbody>
                        <?php
                        require_once '../connection.php';
                        if (isset($_POST['search']) && !empty($_POST['search_query'])) {
                            $searchQuery = $_POST['search_query'];
                            $sql = "SELECT * FROM user WHERE role_id = 3 AND (FullName LIKE '%$searchQuery%')";
                        } else {
                            $sql = "SELECT * FROM user WHERE role_id = 3";
                        }

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<thead>
                            <tr>
                                <th>ID</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Date of Birth</th>
                                <th>Gender</th>
                                <th>Reset Password</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>";
                            while ($row = $result->fetch_assoc()) {
                                $id = $row['ID'];
                                echo "<tr>
                                <td>" . $row['ID'] . "</td>
                                <td>" . $row['FullName'] . "</td>
                                <td>" . $row['Username'] . "</td>
                                <td>" . $row['Email'] . "</td>
                                <td>" . $row['PhoneNumber'] . "</td>
                                <td>" . $row['DateOfBirth'] . "</td>
                                <td>" . $row['Gender'] . "</td>
                                <td><a href='resetReceptionest-password.php?id=$id' class='btn btn-warning btn-sm icon-btn'>Reset</a></td>
                                <td><a href='editReceptionest.php?id=$id' class='btn btn-info btn-sm icon-btn'><i class='fas fa-pencil-alt'></i></a></td>
                                <td><a href='deleteReceptionest.php?id=$id' class='btn btn-danger btn-sm icon-btn'><i class='fas fa-trash-alt'></i></a></td>
                            </tr>";
                            }
                        } else {
                            echo "<h1 class='reception'>No Receptionist Found</h1>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <?php
}
?>