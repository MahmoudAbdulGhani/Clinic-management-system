<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - MedicareHub</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/logo.jpeg" type="image/x-icon">

    <!-- Font Awesome CDN for eye icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

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

        .eye-icon {
            position: absolute;
            right: 10px;
            top: 74%;
            transform: translateY(-50%);
            cursor: pointer;
        }

        .password-wrapper {
            position: relative;
        }
    </style>
</head>

<body>

    <div class="card p-4">
        <h4 class="text-center mb-3">Reset Your Password</h4>
        <form action="update_password.php" method="POST">
            <input type="hidden" name="email" value="<?= $_GET['email'] ?>">

            <div class="mb-3 password-wrapper">
                <label for="new_password" class="form-label">New Password</label>
                <input type="password" class="form-control" id="new_password" name="new_password" required
                    placeholder="Enter new password">
                <!-- Eye icon to toggle password visibility -->
                <i class="fas fa-eye eye-icon" id="togglePassword"></i>
            </div>

            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>

        <!-- Back Button -->
        <a href="forgot_password.php" class="btn btn-secondary w-100 mt-2">Back to Reset</a>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Font Awesome JS for toggling -->
    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordField = document.getElementById("new_password");

        togglePassword.addEventListener("click", function () {
            // Toggle the password visibility
            const type = passwordField.type === "password" ? "text" : "password";
            passwordField.type = type;

            // Toggle the eye icon
            this.classList.toggle("fa-eye-slash");
        });
    </script>
</body>

</html>