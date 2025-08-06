<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
  header('Location:../login.html');
  exit();
}
require_once '../connection.php';

if (
  isset($_POST['old_password']) && !empty($_POST['old_password']) &&
  isset($_POST['new_password']) && !empty($_POST['new_password']) &&
  isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])
) {
  $userID = $_SESSION['id'];
  $oldPass = md5($_POST['old_password']);
  $newPass = md5($_POST['new_password']);
  $confPass = md5($_POST['confirm_password']);

  if ($newPass !== $confPass) {
    echo "<script>alert('New and confirm passwords do not match.'); window.history.back();</script>";
    exit();
  }

  $sql = "SELECT * FROM user WHERE ID = $userID AND Password = '$oldPass'";
  $result = $conn->query($sql);

  if ($result->num_rows === 1) {
    $sqlUpdate = "UPDATE user SET Password = '$newPass' WHERE ID = $userID";
    if ($conn->query($sqlUpdate) === TRUE) {
      $ip_address = $_SERVER['REMOTE_ADDR'];
      $timestamp = date('Y-m-d H:i:s');
      $user_id = $_SESSION['id'];
      $user_name = $_SESSION['name'];
      $sql_insert = "INSERT INTO systemlog(Timestamp, UserID, Action,IPAddress) 
                    VALUES ('$timestamp', '$user_id', '$user_name Change his Password', '$ip_address')";
      $conn->query($sql_insert);
      echo "<script>alert('Password changed successfully.'); window.location.href='receptionest-home.php';</script>";
    } else {
      echo "<script>alert('Error updating password.'); window.history.back();</script>";
    }
  } else {
    echo "<script>alert('Old password is incorrect.'); window.history.back();</script>";
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Change Password - Medicare Hub</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
  <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #e0f7fa, #a5f3ff);
    }

    .sidebar {
      width: 250px;
      background-color: #2c3e50;
      min-height: 100vh;
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1030;
      transition: transform 0.3s ease-in-out;
    }

    .sidebar .nav-link {
      color: white;
      padding: 1.1rem;
      transition: background-color 0.3s ease;
      border-radius: 0.5rem;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
      background-color: #1abc9c;
    }

    .sidebar-header {
      padding: 1.5rem;
      display: flex;
      align-items: center;
      background-color: #34495e;
      border-bottom: 1px solid #4a6572;
    }

    .sidebar-header img {
      height: 45px;
      margin-right: 0.75rem;
      border-radius: 50%;
    }

    .sidebar-header h5 {
      color: white;
      font-size: 1.25rem;
      margin-bottom: 0;
    }

    .content {
      margin-left: 250px;
      padding: 2rem;
      transition: margin-left 0.3s ease-in-out;
    }

    @media (max-width: 1000px) {
      .sidebar {
        transform: translateX(-100%);
        position: absolute;
      }

      .sidebar.show {
        transform: translateX(0);
      }

      .content {
        margin-left: 0;
        padding-top: 6rem;
      }

      #hamburger {
        display: block;
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1050;
        background-color: #1abc9c;
        border: none;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        color: white;
        cursor: pointer;
      }

      .close-btn {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: transparent;
        border: none;
        color: white;
        font-size: 2rem;
        cursor: pointer;
      }
    }

    #hamburger {
      display: none;
    }

    .form-card {
      background: white;
      border-radius: 1rem;
      padding: 2rem;
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
    }

    .form-card h3 {
      font-weight: 600;
      margin-bottom: 1.5rem;
    }

    .btn-primary {
      background-color: #1abc9c;
      border: none;
    }

    .btn-primary:hover {
      background-color: #17a489;
    }

    .form-label {
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 1.5rem;
      position: relative;
    }

    .form-control-sm {
      max-width: 400px;
      margin: auto;
    }

    .toggle-password {
      position: absolute;
      top: 40px;
      right: 375px;
      cursor: pointer;
      color: #888;
    }

    .toggle-password:hover {
      color: #1abc9c;
    }

    .sidebar-header a {
      transition: background-color 0.3s ease, transform 0.3s ease;
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
    }

    .sidebar-header a:hover {
      background-color: #1abc9c;
      transform: scale(1.02);
      text-decoration: none;
      color: white;
    }
  </style>
</head>

<body>

  <button id="hamburger"><i class="fas fa-bars"></i></button>

  <div class="sidebar" id="sidebar">
    <div class="sidebar-header w-100 d-flex justify-content-between align-items-center">
      <a href="receptionest-home.php" class="d-flex align-items-center gap-2 text-white text-decoration-none">
        <img src="../images/logo.jpeg" alt="Logo" class="rounded-circle" height="45">
        <span class="fw-bold fs-5">Medicare Hub</span>
      </a>
      <button class="close-btn d-md-none" onclick="toggleSidebar()"><i class="fas fa-times"></i></button>
    </div>
    <nav class="nav flex-column px-2">
      <a class="nav-link" href="receptionest-home.php"><i class="fas fa-home me-2"></i> Home</a>
      <a class="nav-link" href="manageusers.php"><i class="fas fa-users me-2"></i> Manage Users</a>
      <a class="nav-link" href="appointments.php"><i class="fas fa-calendar-alt me-2"></i> Appointments</a>
      <a class="nav-link" href="patient-Queries.php"><i class="fas fa-question-circle me-2"></i> Patient Queries</a>
      <a class="nav-link" href="contact-us.php"><i class="fas fa-envelope me-2"></i> Contact Us</a>
      <a class="nav-link" href="pharmacy-Request.php"><i class="fas fa-prescription me-2"></i> Pharmacy Requests</a>
      <a class="nav-link active" href="change-Password.php"><i class="fas fa-lock me-2"></i> Change Password</a>
      <a class="nav-link text-danger" href="../logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
    </nav>
  </div>

  <div class="content" id="content">
    <div class="container">
      <h3 class="text-center text-primary mb-4">Change Password</h3>
      <div class="form-card">
        <form action="" method="POST">
          <!-- Old Password -->
          <div class="form-group">
            <label for="oldPassword" class="form-label">Old Password</label>
            <input type="password" class="form-control form-control-sm" id="oldPassword"
              placeholder="Enter old password" required name="old_password" />
            <i class="fa fa-eye toggle-password" data-target="oldPassword"></i>
          </div>

          <!-- New Password -->
          <div class="form-group">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control form-control-sm" id="newPassword"
              placeholder="Enter new password" required minlength="8" name="new_password" />
            <i class="fa fa-eye toggle-password" data-target="newPassword"></i>
          </div>

          <!-- Confirm New Password -->
          <div class="form-group">
            <label for="confirmNewPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control form-control-sm" id="confirmNewPassword"
              placeholder="Confirm new password" required minlength="8" name="confirm_password" />
            <i class="fa fa-eye toggle-password" data-target="confirmNewPassword"></i>
          </div>

          <!-- Change Password Button -->
          <div class="form-group text-center">
            <button type="submit" class="btn btn-primary">Change Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    const sidebar = document.getElementById('sidebar');
    const hamburger = document.getElementById('hamburger');
    const closeBtn = sidebar.querySelector('.close-btn');
    const content = document.getElementById('content');

    function toggleSidebar() {
      sidebar.classList.toggle('show');
      updateHamburger();
    }

    function updateHamburger() {
      if (window.innerWidth < 1000) {
        hamburger.style.display = sidebar.classList.contains('show') ? 'none' : 'block';
      } else {
        hamburger.style.display = 'none';
      }
    }

    hamburger.addEventListener('click', () => {
      sidebar.classList.add('show');
      updateHamburger();
    });

    closeBtn?.addEventListener('click', () => {
      sidebar.classList.remove('show');
      updateHamburger();
    });

    window.addEventListener('resize', updateHamburger);
    window.addEventListener('DOMContentLoaded', updateHamburger);

    // Toggle Password Visibility
    document.querySelectorAll('.toggle-password').forEach(icon => {
      icon.addEventListener('click', function () {
        const input = document.getElementById(this.getAttribute('data-target'));
        const isPassword = input.getAttribute('type') === 'password';
        input.setAttribute('type', isPassword ? 'text' : 'password');
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
      });
    });
  </script>

</body>

</html>