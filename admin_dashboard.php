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
            color: #61dafb;
            margin-bottom: 20px;
        }

        div {
            max-width: 600px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        h3 {
            color: #333;
            border-bottom: 2px solid #61dafb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        p {
            margin: 10px 0;
        }

        .feature-boxes {
            display: flex;
            justify-content: space-between;
        }

        .feature-box {
            width: calc(20% - 10px); /* Adjust width based on the number of features */
            padding: 10px;
            border: 1px solid #61dafb;
            border-radius: 8px;
            text-align: center;
        }

        a {
            color: #61dafb;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $adminInfo["name"]; ?></h2>
    
    <div>
        <h3>Admin Information</h3>
        <p>Admin ID: <?php echo $adminInfo["adminid"]; ?></p>
        <p>Phone: <?php echo $adminInfo["phone"]; ?></p>
        <p>Address: <?php echo $adminInfo["address"]; ?></p>
    </div>

    <div>
        <h3>Services</h3>
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
    </div>
</body>
</html>
