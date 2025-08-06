<?php
session_start();
if ($_SESSION['isloggedin'] != 1 || $_SESSION['role'] != 5) {
    header('Location:../login.html');
    exit();
}

require_once '../connection.php';

if (isset($_POST['question-text']) && !empty('question-text') && isset($_GET['id'])) {
    $question = $conn->real_escape_string($_POST['question-text']);
    $id = $_GET['id'];
    $sql_update = "UPDATE chat_with_us SET question = '$question' WHERE id = $id";

    if ($conn->query($sql_update) === TRUE) {
        header("Location: chat.php");
        exit();
    } else {
        echo "<script>alert('Failed To Edit Question!'); window.location.href = 'chat.php';</script>";
    }
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT question FROM chat_with_us WHERE id = $id");

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $existing_question = $row['question'];
    } else {
        echo "<script>alert('Question not found.'); window.location.href = 'chat.php';</script>";
        exit();
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href = 'chat.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Question</title>
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
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

        .container {
            margin-top: 2rem;
        }

        h1 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        form {
            background-color: var(--text-light);
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--box-shadow);
        }

        label {
            font-weight: 500;
            margin-bottom: 0.25rem;
            display: block;
        }

        textarea {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            transition: border-color var(--transition-duration);
            resize: none;
            min-height: 120px;
        }

        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            color: var(--text-light);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color var(--transition-duration);
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            color: var(--text-dark);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            cursor: pointer;
            transition: background-color var(--transition-duration);
            font-weight: 500;
            margin-left: 1rem;
        }

        .btn-secondary:hover {
            background-color: #d3d3d3;
        }

        @media (max-width: 768px) {
            form {
                padding: 1rem;
            }

            .btn-secondary {
                margin-left: 0;
                margin-top: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Edit Question</h1>
        <form id="edit-question-form" method="post">
            <label for="question-text">Your Question:</label>
            <textarea id="question-text" name="question-text" class="form-control"
                placeholder="Enter your question here..."><?= $row['question'] ?></textarea>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="chat.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>