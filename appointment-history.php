<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 5) {
  header('Location:../login.html');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Appointment History</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    :root {
      --primary-color: #007bff;
      --primary-dark: #0056b3;
      --secondary-color: #e9ecef;
      --text-dark: #212529;
      --text-light: #f8f9fa;
      --accent-color: #ffc107;
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

    .navbar-toggler {
      border-color: var(--text-light);
      color: var(--text-light);
    }

    .navbar-toggler:focus {
      box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.5);
    }

    .filter-container {
      display: flex;
      flex-wrap: wrap;
      gap: 1rem;
      margin-bottom: 1rem;
      align-items: center;
    }

    .filter-container .form-label {
      margin-bottom: 0.25rem;
    }

    .filter-container .btn {
      background-color: var(--primary-color);
      color: var(--text-light);
      border: none;
      padding: 0.5rem 1rem;
      border-radius: var(--border-radius);
      cursor: pointer;
      transition: background-color var(--transition-duration);
      font-weight: 500;
    }

    .filter-container .btn:hover {
      background-color: var(--primary-dark);
    }

    .filter-container input[type="date"] {
      border-radius: var(--border-radius);
      border: 1px solid #ddd;
      padding: 0.5rem;
      transition: border-color var(--transition-duration);
      width: auto;
    }

    .filter-container input[type="date"]:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .table-container {
      margin-top: 1rem;
      border-radius: var(--border-radius);
      overflow: hidden;
      box-shadow: var(--box-shadow);
    }

    .table {
      background-color: var(--text-light);
      width: 100%;
      border-collapse: collapse;
    }

    .table thead th {
      background-color: var(--primary-color);
      color: var(--text-light);
      padding: 0.75rem;
      text-align: left;
      border-bottom: 2px solid var(--primary-dark);
    }

    .table tbody tr:nth-child(odd) {
      background-color: #f2f2f2;
    }

    .table tbody tr:hover {
      background-color: #e0f7fa;
      transition: background-color var(--transition-duration);
    }

    .table td {
      padding: 0.75rem;
      border-bottom: 1px solid #ddd;
    }

    .table td button {
      background-color: var(--accent-color);
      color: var(--text-dark);
      border: none;
      padding: 0.5rem 1rem;
      border-radius: var(--border-radius);
      cursor: pointer;
      transition: background-color var(--transition-duration), color var(--transition-duration);
      font-weight: 500;
    }

    .table td button:hover {
      background-color: #ffdb58;
      transform: translateY(-2px);
    }

    .table td button:disabled {
      background-color: #cccccc;
      color: #666666;
      cursor: not-allowed;
      transform: none;
    }

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

      .search-container {
        flex-direction: column;
        align-items: stretch;
      }

      .search-container input,
      .search-container button {
        border-radius: var(--border-radius);
        margin-bottom: 0.5rem;
      }

      .search-container button {
        width: 100%;
      }

      .filter-container {
        flex-direction: column;
        align-items: flex-start;
      }
    }

    @media (max-width: 768px) {
      .carousel-caption {
        padding: 10px;
        bottom: 5px;
        left: 5px;
      }

      .carousel-caption h5 {
        font-size: 1.2rem;
      }

      .carousel-caption p {
        font-size: 0.9rem;
      }

      .table thead th,
      .table td {
        padding: 0.5rem;
      }

      .confirmation-container {
        padding: 1rem;
      }

      .filter-container {
        flex-direction: column;
        align-items: flex-start;
      }
    }

    .btn-info:hover {
      background-color: #117a8b !important;
      color: #fff !important;
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
            <a class="nav-link active" href="appointment-history.php">Appointment History</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="chat.php">Chat with Us</a>
          </li>
          <li class="nav-item"><a class="nav-link" href="change-password.php">Change Password</a></li>
          <li class="nav-item">
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <h2 class="mt-4 mb-4">Appointment History</h2>

    <div class="filter-container">
      <form action="" method="post" class="d-flex align-items-center">
        <label for="filter-date" class="form-label me-2 mb-0">Filter by Date:</label>
        <input type="date" id="filter-date" name="filter-date" class="form-control me-2"
          value="<?php echo isset($_POST['filter-date']) ? $_POST['filter-date'] : '' ?>">
        <button id="filter-button" name="search" class="btn btn-primary" type="submit">Filter</button>
      </form>
    </div>



    <?php
    require_once '../connection.php';

    $patient_id = $_SESSION['id'];
    $date_filter = isset($_POST['filter-date']) ? $_POST['filter-date'] : '';  // Get date filter from the form

    // Modify the SQL query based on the filter
    if ($date_filter) {
      $sql_select = "SELECT * FROM appointment WHERE PatientID = '$patient_id' AND appointment_date = '$date_filter'";
    } else {
      $sql_select = "SELECT * FROM appointment WHERE PatientID = '$patient_id'";
    }

    $result = $conn->query($sql_select);

    if ($result->num_rows > 0) {
      echo "<div class='table-container'>
  <table class='table'>
    <thead>
      <tr>
        <th>Doctor Name</th>
        <th>Date</th>
        <th>Department</th>
        <th>Type of Appointment</th>
        <th>Appointment Status</th>
        <th>Cancelation Reason</th>
        <th>View Details</th>
      </tr>
    </thead><tbody>";

      while ($row = $result->fetch_assoc()) {
        echo "
    <tr>
      <td>" . $row['doctor_name'] . "</td>
      <td>" . $row['appointment_date'] . "</td>
      <td>" . $row['department'] . "</td>
      <td>" . $row['type'] . "</td>
      <td>" . $row['Status'] . "</td>
      <td>" . $row['cancelation_reason'] . "</td>
    <td>
  <a href='view-details.php?id=" . $row['AppointmentID'] . "' class='btn btn-sm btn-info text-white'>
    <i class='fas fa-eye'></i> View Details
  </a>
</td>
    </tr>";
      }

      echo "</tbody></table></div>";
    } else {
      echo "<div class='alert alert-info'>You have no appointment history.</div>";
    }
    ?>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>