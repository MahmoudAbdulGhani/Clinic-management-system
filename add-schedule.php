<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $doctor_id = $_POST['doctor_id'];
    $day_of_week = $_POST['day_of_week'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $status = $_POST['status'];

    // Check if a schedule already exists for this doctor on the selected day
    $check_sql = "SELECT * FROM schedule WHERE DoctorID = '$doctor_id' AND DayOfWeek = '$day_of_week'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "<script>
                alert('A schedule for $day_of_week already exists for this doctor.');
                window.location.href = 'add-schedule.php?id=$doctor_id';
              </script>";
    } else {
        // Insert the new schedule
        $sql = "INSERT INTO schedule (DoctorID, DayOfWeek, StartTime, EndTime, status) 
                VALUES ('$doctor_id', '$day_of_week', '$start_time', '$end_time', '$status')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Schedule added successfully.');
                    window.location.href = 'doctor-schedule.php?id=$doctor_id';
                  </script>";
        } else {
            echo "<script>
                    alert('Error adding schedule: " . $conn->error . "');
                  </script>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Schedule - Medicare Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
</head>

<body>
    <div class="container">
        <h2 class="my-4">Add Schedule for Doctor</h2>
        <?php
        if (isset($_GET['id'])) {
            $doctor_id = $_GET['id'];

            // Get the doctor's full name to display it on the page
            $sql = "SELECT FullName FROM user WHERE ID = '$doctor_id'";
            $result = $conn->query($sql);
            $doctor = $result->fetch_assoc();
            echo "<h4>Schedule for Dr. " . htmlspecialchars($doctor['FullName']) . "</h4>";
        }
        ?>

        <form method="POST" action="add-schedule.php">
            <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">

            <div class="mb-3">
                <label for="day_of_week" class="form-label">Day of the Week</label>
                <select class="form-select" name="day_of_week" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" name="start_time" required>
            </div>

            <div class="mb-3">
                <label for="end_time" class="form-label">End Time</label>
                <input type="time" class="form-control" name="end_time" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" name="status" required>
                    <option value="Available">Available</option>
                    <option value="Unavailable">Unavailable</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Schedule</button>
            <a href="doctor-schedule.php?id=<?php echo $doctor_id; ?>" class="btn btn-secondary">Back</a>
        </form>
    </div>
</body>

</html>