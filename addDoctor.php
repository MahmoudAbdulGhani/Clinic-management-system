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
  <title>Add Doctor - Medicare Hub</title>
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
      <h2><i class="fas fa-user-md me-2"></i>Add New Doctor</h2>
      <form method="post" action="addDoctor1.php">
        <div class="row g-3">
          <div class="col-md-6">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username"
              required />
          </div>
          <div class="col-md-6">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullName" placeholder="Enter full name"
              required />
          </div>
          <div class="col-md-6">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter password"
                required minlength="8" />
              <button type="button" class="btn btn-outline-secondary toggle-password" tabindex="-1">
                <i class="fas fa-eye"></i>
              </button>
            </div>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required />
          </div>
          <div class="col-md-6">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" minlength="8" id="phone" name="phone"
              placeholder="Enter phone number" required />
          </div>
          <div class="col-md-6">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" class="form-control" id="dob" name="dob" required />
          </div>
          <div class="col-md-6">
            <label for="gender" class="form-label">Gender</label>
            <select class="form-select" id="gender" name="gender" required>
              <option value="" disabled selected>Select gender</option>
              <option>Male</option>
              <option>Female</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="specialty" class="form-label">Specialty</label>
            <select class="form-select" id="specialty" name="specialty" required>
              <option value="" disabled selected>Select Specialty</option>
              <option value="Cardiology">Cardiology</option>
              <option value="General-Surgery">General-Surgery</option>
              <option value="Orthopedics">Orthopedics</option>
              <option value="Dermatology">Dermatology</option>
              <option value="Pediatrics">Pediatrics</option>
            </select>
          </div>

          <div class="col-md-6">
            <label for="experience" class="form-label">Years Of Experience</label>
            <input type="number" class="form-control" id="experience" name="experience"
              placeholder="Enter years of experience" />
          </div>
        </div>

        <!-- Submit and Cancel -->
        <div class="d-flex justify-content-end gap-3 mt-4">
          <a href="manageDoctor.php" class="btn btn-secondary px-4 py-2">
            <i class="fas fa-times me-2"></i>Cancel
          </a>
          <button type="submit" class="btn btn-primary px-5 py-2">
            Add Doctor
          </button>
        </div>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.querySelectorAll('.toggle-password').forEach(button => {
      button.addEventListener('click', function () {
        const passwordField = this.previousElementSibling;
        const passwordVisible = passwordField.type === 'text';

        passwordField.type = passwordVisible ? 'password' : 'text';
        this.innerHTML = passwordVisible
          ? '<i class="fas fa-eye"></i>'
          : '<i class="fas fa-eye-slash"></i>';
      });
    });
  </script>
</body>

</html>