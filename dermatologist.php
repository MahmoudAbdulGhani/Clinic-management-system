<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 5) {
  header('Location:../login.html');
  exit();
}
require_once '../connection.php';
$search_query = '';
if (isset($_POST['search']) && !empty($_POST['search_query'])) {
  $search_query = $_POST['search_query'];
  $sql_select = "SELECT * FROM appointment, doctor WHERE DoctorID = UserID AND Specialization = 'Dermatology' AND status = 'Available' AND doctor.doctor_name LIKE '%$search_query%'";
} else {
  $sql_select = "SELECT * FROM appointment, doctor WHERE DoctorID = UserID AND Specialization = 'Dermatology' AND status = 'Available'";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dermatology Details and Appointment</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
    integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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

    /* Search Input Styles */
    .search-container {
      display: flex;
      margin: 1rem 0;
      align-items: center;
      /* Vertically align items */
    }

    .search-container input {
      border-radius: var(--border-radius) 0 0 var(--border-radius);
      flex: 1;
      /* Allow input to take up available space */
      max-width: 200px;
      /* Make the input smaller */
    }

    .search-container button {
      background-color: var(--primary-color);
      border: none;
      color: var(--text-light);
      padding: 0.5rem 0.75rem;
      border-radius: 0 var(--border-radius) var(--border-radius) 0;
      cursor: pointer;
      transition: background-color var(--transition-duration);
      width: 2.5rem;
      /* Make the button smaller */
      height: 2.5rem;
      display: flex;
      /* Use flexbox for centering */
      align-items: center;
      justify-content: center;
    }

    .search-container button:hover {
      background-color: var(--primary-dark);
    }

    .search-container button i {
      font-size: 1rem;
    }

    .form-control:focus {
      border-color: var(--primary-color);
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Table Styles */
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
      text-align: center;
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
      text-align: center;
    }

    .table td a {
      background-color: var(--accent-color);
      color: var(--text-dark);
      border: none;
      padding: 0.5rem 1rem;
      border-radius: var(--border-radius);
      cursor: pointer;
      transition: background-color var(--transition-duration), color var(--transition-duration);
      font-weight: 500;
      text-decoration: none;
      /* Remove underline */
    }

    .table td a:hover {
      background-color: #ffdb58;
      transform: translateY(-2px);
    }

    .table td button:disabled {
      background-color: #cccccc;
      color: #666666;
      cursor: not-allowed;
      transform: none;
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
    }

    .no-appointments {
      text-align: center;
      padding: 3rem 1rem;
      background-color: var(--text-light);
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      margin-top: 2rem;
      animation: fadeIn 1s ease-in-out;
    }

    .no-appointments h1 {
      color: var(--primary-color);
      font-weight: 700;
      margin-bottom: 1rem;
    }

    .no-appointments p {
      font-size: 1.1rem;
      color: var(--text-dark);
      margin-bottom: 1.5rem;
    }

    .no-appointments i {
      font-size: 4rem;
      color: var(--accent-color);
      animation: heartbeat 1.5s infinite;
    }

    /* Fade-in effect */
    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(30px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Heartbeat animation */
    @keyframes heartbeat {

      0%,
      100% {
        transform: scale(1);
      }

      25% {
        transform: scale(1.2);
      }

      50% {
        transform: scale(1);
      }

      75% {
        transform: scale(1.2);
      }
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
            <a class="nav-link" href="../logout.php">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="search-container">
      <form action="" method="post" class="d-flex" style="gap: 0;">
        <input type="text" id="search" name="search_query" class="form-control rounded-start"
          value="<?php echo isset($_POST['search_query']) ? $_POST['search_query'] : '' ?>"
          placeholder="Search for doctors...">
        <button type="submit" name="search" id="search-button" class="btn btn-primary rounded-end">
          <i class="fas fa-search"></i>
        </button>
      </form>
    </div>
    <?php
    $result = $conn->query($sql_select);
    if ($result->num_rows > 0) {
      echo "<div class='table-container'>
      <table class='table'>
        <thead>
          <tr>
            <th>Doctor Name</th>
            <th>Date</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead><tbody>";
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
        <td>" . $row['doctor_name'] . "</td>
        <td>" . $row['appointment_date'] . "</td>
        <td>" . $row['appointment_startTime'] . "</td>
        <td>" . $row['appointment_endTime'] . "</td>
        <td>" . $row['Status'] . "</td>
        <td><a href='dermatologisttAPPointment.php?id=" . $row['AppointmentID'] . "' class='btn btn-primary'>Select</a></td>
      </tr>";
      }
      echo "</tbody>
      </table>
      </div>";
    } else {
      echo "
<div class='no-appointments'>
  <i class='fas fa-heartbeat'></i>
  <h1>No Available Appointments</h1>
  <p>We're sorry, but there are currently no cardiology appointments available. Please check back later or contact support.</p>
</div>
";
    }
    ?>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>