<?php
require_once 'connection.php';

// Check if the login form fields are set and not empty
if (
    isset($_POST['loginUsername']) && !empty($_POST['loginUsername'])
    && isset($_POST['loginPassword']) && !empty($_POST['loginPassword'])
) {
    $username = $_POST['loginUsername'];
    $password = md5($_POST['loginPassword']); // Hash the password with MD5 (consider using stronger encryption like bcrypt)

    // SQL query to check if the username and password match any record in the database
    $sql_login = "SELECT * FROM user WHERE Username = '$username' AND Password = '$password'";
    $result = $conn->query($sql_login);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];

        // Check if the user's status is verified
        if ($status == 'verified') {
            session_start();
            $_SESSION['id'] = $row['ID'];
            $_SESSION['role'] = $row['role_id'];
            $_SESSION['name'] = $row['FullName'];
            $_SESSION['isloggedin'] = 1;

            // Redirect based on user role
            switch ($_SESSION['role']) {
                case '1': // Admin
                    header('Location:Admin/admin-home.php');
                    break;
                case '2': // Doctor
                    header('Location:Doctor/Doctor-home.php');
                    break;
                case '3': // Receptionist
                    header('Location:Receptionest/receptionest-home.php');
                    break;
                case '4': // Pharmacy
                    header('Location:pharmacy/Pharmacy-home.php');
                    break;
                case '5': // Patient
                    header('Location:Patient/patient-home.php');
                    break;
                default:
                    // Default error if role is invalid
                    echo "<script>
                            alert('Invalid role!');
                            window.location.href='login.html';
                          </script>";
                    exit();
            }
        } else {
            // If status is not verified, redirect to login page
            echo "<script>
                    alert('Account not verified. Please check your email for verification.');
                    window.location.href='login.html';
                  </script>";
            exit();
        }
    } else {
        // If no matching user is found
        echo "<script>
                alert('Wrong Username or Password!');
                window.location.href='login.html';
              </script>";
        exit();
    }
}
?>