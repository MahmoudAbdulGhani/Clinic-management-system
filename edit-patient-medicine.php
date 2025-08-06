<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 4) {
    header('Location:../login.html');
    exit();
}

require_once '../connection.php';

// Get the ID of the record to edit
$medicine_id = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($medicine_id)) {
    header('Location: view-patient-medicine.php');
    exit();
}

// Fetch the existing data for this medicine record
$sql = "SELECT pm.*, p.patient_name, d.doctor_name
        FROM patient_medicine pm
        LEFT JOIN patient p ON pm.patient_id = p.UserID
        LEFT JOIN doctor d ON pm.doctor_id = d.UserID
        WHERE pm.id = '$medicine_id'";

$result = $conn->query($sql);
$medicine = $result->fetch_assoc();

if (!$medicine) {
    header('Location: view-patient-medicine.php');
    exit();
}

// Process form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get updated data from the form
    $medication = $_POST['medication'];
    $quantity = $_POST['quantity'];
    $note = $_POST['note'];
    $status = $_POST['status'];
    $cancelation_reason = $_POST['cancelation_reason'];
    $pharmacist_id = $_SESSION['id'];
    $pharmacist_name = $_SESSION['name'];
    // If the status is being changed from 'Completed' or 'Cancelled'
    if (($medicine['Status'] == 'Completed' || $medicine['Status'] == 'Cancelled') && $status != $medicine['Status']) {
        // Fetch the current stock of the medicine
        $sql_stock = "SELECT stock FROM medicines WHERE name = '$medication'";
        $result_stock = $conn->query($sql_stock);

        if ($result_stock->num_rows > 0) {
            $stock = $result_stock->fetch_assoc();
            $current_stock = $stock['stock'];

            // If the status is 'Cancelled' or 'Deleted', return the quantity to stock
            if ($status == 'Cancelled' || $status == 'Deleted') {
                // Only add to stock if current stock is greater than 0
                if ($current_stock > 0) {
                    $new_stock = $current_stock + $medicine['quantity']; // Add the quantity back to stock
                    $sql_update_stock = "UPDATE medicines SET stock = '$new_stock' WHERE name = '$medication'";
                    $conn->query($sql_update_stock);
                }
            }
        } else {
            $error_message = "Medicine not found in the stock list.";
        }
    }

    // Update patient medicine record
    $update_sql = "UPDATE patient_medicine
                   SET Medication = '$medication',
                       quantity = '$quantity',
                       note = '$note',
                       Status = '$status',
                       cancelation_reason = '$cancelation_reason',
                       pharmacist_id = '$pharmacist_id', pharmacist_name = '$pharmacist_name'
                   WHERE id = '$medicine_id'";

    if ($conn->query($update_sql) === TRUE) {
        // If status is changed to 'Completed', subtract quantity from stock
        if ($status == 'Completed') {
            // Fetch the current stock of the medicine
            $sql_stock = "SELECT stock FROM medicines WHERE name = '$medication'";
            $result_stock = $conn->query($sql_stock);

            if ($result_stock->num_rows > 0) {
                $stock = $result_stock->fetch_assoc();
                $new_stock = $stock['stock'] - $quantity;

                // Ensure we don't end up with negative stock
                if ($new_stock >= 0) {
                    // Update the stock in the medicine table
                    $sql_update_stock = "UPDATE medicines SET stock = '$new_stock' WHERE name = '$medication'";
                    $conn->query($sql_update_stock);
                } else {
                    // Handle stock quantity issue (for example, show an error or do not update)
                    $error_message = "Not enough stock available for this medicine.";
                }
            } else {
                $error_message = "Medicine not found in the stock list.";
            }
        }

        header('Location: view-patient-medicine.php');
        exit();
    } else {
        $error_message = "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient Medicine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Patient Medicine</h2>
        <?php if (isset($error_message)) {
            echo "<div class='alert alert-danger'>$error_message</div>";
        } ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="patient_name" class="form-label">Patient Name</label>
                <input type="text" class="form-control" id="patient_name"
                    value="<?php echo $medicine['patient_name']; ?>" disabled>
            </div>

            <div class="mb-3">
                <label for="doctor_name" class="form-label">Doctor Name</label>
                <input type="text" class="form-control" id="doctor_name" value="<?php echo $medicine['doctor_name']; ?>"
                    disabled>
            </div>

            <div class="mb-3">
                <label for="medication" class="form-label">Medicine Name</label>
                <input type="text" class="form-control" id="medication" name="medication"
                    value="<?php echo $medicine['Medication']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity"
                    value="<?php echo $medicine['quantity']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <textarea class="form-control" id="note" name="note"
                    rows="3"><?php echo $medicine['note']; ?></textarea>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Cancelled" <?php echo $medicine['Status'] == 'Cancelled' ? 'selected' : ''; ?>>
                        Cancelled
                    </option>
                    <option value="Completed" <?php echo $medicine['Status'] == 'Completed' ? 'selected' : ''; ?>>
                        Completed
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="cancelation_reason" class="form-label">Cancelation Reason (if any)</label>
                <textarea class="form-control" id="cancelation_reason" name="cancelation_reason"
                    rows="3"><?php echo $medicine['cancelation_reason']; ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Medicine</button>
            <a href="view-patient-medicine.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>