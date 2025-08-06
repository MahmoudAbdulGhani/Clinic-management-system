<?php
require_once 'connection.php';
$email = "";
$stored_otp = "";
$message = "";
$name = "";
$id = "";
$showForm = false;

$ip_address = $_SERVER['REMOTE_ADDR'];

// Check for pending OTP
$sql = "SELECT * FROM user WHERE ip = '$ip_address' AND status = 'pending' AND role_id = 5 ORDER BY otp_send_time DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $email = $row['Email'];
    $stored_otp = $row['otp'];
    $name = $row['FullName'];
    $id = $row['ID'];
    $showForm = true;
} else {
    $message = "No pending OTP found for this device.";
}

if (isset($_POST['verify']) && $showForm) {
    $entered_otp = trim($_POST['otp']);

    if ($entered_otp === $stored_otp) {
        $sql_update = "UPDATE user SET status = 'verified' WHERE email = '$email' AND ip = '$ip_address'";
        if ($conn->query($sql_update) === TRUE) {
            // Insert into patient table
            $sql_insert_patient = "INSERT INTO `patient`(`UserID`, `patient_name`) VALUES ('$id','$name')";
            $conn->query($sql_insert_patient);

            header("Location: success.php");
            exit();
        } else {
            $message = "Error updating status: " . $conn->error;
        }
    } else {
        $message = "Invalid OTP. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>OTP Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="shortcut icon" href="images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            background-image: url('img/cover.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            width: 100%;
            max-width: 420px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .form-container h5 {
            text-align: center;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
        }

        .input-group-text {
            background-color: #f1f1f1;
            border-right: none;
        }

        .form-control {
            border-left: none;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert {
            font-size: 0.95rem;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h5>OTP Verification</h5>

        <?php if ($showForm): ?>
            <div class="alert alert-info">
                Your email is: <strong><?php echo htmlspecialchars($email); ?></strong>
            </div>

            <form method="POST">
                <div class="mb-3 input-group">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                    <input type="text" name="otp" id="otp" class="form-control" placeholder="Enter your Verification Code"
                        required />
                </div>

                <button type="submit" name="verify" class="btn btn-primary w-100">
                    Verify OTP <i class="fas fa-arrow-right ms-2"></i>
                </button>
            </form>

            <?php if (!empty($message)): ?>
                <div class="alert alert-warning mt-3">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="alert alert-danger">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
    </div>
</body>

</html>