<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP - MedicareHub</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            background: #f0f2f5;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #4a90e2;
        }

        .btn-primary {
            background-color: #4a90e2;
            border: none;
        }

        .btn-primary:hover {
            background-color: #357ABD;
        }

        .btn-secondary {
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="card p-4">
        <h4 class="text-center mb-3">Verify Your OTP</h4>
        <form action="check_otp.php" method="POST">
            <input type="hidden" name="email" value="<?= $_GET['email'] ?>">
            <div class="mb-3">
                <label for="otp" class="form-label">Enter OTP</label>
                <input type="text" class="form-control" id="otp" name="otp" required placeholder="Enter OTP">
            </div>
            <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
        </form>

        <!-- Back Button -->
        <a href="forgot_password.php" class="btn btn-secondary w-100 mt-2">Back to Reset</a>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>