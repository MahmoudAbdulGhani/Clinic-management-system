<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Email Verified</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="shortcut icon" href="images/logo.jpeg" type="image/x-icon">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: url('img/cover.jpg') no-repeat center center / cover;
      min-height: 100vh;
      font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .container {
      background: linear-gradient(145deg, rgba(255, 255, 255, 0.95), rgba(240, 240, 240, 0.95));
      backdrop-filter: blur(10px);
      padding: 40px;
      border-radius: 20px;
      text-align: center;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      max-width: 400px;
      width: 90%;
      border: 1px solid rgba(255, 255, 255, 0.7);
    }

    .checkmark {
      width: 80px;
      height: 80px;
      display: inline-block;
      animation: fadeInUp 0.5s ease forwards;
      margin-bottom: 20px;
    }

    .checkmark:hover {
      transform: scale(1.1);
      transition: transform 0.3s ease;
    }

    .checkmark-circle {
      stroke-dasharray: 166;
      stroke-dashoffset: 166;
      stroke-width: 4;
      stroke: #28a745;
      fill: none;
      animation: strokeCircle 0.6s ease forwards;
    }

    .checkmark-check {
      stroke-dasharray: 48;
      stroke-dashoffset: 48;
      stroke-width: 4;
      stroke: #28a745;
      fill: none;
      animation: drawCheck 0.6s ease forwards 0.4s;
    }

    .success-message {
      font-size: 20px;
      font-weight: 500;
      color: #333;
      margin-bottom: 25px;
      animation: fadeIn 0.6s ease forwards 0.7s;
    }

    .login-link {
      display: inline-block;
      padding: 12px 24px;
      background: linear-gradient(145deg, #4caf50, #388e3c);
      color: white;
      text-decoration: none;
      font-size: 16px;
      border-radius: 25px;
      transition: background 0.3s ease, transform 0.3s ease;
    }

    .login-link:hover {
      background: linear-gradient(145deg, #45a049, #2e7d32);
      transform: translateY(-2px);
    }

    .login-link i {
      margin-left: 8px;
      transition: transform 0.3s ease;
    }

    .login-link:hover i {
      transform: translateX(5px);
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes strokeCircle {
      to {
        stroke-dashoffset: 0;
      }
    }

    @keyframes drawCheck {
      to {
        stroke-dashoffset: 0;
      }
    }

    @keyframes fadeIn {
      to {
        opacity: 1;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52" aria-label="Verification Successful">
      <circle class="checkmark-circle" cx="26" cy="26" r="25" />
      <path class="checkmark-check" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
    </svg>

    <p class="success-message">Email Verification Successful!</p>

    <a href="login.html" class="login-link">
      Proceed to Login <i class="fas fa-arrow-right"></i>
    </a>
  </div>
</body>

</html>