<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION["adminid"])) {
    header("Location: admin_login.php"); // Redirect to login page if not logged in
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

// Fetch admin information based on the session variable
$adminid = $_SESSION["adminid"];
$query = "SELECT * FROM your_admin_table WHERE adminid = '$adminid'";
$result = mysqli_query($conn, $query);

if ($result) {
    $adminInfo = mysqli_fetch_assoc($result);
} else {
    $adminInfo = array(); // Set to an empty array if there's an error
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PowerPay Admin Dashboard</title>
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
    <h2>Welcome, <?php echo $adminInfo["name"]; ?></h2>
    
    <div class="info-container">
        <h3>Admin Information</h3>
        <p>Admin ID: <?php echo $adminInfo["adminid"]; ?></p>
        <p>Phone: <?php echo $adminInfo["phone"]; ?></p>
        <p>Address: <?php echo $adminInfo["address"]; ?></p>
    </div>

    <div class="services-container">
        <h3>Services</h3>
        <div class="info-container">
        <div class="feature-boxes">
            <div class="feature-box" style="background-color: #61dafb;">
                <a href="change_admin_info.php" style="color: #fff;">Change Admin Information</a>
            </div>
            <div class="feature-box" style="background-color: #4fa3d1;">
                <a href="add_user.php" style="color: #fff;">Add User</a>
            </div>
            <div class="feature-box" style="background-color: #3c89b3;">
                <a href="generate_bill.php" style="color: #fff;">Generate Bill</a>
            </div>
            <div class="feature-box" style="background-color: #2d6c8a;">
                <a href="show_bills.php" style="color: #fff;">Show Bills</a>
            </div>
            <div class="feature-box" style="background-color: #1e4e66;">
                <a href="all_users.php" style="color: #fff;">All Users</a>
            </div>
        </div>

        </div >
        
    </div>
    <form method="post" action="admin_logout.php">
        <button id="sign-out-btn" type="submit">Sign Out</button>
    </form>
</body>
</html>
