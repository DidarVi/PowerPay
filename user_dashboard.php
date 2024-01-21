<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: user_login.php"); // Redirect to user login page if not logged in
    exit();
}

$hostname = "localhost";
$username = "root";
$password = "";
$database = "powerpay";

// Create a connection to the database
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch user information based on the session variable
$userID = $_SESSION["user_id"];
$query = "SELECT * FROM your_user_table WHERE id = $userID";
$result = mysqli_query($conn, $query);

if ($result) {
    $userInfo = mysqli_fetch_assoc($result);
} else {
    $userInfo = array(); // Set to an empty array if there's an error
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f4;
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

        .info-container,
        .services-container {
            max-width: 600px;
            margin: 8px auto;
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 15px;
        }

        h3 {
            color: #3498db;
            border-bottom: 2px solid #3498db;
            padding-bottom: 8px;
            margin-bottom: 13px;
        }

        p {
            margin: 8px 0;
        }

        .feature-boxes {
            display: flex;
            justify-content: space-between;
        }

        .feature-box {
            flex: 1;
            padding: 12px;
            border: 1px solid #3498db;
            border-radius: 8px;
            text-align: center;
            margin: 0 5px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        #sign-out-btn {
            background-color: #e74c3c;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 12px;
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $userInfo["username"]; ?></h2>

    <div class="info-container">
        <h3>Your Information</h3>
        <p>Age: <?php echo $userInfo["age"]; ?></p>
        <p>Gender: <?php echo $userInfo["gender"]; ?></p>
        <p>Phone: <?php echo $userInfo["phone"]; ?></p>
        <p>Address: <?php echo $userInfo["address"]; ?></p>
        <p>Meter No: <?php echo $userInfo["meter_no"]; ?></p>
        <p>Meter Type: <?php echo $userInfo["meter_type"]; ?></p>
    </div>

    <div class="services-container">
        <h3>Services</h3>
        <div class="info-container">
        <div class="feature-boxes">
            <div class="feature-box" style="background-color: #3498db;">
                <a href="update_user_info.php" style="color: #fff;">Update User Info</a>
            </div>
            <div class="feature-box" style="background-color: #2980b9;">
                <a href="view_bill.php" style="color: #fff;">View Bill</a>
            </div>
            <div class="feature-box" style="background-color: #1f6690;">
                <a href="pay_bill.php" style="color: #fff;">Pay Bill</a>
            </div>
            <div class="feature-box" style="background-color: #155575;">
                <a href="bill_manual.php" style="color: #fff;">Bill Manual</a>
            </div>
            <div class="feature-box" style="background-color: #0e3c52;">
                <a href="services.php" style="color: #fff;">Help & Services</a>
            </div>
        </div>
    </div>

        </div>
        

    <form method="post" action="user_logout.php">
        <button id="sign-out-btn" type="submit">Sign Out</button>
    </form>
</body>
</html>
