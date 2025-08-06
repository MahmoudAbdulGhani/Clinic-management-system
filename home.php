<?php
require_once 'connection.php';
if (
    isset($_POST['contact-usName']) && !empty($_POST['contact-usName'])
    && isset($_POST['contact-usEmail']) && !empty($_POST['contact-usEmail'])
    && isset($_POST['contact-usMessage']) && !empty($_POST['contact-usMessage'])
) {
    $name = ucwords($_POST['contact-usName']);
    $email = $_POST['contact-usEmail'];
    $message = $_POST['contact-usMessage'];
    $sql = "INSERT INTO `contact_us`(`name`, `email`, `message`) VALUES ('$name','$email','$message')";
    if ($conn->query($sql)) {
        echo "<script>
        alert('Message Sent We will Send You An Email As Soon As Possible');
        window.location.href='home.php';
        </script>";
    } else {
        echo "<script>
        alert('Something Went Wrong Try Again Later');
        window.location.href='home.php';
        </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Medicare Hub - Clinic Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="images/logo.jpeg" type="image/x-icon" />
    <style>
        body {
            padding-bottom: 200px;
            scroll-behavior: smooth;
        }

        .nav-link {
            text-decoration: none !important;
        }

        .nav-link.active {
            font-weight: bold;
            color: #0d6efd !important;
            border-bottom: 2px solid #0d6efd;
        }

        footer {
            background-color: #f8f9fa;
            padding: 20px 0;
            text-align: center;
        }
    </style>

</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#welcome">
                <img src="images/logo.jpeg" alt="Medicare Hub Logo" width="40" height="40" class="rounded-circle" />
                <span class="fs-4 fw-bold mb-0 text-primary">MedicareHub</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="#welcome">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Welcome Section -->
    <section id="welcome" class="container text-center mt-5 pt-5">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1>Welcome to Medicare Hub</h1>
                <p>Your trusted partner in healthcare management.</p>
                <a href="#about" class="btn btn-primary mt-3">Learn More</a>
            </div>
            <div class="col-md-6">
                <img src="images/welcoming.png" alt="Welcome Image" class="img-fluid" />
            </div>
        </div>
    </section>

    <!-- About Us Section -->
    <section id="about" class="container text-center mt-5">
        <h2>About Us</h2>
        <div class="row align-items-center">
            <div class="col-md-6 about-text">
                <p>🔍 <strong>Best Doctors</strong> – Highly skilled professionals providing top-quality care.</p>
                <p>📅 <strong>Hassle-Free Appointments</strong> – Easily book and manage your visits.</p>
                <p>💊 <strong>Free Medicine</strong> – Eligible patients receive essential medications at no cost.</p>
                <p>💰 <strong>Affordable Services</strong> – Quality healthcare at the lowest consultation fees.</p>
                <p>🩺 <strong>Your health, our priority!</strong></p>
            </div>
            <div class="col-md-6">
                <img src="images/About Us.png" alt="About Us Image" class="img-fluid" />
            </div>
        </div>
    </section>

    <!-- Contact Us Section -->
    <section id="contact" class="container text-center mt-5">
        <h2>Contact Us</h2>
        <div class="row">
            <div class="col-md-6 contact-info">
                <p><i class="fas fa-envelope"></i> medicare.support@gmail.com</p>
                <p><i class="fas fa-phone"></i> +123 456 7890</p>
            </div>
            <div class="col-md-6">
                <form action="" method="post">
                    <div class="form-group mb-3">
                        <input type="text" class="form-control" placeholder="Your Name" name="contact-usName"
                            required />
                    </div>
                    <div class="form-group mb-3">
                        <input type="email" class="form-control" placeholder="Your Email" name="contact-usEmail"
                            required />
                    </div>
                    <div class="form-group mb-3">
                        <textarea class="form-control" rows="4" placeholder="Your Message" name="contact-usMessage"
                            required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center mt-5 py-3 bg-light border-top">
        <p style="color: #000;" class="mb-0">&copy; <?= date('Y'); ?> Medicare Hub. All Rights Reserved.</p>

    </footer>


    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>

</html>