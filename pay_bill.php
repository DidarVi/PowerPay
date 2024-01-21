<?php
// Your payment processing logic goes here
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Process the payment (dummy logic)
    $paymentStatus = "success"; // You can replace this with your actual payment processing

    // Display a message based on the payment status
    $paymentMessage = ($paymentStatus === "success") ? "Payment successful!" : "Payment failed. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pay Bill</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #3498db;
            margin-bottom: 15px;
        }

        .payment-container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        p {
            margin: 10px 0;
        }

        #pay-btn {
            background-color: #3498db;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        #payment-message {
            margin-top: 20px;
            font-weight: bold;
            text-align: center;
            color: #3498db;
        }
        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #2980b9;
        }

        #back-btn {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0px;
            text-decoration: none;
            display: inline-block;
        }

        #back-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
<div class="logo-container">
    <img class="logo" src="powerpay_img.png" alt="Logo">
</div>
    <h2>Pay Your Bill</h2>
    

    <?php if (isset($paymentMessage)) : ?>
        <p id="payment-message"><?php echo $paymentMessage; ?></p>
    <?php else : ?>
        <div class="payment-container">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <p>Enter your payment details:</p>
                <!-- Add your payment form fields here (e.g., card number, expiration date, CVV) -->

                <button id="pay-btn" type="submit">Pay Now</button>
            </form>
        </div>
    <?php endif; ?>
    <a href="user_dashboard.php" id="back-btn">Back to Dashboard</a>
    <a href="user_logout.php" id="sign-out-btn">Sign Out</a>
</body>
</html>
