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
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
</style>

</head>
<body>
    <h2>Welcome, <?php echo $userInfo["username"]; ?></h2>
    
    <div>
        <h3>Your Information</h3>
        <p>Age: <?php echo $userInfo["age"]; ?></p>
        <p>Gender: <?php echo $userInfo["gender"]; ?></p>
        <p>Phone: <?php echo $userInfo["phone"]; ?></p>
        <p>Address: <?php echo $userInfo["address"]; ?></p>
        <p>Meter No: <?php echo $userInfo["meter_no"]; ?></p>
        <p>Meter Type: <?php echo $userInfo["meter_type"]; ?></p>
    </div>

    <!-- Add more sections or links for user actions as needed -->
</body>
</html>
