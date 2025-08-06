<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
  header('Location:../login.html');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Pharmacist - Medicare Hub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    .form-container {
      max-width: 850px;
      margin: auto;
      background: #ffffff;
      padding: 2rem 3rem;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }

    h2 {
      font-weight: bold;
      color: #2c3e50;
      margin-bottom: 2rem;
    }

    label {
      font-weight: 600;
    }

    .form-control:focus {
      border-color: #1abc9c;
      box-shadow: 0 0 0 0.2rem rgba(26, 188, 156, 0.25);
    }

    .btn-primary {
      background-color: #1abc9c;
      border: none;
    }

    .btn-primary:hover {
      background-color: #16a085;
    }

    .btn-secondary:hover {
      background-color: #6c757d;
    }

    .password-wrapper {
      position: relative;
    }

    .password-toggle {
      position: absolute;
      top: 50%;
      right: 10px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #aaa;
    }

    @media (max-width: 576px) {
      .form-container {
        padding: 1.5rem;
      }
    }
  </style>
</head>

<body>

  <div class="container">
    <div class="form-container">
      <h2><i class="fas fa-user-plus me-2"></i>Add New Pharmacist</h2>
      <form method="post" action="addPharmacist1.php">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Enter Full Name"
              required />
          </div>
          <div class="col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter Username"
              required />
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" required />
          </div>
          <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <div class="password-wrapper">
              <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password"
                required minlength="8" />
              <i class="fas fa-eye password-toggle" id="togglePassword"></i>
            </div>
          </div>
          <div class="col-md-6">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" name="phone" class="form-control" id="phone" placeholder="Enter Phone Number" required />
          </div>
          <div class="col-md-6">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" id="dob" required />
          </div>
          <div class="col-md-6">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" name="gender" id="gender" required>
              <option value="" disabled selected>Select Gender</option>
              <option>Male</option>
              <option>Female</option>
            </select>
          </div>
        </div>

        <!-- Submit and Cancel -->
        <div class="d-flex justify-content-end gap-3 mt-4">
          <a href="managePharmacist.php" class="btn btn-secondary px-4 py-2">
            <i class="fas fa-times me-2"></i>Cancel
          </a>
          <button type="submit" class="btn btn-primary px-5 py-2">
            <i class="fas fa-save me-2"></i>Save Pharmacist
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      this.classList.toggle('fa-eye');
      this.classList.toggle('fa-eye-slash');
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>