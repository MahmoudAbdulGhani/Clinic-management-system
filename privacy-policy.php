<?php
session_start();
if ($_SESSION['role'] != 5 || $_SESSION['isloggedin'] != 1) {
    header("Location: ../login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Privacy Policy - Medicare Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" href="../images/logo.jpeg" type="image/x-icon">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            padding: 2rem;
            color: #333;
        }

        .policy-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 2rem 3rem;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1,
        h2 {
            color: #0d6efd;
            margin-bottom: 1rem;
        }

        p,
        li {
            font-size: 1rem;
            line-height: 1.6;
        }

        ul {
            margin-left: 1.25rem;
            margin-bottom: 1.5rem;
        }

        footer {
            text-align: center;
            margin-top: 3rem;
            color: #666;
            font-size: 0.9rem;
        }

        a {
            color: #0d6efd;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="policy-container">
        <h1>Privacy Policy</h1>
        <p><strong>Effective Date:</strong> May 24, 2025</p>

        <p>At <strong>MedicareHub</strong>, we respect your privacy and are committed to protecting your personal and health information. This Privacy Policy explains how we collect, use, and safeguard your information when you use our services.</p>

        <h2>Information We Collect</h2>
        <p>We collect information that you provide directly to us, including but not limited to:</p>
        <ul>
            <li>Personal details such as your name, contact information, and date of birth</li>
            <li>Medical history, treatment details, and medications</li>
            <li>Appointment scheduling and billing information</li>
            <li>Communication records (emails, messages)</li>
            <li>Information collected through website usage (cookies)</li>
        </ul>

        <h2>How We Use Your Information</h2>
        <p>Your information is used to:</p>
        <ul>
            <li>Provide and manage your medical care and services</li>
            <li>Schedule and confirm appointments</li>
            <li>Process billing and insurance claims</li>
            <li>Communicate with you regarding your healthcare</li>
            <li>Improve our services and comply with legal requirements</li>
        </ul>

        <h2>How We Protect Your Information</h2>
        <p>We implement appropriate security measures, including encryption and access controls, to safeguard your data. Our staff is trained to handle your information confidentially.</p>

        <h2>Sharing Your Information</h2>
        <p>We may share your information with:</p>
        <ul>
            <li>Healthcare providers involved in your care</li>
            <li>Insurance companies for billing purposes</li>
            <li>Authorized third parties as required by law</li>
        </ul>
        <p>We do not sell or rent your personal information.</p>

        <h2>Your Rights</h2>
        <p>You have the right to:</p>
        <ul>
            <li>Access and request corrections to your data</li>
            <li>Request restrictions on how we use your information</li>
            <li>Withdraw consent where applicable</li>
            <li>Contact us for any privacy concerns</li>
        </ul>

        <h2>Data Retention</h2>
        <p>We retain your information for as long as necessary to provide services and comply with legal obligations.</p>

        <h2>Changes to This Policy</h2>
        <p>We may update this policy occasionally. We will notify you of any important changes through our website or direct communication.</p>

        <h2>Contact Us</h2>
        <p>If you have any questions or concerns about this Privacy Policy, please contact us:</p>
        <p><strong>Medicare Hub</strong><br />
            Email: <a href="mailto:support@medicarehub.com">support@medicarehub.com</a><br />
            Phone: +96170463012</p>
    </div>

    <footer>
        &copy; <?php echo date("Y"); ?> Medicare Hub. All rights reserved.
    </footer>
</body>

</html>