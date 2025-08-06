<?php
session_start();
if ($_SESSION['role'] != 1 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
} else {
    require_once '../connection.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $sql = 'SELECT * FROM user WHERE role_id = 3';
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Receptionist</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
        <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
        <style>
            body {
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                background: linear-gradient(135deg, #e0f7fa, #80deea);
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                margin: 0;
                color: #333;
            }

            .edit-container {
                background-color: rgba(255, 255, 255, 0.9);
                padding: 40px;
                border-radius: 10px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
                width: 500px;
                max-width: 90%;
                position: relative;
            }

            .edit-container h2 {
                text-align: center;
                margin-bottom: 30px;
                color: #007bff;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                display: block;
                margin-bottom: 8px;
                font-weight: bold;
            }

            .form-group input,
            .form-group select {
                width: 100%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 5px;
                box-sizing: border-box;
            }

            .form-group input:focus,
            .form-group select:focus {
                outline: none;
                border-color: #007bff;
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            }

            .btn-update {
                background-color: #28a745;
                /* Green for update */
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                width: 100%;
                font-size: 16px;
            }

            .btn-update:hover {
                background-color: #218838;
            }

            .back-icon {
                position: absolute;
                top: 10px;
                left: 10px;
                font-size: 20px;
                color: #007bff;
                cursor: pointer;
            }
        </style>
    </head>

    <body>
        <div class="edit-container">
            <a href="manage-Receptionest.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <h2>Edit Receptionist</h2>
            <form id="editForm" method="post" action="updateReceptionest.php?id=<?= $id ?>">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" value="<?= $row['Username'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="fullName">Full Name:</label>
                    <input type="text" id="fullName" name="fullName" value="<?= $row['FullName'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= $row['Email'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number:</label>
                    <input type="tel" id="phoneNumber" name="phoneNumber" value="<?= $row['PhoneNumber'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" value="<?= $row['DateOfBirth'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" required>
                        <?php
                        if ($row['Gender'] == 'Male') {
                            echo "<option value='Male' selected>Male</option>
                        <option value='Female'>Female</option>";
                        } else {
                            echo "<option value='Male'>Male</option>
                        <option value='Female' selected>Female</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn-update">Update Receptionist</button>
            </form>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>
    <?php
}
?>