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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient Home - Medicare Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        :root {
            --primary-color: #0056b3;
            --secondary-color: #17a2b8;
            --light-text-color: #f8f9fa;
            --dark-text-color: #212529;
            --card-bg: rgba(255, 255, 255, 0.8);
            --hover-color: #0056b3;
            --shadow-light: rgba(0, 0, 0, 0.15);
            --shadow-dark: rgba(0, 0, 0, 0.3);
            --accent-color: #ffdd57;
            --transition-duration: 0.3s;
            --carousel-height: 500px;
        }

        /* Base Styling */
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #e0f7fa, #a5f3ff);
            color: var(--dark-text-color);
            margin: 0;
            padding: 0;
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 6px var(--shadow-light);
            padding: 1rem 0;
        }

        /* Logo and Brand Styling */
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            color: inherit;
        }

        .navbar-brand img {
            height: 40px;
            width: 40px;
            object-fit: cover;
            border-radius: 50%;
        }

        .navbar-brand h3 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: bold;
            color: #fff;
        }

        .navbar-brand h3:hover {
            color: #000;
        }

        .navbar-nav .nav-link {
            color: var(--light-text-color) !important;
            font-weight: 500;
            margin: 0 0.75rem;
            transition: color var(--transition-duration);
            display: block;
            /* Ensure proper link styling */
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--accent-color) !important;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='rgba(248,249,250,1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E");
        }

        .navbar-toggler {
            border-color: var(--light-text-color);
        }

        .navbar-toggler:hover,
        .navbar-toggler:focus {
            border-color: var(--accent-color);
        }

        /* Carousel Styling */
        .carousel {
            width: 100%;
            height: var(--carousel-height);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .carousel-inner {
            height: 100%;
        }

        .carousel-item {
            position: absolute;
            inset: 0;
            display: flex;
            /* For centering */
            align-items: center;
            justify-content: center;
            visibility: hidden;
            transition: opacity 1s ease-in-out, transform 1s ease-in-out;
            opacity: 0;
            transform: translateX(100%);
        }

        .carousel-item.active {
            visibility: visible;
            opacity: 1;
            transform: translateX(0);
            z-index: 1;
        }

        .carousel-item.prev {
            transform: translateX(-100%);
        }

        .carousel-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background-color: #f8f9fa;
            transition: transform 0.5s ease;
            display: block;
        }

        .carousel-item:hover img {
            transform: scale(1.05);
        }

        .carousel-caption {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: rgba(255, 255, 255, 0.8);
            color: var(--primary-color);
            padding: 15px 20px;
            border-radius: 10px;
            text-align: left;
            box-shadow: 0 4px 8px var(--shadow-light);
            width: fit-content;
        }

        .carousel-caption h5 {
            font-size: 2rem;
            margin: 0 0 10px;
            font-weight: bold;
        }

        .carousel-caption p {
            font-size: 1.1rem;
            margin: 0;
        }

        .carousel-control-prev,
        .carousel-control-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            justify-content: center;
            width: 10%;
            padding: 0;
            cursor: pointer;
            border: none;
            background: none;
            color: var(--primary-color);
            opacity: 0.5;
            transition: opacity 0.3s ease;
            z-index: 2;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            opacity: 0.9;
        }

        .carousel-control-prev {
            left: 0;
        }

        .carousel-control-next {
            right: 0;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }

        .carousel-control-prev-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%230056b3' viewBox='0 0 8 8'%3E%3Cpath d='M5.25 0l-4 4 4 4 1.5-1.5-2.5-2.5 2.5-2.5-1.5-1.5z'%3E%3C/path%3E%3C/svg%3E");
        }

        .carousel-control-next-icon {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%230056b3' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'%3E%3C/path%3E%3C/svg%3E");
        }

        .carousel-indicators {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            padding: 0;
            margin: 0;
            list-style: none;
            z-index: 2;
        }

        .carousel-indicators li {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.3);
            margin: 0 5px;
            cursor: pointer;
            transition: background-color var(--transition-duration);
        }

        .carousel-indicators li:hover,
        .carousel-indicators li.active {
            background-color: var(--primary-color);
        }

        /* Department Cards Styling */
        .department-card {
            background: var(--card-bg);
            color: var(--dark-text-color);
            border: 1px solid var(--primary-color);
            border-radius: 1rem;
            transition: transform var(--transition-duration), box-shadow var(--transition-duration),
                background-color var(--transition-duration), color var(--transition-duration);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 250px;
            text-align: center;
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
            padding: 25px;
            box-shadow: 0 4px 10px var(--shadow-light);
            cursor: pointer;
        }

        .department-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px var(--shadow-dark);
            background-color: var(--hover-color);
            color: var(--light-text-color);
        }

        .department-card img {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            position: absolute;
            top: 20px;
        }

        .department-card h5 {
            margin-top: 85px;
            font-size: 1.6rem;
            font-weight: bold;
            color: var(--primary-color);
            transition: color var(--transition-duration);
        }

        .department-card p {
            font-size: 1.1rem;
            margin-top: 8px;
            color: var(--secondary-color);
            line-height: 1.5;
            transition: color var(--transition-duration);
        }

        .department-card:hover h5,
        .department-card:hover p {
            color: var(--light-text-color);
        }

        /* Footer Styling */
        .footer {
            background-color: var(--secondary-color);
            color: var(--light-text-color);
            padding: 2.5rem;
            text-align: center;
            border-radius: 10px;
            margin-top: 4rem;
        }

        .footer a {
            color: var(--light-text-color);
            text-decoration: none;
            transition: color var(--transition-duration);
        }

        .footer a:hover {
            color: var(--accent-color);
        }

        /* Responsive Styling */
        @media (max-width: 768px) {
            .carousel {
                height: 300px;
            }

            .carousel-item {
                height: 300px;
            }

            .carousel-item img {
                height: 300px;
            }

            .carousel-caption {
                bottom: 10px;
                left: 10px;
                padding: 10px 15px;
            }

            .carousel-caption h5 {
                font-size: 1.5rem;
            }

            .carousel-caption p {
                font-size: 1rem;
            }

            .department-card {
                height: 200px;
                padding: 15px;
            }

            .department-card h5 {
                font-size: 1.3rem;
            }

            .department-card p {
                font-size: 1rem;
            }

            .navbar-nav .nav-link {
                margin: 0 0.5rem;
            }
        }

        /* Accessibility Enhancements */
        .visually-hidden {
            position: absolute !important;
            width: 1px !important;
            height: 1px !important;
            padding: 0 !important;
            margin: -1px !important;
            overflow: hidden !important;
            clip: rect(0, 0, 0, 0) !important;
            white-space: nowrap !important;
            border: 0 !important;
        }

        .welcome-banner {
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            color: var(--light-text-color);
            box-shadow: 0 4px 8px var(--shadow-dark);
            margin-top: 1rem;
            border-radius: 0 0 1rem 1rem;
            animation: slideIn 1s ease-out;
        }

        .welcome-text {
            margin: 0;
            font-size: 1.8rem;
            font-weight: 600;
            letter-spacing: 1px;
        }

        @keyframes slideIn {
            0% {
                transform: translateY(-20px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="patient-home.php">
                <img src="../images/logo.jpeg" alt="Medicare Hub Logo">
                <h3>MedicareHub</h3>
            </a>
            <div class="welcome-banner text-center py-3">
                <h3 class="welcome-text">Welcome Back <?= $_SESSION['name'] ?></h3>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="appointment-history.php">Appointment History</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="chat.php">Chat with Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="change-password.php">Change Password</a></li>
                    <li class="nav-item"><a class="nav-link" href="../logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
    </div>

    <div class="container">
        <div class="row gy-4 mt-4">
            <div class="col-md-4">
                <a href="cardiologist.php" class="text-decoration-none">
                    <div class="department-card">
                        <img src="../images/cardilogy.jpg" alt="Cardiology">
                        <h5>Cardiology</h5>
                        <p>Heart health and treatments</p>
                        <span class="badge">Featured</span>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="dermatologist.php" class="text-decoration-none">
                    <div class="department-card">
                        <img src="../images/dermatology.jpg" alt="Dermatology">
                        <h5>Dermatology</h5>
                        <p>Skin care and treatments</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="general-surgery.php" class="text-decoration-none">
                    <div class="department-card">
                        <img src="../images/surgery.jpg" alt="General Surgery">
                        <h5>General Surgery</h5>
                        <p>Surgical care for all conditions</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="pediatrics.php" class="text-decoration-none">
                    <div class="department-card">
                        <img src="../images/pediatrics.png" alt="Pediatrics">
                        <h5>Pediatrics</h5>
                        <p>Caring for your child's health</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="orthopedics.php" class="text-decoration-none">
                    <div class="department-card">
                        <img src="../images/orthopedics.avif" alt="Orthopedics">
                        <h5>Orthopedics</h5>
                        <p>Bone and joint care</p>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y') ?> Medicare Hub. All rights reserved. | <a target="_blank" href="privacy-policy.php">Privacy Policy</a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </script>
</body>

</html>