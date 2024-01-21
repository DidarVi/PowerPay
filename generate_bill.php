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

// Fetch user information from your_user_table
$userQuery = "SELECT username, meter_no FROM your_user_table";
$userResult = mysqli_query($conn, $userQuery);

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PowerPay - Generate Bill</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            border-collapse: collapse;
            width: 50%; /* Adjusted table width */
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #0066cc;
            color: white;
        }

        .update-button {
            display: inline-block;
            padding: 8px 15px;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .update-button:hover {
            background-color: #45a049;
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
        .sign-out-container{
            margin:0px;
        }

    </style>
</head>
<body>
<div class="logo-container">
    <img class="logo" src="powerpay_img.png" alt="Logo">
</div>
    <h2>Generate Bill</h2>
    
    <!-- Display user information in a table -->
    <table>
        <tr>
            <th>User Name</th>
            <th>Meter ID</th>
            <th>Action</th>
        </tr>
        <?php
            while ($row = mysqli_fetch_assoc($userResult)) {
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['meter_no']}</td>";
                echo "<td><a href='assign_bill.php?username={$row['username']}&meter_no={$row['meter_no']}' class='update-button'>Update Bill</a></td>";
                echo "</tr>";
            }
        ?>
    </table>
    <div class="sign-out-container">
    <a href="admin_dashboard.php" id="back-btn">Back to Admin Dashboard</a>
    </div>
    <div class="sign-out-container">
        <button id="sign-out-btn" onclick="location.href='admin_logout.php'">Sign Out</button>
    </div>

</body>
</html>
