<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
  header('Location:../login.html');
  exit();
}

require_once '../connection.php';
$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $fullname = $_POST['fullname'];
  $phone = $_POST['phone'];
  $dob = $_POST['dob'];
  $gender = $_POST['gender'];
  $email = $_POST['email'];
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  // Check if email or username already exists
  $sql_check = "SELECT * FROM user WHERE Email = '$email' OR Username = '$username'";
  $result_check = $conn->query($sql_check);

  if ($result_check->num_rows > 0) {
    $existing = $result_check->fetch_assoc();
    if ($existing['Email'] == $email) {
      $error = "The email is already registered.";
    } else {
      $error = "The username is already taken.";
    }
  } else {
    // Insert into user table
    $sql_user = "INSERT INTO user (FullName, PhoneNumber, DateOfBirth, Gender, Email, Username, Password, role_id, status) 
                 VALUES ('$fullname', '$phone', '$dob', '$gender', '$email', '$username', '$password', 5, 'verified')";

    if ($conn->query($sql_user) === TRUE) {
      $user_id = $conn->insert_id;

      // Insert into patient table
      $sql_patient = "INSERT INTO patient (patient_name, UserID) VALUES ('$fullname', '$user_id')";
      if ($conn->query($sql_patient) === TRUE) {
        $timestamp = date("Y-m-d H:i:s");
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $id = $_SESSION['id'];
        $user_name = $_SESSION['name'];
        $sql_system_log = "INSERT INTO systemlog(Timestamp, UserID, Action, IPAddress)
                           VALUES('$timestamp', '$id', 'Receptionist $user_name added patient $fullname', '$ip_address')";
        $conn->query($sql_system_log);
        header('Location: managePatient.php?success=1');
        exit();
      } else {
        $error = "Failed to add patient: " . $conn->error;
      }
    } else {
      $error = "Error creating user: " . $conn->error;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Add Patient - Medicare Hub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background: #f4f6f9;
      overflow-x: hidden;
    }

    .sidebar {
      width: 250px;
      background-color: #2c3e50;
      min-height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
    }

    .sidebar .nav-link {
      color: white;
      padding: 1rem;
      font-size: 1.1rem;
      transition: background-color 0.3s ease;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #1abc9c;
    }

    .sidebar-header {
      padding: 1rem;
      background-color: #34495e;
    }

    .sidebar-header img {
      height: 40px;
      border-radius: 50%;
    }

    .content {
      margin-left: 250px;
      padding: 2rem;
    }

    .form-container {
      background: #ffffff;
      padding: 2rem;
      border-radius: 15px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }

    .eye-icon {
      position: absolute;
      right: 20px;
      top: 55%;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .btn-primary {
      background-color: #1abc9c;
      border: none;
    }

    .btn-primary:hover {
      background-color: #16a085;
    }
  </style>
</head>

<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="sidebar-header text-white d-flex align-items-center gap-2">
      <img src="../images/logo.jpeg" alt="Logo">
      <h5 class="mb-0">Medicare Hub</h5>
    </div>
    <nav class="nav flex-column">
      <a class="nav-link" href="receptionest-home.php"><i class="fas fa-home me-2"></i>Home</a>
      <a class="nav-link" href="manageUsers.php"><i class="fas fa-users me-2"></i>Manage Users</a>
      <a class="nav-link active" href="managePatient.php"><i class="fas fa-procedures me-2"></i>Manage Patients</a>
      <a class="nav-link" href="appointments.php"><i class="fas fa-calendar-alt me-2"></i>Appointments</a>
      <a class="nav-link" href="patient-Queries.php"><i class="fas fa-question-circle me-2"></i>Patient Queries</a>
      <a class="nav-link" href="pharmacy-Request.php"><i class="fas fa-prescription me-2"></i>Pharmacy Requests</a>
      <a class="nav-link" href="change-Password.php"><i class="fas fa-lock me-2"></i>Change Password</a>
      <a class="nav-link text-danger" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
    </nav>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="container">
      <div class="form-container">
        <h2 class="text-center mb-4">Add New Patient</h2>

        <?php if (!empty($error)): ?>
          <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" action="">
          <div class="row">
            <div class="col-md-6">
              <label for="fullname" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter Full Name..." required />
            </div>
            <div class="col-md-6">
              <label for="phone" class="form-label">Phone Number</label>
              <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number..." required />
            </div>
            <div class="col-md-6">
              <label for="dob" class="form-label">Date of Birth</label>
              <input type="date" class="form-control" id="dob" name="dob" required />
            </div>
            <div class="col-md-6">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-select" id="gender" name="gender" required>
                <option value="" disabled selected>Select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="username" class="form-label">Username</label>
              <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username..." required />
            </div>
            <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email..." required />
            </div>
            <div class="col-md-6 position-relative">
              <label for="password" class="form-label">Password</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password..." required minlength="8" />
              <i class="fas fa-eye eye-icon" id="togglePassword" onclick="togglePassword()"></i>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-3 mt-4">
            <a href="managePatient.php" class="btn btn-secondary px-4 py-2">
              <i class="fas fa-times me-2"></i>Cancel
            </a>
            <button type="submit" class="btn btn-primary px-5 py-2">
              <i class="fas fa-save me-2"></i>Save Patient
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    // Toggle password visibility
    function togglePassword() {
      var passwordField = document.getElementById("password");
      var eyeIcon = document.getElementById("togglePassword");
      if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
      } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
      }
    }
  </script>
</body>

</html>