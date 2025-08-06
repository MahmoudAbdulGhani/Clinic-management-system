<?php
session_start();
if ($_SESSION['role'] != 3 || $_SESSION['isloggedin'] != 1) {
    header('Location:../login.html');
    exit();
}

require_once '../connection.php';

if (
    isset($_POST['doctorID'], $_POST['date'], $_POST['startTime'], $_POST['endTime'], $_POST['status']) &&
    !empty($_POST['doctorID']) &&
    !empty($_POST['date']) &&
    !empty($_POST['startTime']) &&
    !empty($_POST['endTime']) &&
    !empty($_POST['status'])
) {
    // Escape user inputs
    $doctorID = $_POST['doctorID'];
    $date = $_POST['date'];
    $dayOfWeek = date('l', strtotime($date)); // e.g., 'Monday'
    $recep_id = $_SESSION['id'];
    // Check if the doctor is available on this day
    $sql_schedule = "SELECT * FROM schedule WHERE DoctorID = '$doctorID' AND DayOfWeek = '$dayOfWeek'";
    $schedule_result = $conn->query($sql_schedule);

    if ($schedule_result->num_rows == 0) {
        echo "<script>alert('Doctor is not available on $dayOfWeek.'); window.history.back();</script>";
        exit();
    }

    $startTime = $_POST['startTime'];
    $endTime = $_POST['endTime'];
    $status = $_POST['status'];

    // Check if end time is after start time
    if ($endTime <= $startTime) {
        echo "<script>alert('End time must be after start time.'); window.history.back();</script>";
        exit();
    }

    // Prevent past date appointments
    if ($date < date('Y-m-d')) {
        echo "<script>alert('Cannot book an appointment in the past.'); window.history.back();</script>";
        exit();
    }

    // Check for time overlap
    $sql_check = "SELECT * FROM appointment 
                  WHERE DoctorID = '$doctorID' 
                  AND appointment_date = '$date'
                  AND NOT (
                      appointment_endTime <= '$startTime' 
                      OR appointment_startTime >= '$endTime'
                  )";
    $result = $conn->query($sql_check);

    if ($result && $result->num_rows > 0) {
        echo "<script>alert('This time slot overlaps with an existing appointment.'); window.history.back();</script>";
        exit();
    }

    // Fetch the doctor's name
    $sql_doctor = "SELECT doctor_name, Specialization FROM doctor WHERE UserID = '$doctorID'";
    $result = $conn->query($sql_doctor);
    $row_result = $result->fetch_assoc();
    $doctor_name = $row_result['doctor_name'];
    $department = $row_result['Specialization'];


    // Insert the new appointment offer
    $sql_insert = "INSERT INTO appointment (DoctorID, recep_id, department,appointment_date, doctor_name, DayOfWeek, appointment_startTime, appointment_endTime, Status)
                   VALUES ('$doctorID', '$recep_id', '$department','$date', '$doctor_name', '$dayOfWeek', '$startTime', '$endTime', '$status')";

    if ($conn->query($sql_insert)) {
        echo "<script>alert('Appointment offer added successfully.'); window.location.href='appointments.php';</script>";
    } else {
        echo "<script>alert('Error adding appointment offer.');</script>";
    }
}

// Fetch doctors
$sql_doctors = "SELECT UserID, doctor_name, Specialization FROM doctor";
$doctors = $conn->query($sql_doctors);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Appointment Offer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
</head>

<body>
    <div class="container mt-5">
        <div class="card p-4 shadow">
            <h2 class="mb-4 text-center text-primary">Add Appointment Offer</h2>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="doctorID" class="form-label">Select Doctor</label>
                    <select name="doctorID" id="doctorID" class="form-select" required>
                        <option value="">-- Select Doctor --</option>
                        <?php while ($doc = $doctors->fetch_assoc()): ?>
                            <option value="<?= $doc['UserID'] ?>"><?= $doc['doctor_name'] . "-Department: " . $doc['Specialization'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                    <div id="dayDisplay" class="text-muted mt-1"></div>
                </div>

                <div class="mb-3">
                    <label for="startTime" class="form-label">Start Time</label>
                    <input type="time" name="startTime" id="startTime" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="endTime" class="form-label">End Time</label>
                    <input type="time" name="endTime" id="endTime" class="form-control" required>
                </div>

                <input type="hidden" name="status" value="Available">

                <div class="d-flex justify-content-between">
                    <button type="submit" name="submit" class="btn btn-primary">Add Offer</button>
                    <a href="appointments.php" class="btn btn-secondary">Back</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('date').addEventListener('change', function () {
            const date = new Date(this.value);
            if (!isNaN(date.getTime())) {
                const options = { weekday: 'long' };
                const dayName = date.toLocaleDateString('en-US', options);
                document.getElementById('dayDisplay').textContent = 'Selected Day: ' + dayName;
            } else {
                document.getElementById('dayDisplay').textContent = '';
            }
        });
    </script>
</body>

</html>