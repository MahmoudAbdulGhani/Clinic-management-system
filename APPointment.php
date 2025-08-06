<?php
session_start();
if ($_SESSION['role'] != 5 || $_SESSION['isloggedin'] != 1) {
  header('Location:../login.html');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment Confirmation</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
  <style>
    :root {
      --primary-color: #007bff;
      /* Bootstrap's primary */
      --primary-dark: #0056b3;
      --secondary-color: #e9ecef;
      /* Light gray */
      --text-dark: #212529;
      /* Very dark gray, almost black */
      --text-light: #f8f9fa;
      /* Very light gray, almost white */
      --accent-color: #ffc107;
      /* Yellowish, for emphasis */
      --border-radius: 0.5rem;
      --box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
      --transition-duration: 0.3s;
    }

    body {
      font-family: 'Roboto', sans-serif;
      background-color: var(--secondary-color);
      color: var(--text-dark);
      margin: 0;
      padding: 0;
    }

    /* Navbar Styles */
    .navbar {
      background-color: var(--primary-color);
      padding: 0.5rem 1rem;
      box-shadow: var(--box-shadow);
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 1rem;
      border-radius: 50%;
    }

    .navbar-brand {
      display: flex;
      align-items: center;
      color: var(--text-light);
      font-weight: bold;
      font-size: 1.25rem;
      text-decoration: none;
    }

    .navbar-nav .nav-link {
      color: var(--text-light);
      margin: 0 0.75rem;
      font-weight: 500;
      transition: color var(--transition-duration);
    }

    .navbar-nav .nav-link:hover,
    .navbar-nav .nav-link.active {
      color: var(--accent-color);
    }

    .navbar-nav .nav-item:last-child .nav-link {
      margin-right: 0;
    }

    .navbar-toggler {
      border-color: var(--text-light);
      color: var(--text-light);
    }

    .navbar-toggler:focus {
      box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.5);
    }



    /* Appointment Confirmation Styles */
    .confirmation-container {
      background-color: var(--text-light);
      border-radius: var(--border-radius);
      padding: 2rem;
      margin-top: 2rem;
      box-shadow: var(--box-shadow);
    }

    .confirmation-container h2 {
      color: var(--primary-color);
      margin-bottom: 1.5rem;
      text-align: center;
    }

    .confirmation-container label {
      font-weight: 500;
      margin-bottom: 0.25rem;
      display: block;
    }

    .confirmation-container p {
      margin-bottom: 1rem;
      font-size: 1.1rem;
    }

    .confirmation-container select {
      width: 100%;
      padding: 0.75rem;
      border: 1px solid #ddd;
      border-radius: var(--border-radius);
      margin-bottom: 1.5rem;
      transition: border-color var(--transition-duration);
    }

    .confirmation-container select:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .confirmation-container .btn {
      margin-top: 1rem;
      padding: 0.75rem 1.5rem;
      border-radius: var(--border-radius);
      transition: background-color var(--transition-duration), color var(--transition-duration);
      font-weight: 500;
      border: none;
      cursor: pointer;
    }

    .confirmation-container .btn-primary {
      background-color: var(--primary-color);
      color: var(--text-light);
    }

    .confirmation-container .btn-primary:hover {
      background-color: var(--primary-dark);
    }

    .confirmation-container .btn-secondary {
      background-color: var(--secondary-color);
      color: var(--text-dark);
    }

    .confirmation-container .btn-secondary:hover {
      background-color: #d3d3d3;
    }

    @media (max-width: 992px) {
      .navbar-nav {
        flex-direction: column;
      }

      .navbar-nav .nav-item {
        margin: 0.5rem 0;
      }

    }

    @media (max-width: 768px) {

      .confirmation-container {
        padding: 1rem;
      }
    }

    button a {
      text-decoration: none;
      color: #212529;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="patient-home.php">
        <img src="../images/logo.jpeg" alt="Medicare Hub Logo">
        Medicare Hub
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="appointment-history.php">Appointment History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="chat.php">Chat with Us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="confirmation-container">
      <?php
      require_once '../connection.php';
      $id = $_GET['id'];
      $sql_select = "SELECT * FROM appointment, doctor WHERE AppointmentID = '$id' AND DoctorID = UserID";
      $result = $conn->query($sql_select);
      $row = $result->fetch_assoc();
      ?>
      <h2>Confirm Appointment</h2>
      <p><label>Doctor Name: <?= $row['doctor_name'] ?></label></p>
      <p><label>Date: <?= $row['appointment_date'] ?></label></p>
      <p><label>Start Time: <?= $row['appointment_startTime'] ?></label></p>
      <p><label>End Time: <?= $row['appointment_endTime'] ?>:</label></p>
      <p><label>Staus: <?= $row['Status'] ?></label></p>
      <form action="confirm-appointment.php?id=<?= $id ?>" method="post">
        <label for="appointment-type">Select Appointment Type:</label>
        <select id="appointment-type" name="appType">
          <option value="First-Appointment">First Appointment</option>
          <option value="Check-up">Check Up</option>
          <option value="Vaccination">Vaccination</option>
          <option value="Emergency">Emergency</option>
        </select>
        <div class="d-flex justify-content-end">
          <button type="submit" id="confirm-button" class="btn btn-primary me-2">Confirm Appointment</button>
          <button id="cancel-button" class="btn btn-secondary" onclick="history.back()">Cancel Appointment</button>

        </div>
        </from>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>