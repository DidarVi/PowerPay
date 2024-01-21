<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PowerPay Customer Service</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border: 1px solid #007BFF;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 123, 255, 0.2);
        }

        h2, p {
            color: #007BFF;
            margin-bottom: 15px;
        }

        .contact-info {
            text-align: left;
            margin-top: 20px;
        }

        .contact-info p {
            margin: 12px 0;
        }

        a {
            color: #007BFF;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .contact-info p strong {
            color: #333;
        }

        .highlight {
            background-color: #007BFF;
            color: #fff;
            padding: 8px 12px;
            border-radius: 5px;
            display: inline-block;
        }
        /* Styling for the Admin Dashboard button */
        .admin-dashboard-button-container {
            text-align: center;
            margin-top: 20px;
        }

        .admin-dashboard-button {
            display: inline-block;
            padding: 9px 12px;
            margin-right: 10px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }

        .admin-dashboard-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="logo-container">
    <img class="logo" src="powerpay_img.png" alt="Logo">
</div>
    <div class="container">
        <h2>24/7 at Your Service</h2>
        <p>Dedicated PowerPay representatives are available 24/7 via 163**, Live Chat & Facebook. You can also take e-Appointments or email at <a href="mailto:support@powerpay.com">support@powerpay.com</a>.</p>

        <div class="contact-info">
            <h3>Contact Information:</h3>
            <p><strong>Call:</strong> 163**</p>
            <p><strong>Live Chat:</strong> Visit our website</p>
            <p><strong>Facebook:</strong> <a href="https://www.facebook.com" target="_blank">PowerPay Facebook Page</a></p>
            <p><strong>Email:</strong> <a href="mailto:support@powerpay.com">support@powerpay.com</a></p>
        </div>
    </div>
    <div class="admin-dashboard-button-container">
        <a class="admin-dashboard-button" href="user_dashboard.php">Back to Dashboard</a>
        <button id="sign-out-btn" onclick="location.href='user_logout.php'">Sign Out</button>
    </div>
</body>
</html>
