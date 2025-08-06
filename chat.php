<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 5) {
    header('Location: ../login.html');
    exit();
}

require_once '../connection.php';

// Handle form submission
if (isset($_POST['question-text']) && !empty(trim($_POST['question-text']))) {
    $question = $_POST['question-text'];
    $patient_id = $_SESSION['id'];

    $query = "INSERT INTO chat_with_us (question, patient_id, Status) VALUES ('$question', $patient_id, 'Pending')";
    if ($conn->query($query)) {
        header("Location: chat.php");
        exit();
    } else {
        echo "<script>alert('Failed to send question!'); window.location.href='chat.php';</script>";
        exit();
    }
}

// Get all chat questions by the patient
$patient_id = $_SESSION['id'];
$query = "SELECT * FROM chat_with_us WHERE patient_id = $patient_id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat with Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
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

        /* Form Styles */
        .form-container {
            background-color: var(--text-light);
            border-radius: var(--border-radius);
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: var(--box-shadow);
        }

        .form-container h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .form-container label {
            font-weight: 500;
            margin-bottom: 0.25rem;
            display: block;
        }

        .form-container textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            transition: border-color var(--transition-duration);
            resize: none;
            min-height: 100px;
        }

        .form-container textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .form-container .btn {
            margin-top: 1rem;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            transition: background-color var(--transition-duration), color var(--transition-duration);
            font-weight: 500;
            border: none;
            cursor: pointer;
        }

        .form-container .btn-primary {
            background-color: var(--primary-color);
            color: var(--text-light);
        }

        .form-container .btn-primary:hover {
            background-color: var(--primary-dark);
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
            vertical-align: middle;
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
            margin: 0.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
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

        .table td .btn-danger {
            background-color: #dc3545;
            color: var(--text-light);
        }

        .table td .btn-danger:hover {
            background-color: #c82333;
        }

        .table td .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--text-dark);
        }

        .table td .btn-secondary:hover {
            background-color: #d3d3d3;
        }

        .table td .btn-primary {
            background-color: var(--primary-color);
            color: var(--text-light);
        }

        .table td .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .table td i {
            margin-right: 0;
            font-size: 1rem;
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

            .form-container {
                padding: 1.5rem;
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

            .form-container {
                padding: 1rem;
            }

            .table td button {
                padding: 0.25rem 0.5rem;
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
                        <a class="nav-link active" href="chat.php">Chat with Us</a>
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
        <div class="form-container">
            <h2>Ask Us a Question</h2>
            <form id="question-form" method="post" action="">
                <label for="question-text">Your Question:</label>
                <textarea id="question-text" name="question-text" class="form-control"
                    placeholder="Enter your question here..."></textarea>
                <button type="submit" class="btn btn-primary">Send Question</button>
            </form>
        </div>
        <?php if ($result->num_rows > 0): ?>
            <div class='table-container mt-4'>
                <table class='table table-striped table-bordered'>
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Status</th>
                            <th>Response</th>
                            <th>Edit</th>
                            <th>Cancel</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['question'] ?></td>
                                <td><?= $row['Status'] ?></td>
                                <td><?= $row['response'] ?></td>
                                <td>
                                    <?php if ($row['Status'] === 'Pending'): ?>
                                        <a href='edit_question.php?id=<?= $row['id'] ?>' class='btn btn-sm btn-primary'>
                                            <i class='fas fa-edit me-1'></i> Edit
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['Status'] === 'Pending'): ?>
                                        <a href='cancel-question.php?id=<?= $row['id'] ?>'
                                            class='btn btn-sm btn-warning text-white'>
                                            <i class='fas fa-times-circle me-1'></i> Cancel
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($row['Status'] === 'Answered'): ?>
                                        <a href='delete-question.php?id=<?= $row['id'] ?>' class='btn btn-sm btn-danger'>
                                            <i class='fas fa-trash-alt me-1'></i> Delete
                                        </a>
                                </td>
                            <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center mt-5">
                <h4>No questions asked yet.</h4>
            </div>
        <?php endif; ?>

        </tbody>
        </table>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>