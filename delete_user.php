<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION["adminid"])) {
    header("Location: admin_login.php"); // Redirect to admin login page if not logged in
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

// Get user ID from the GET parameters
$userId = isset($_GET['id']) ? $_GET['id'] : 0;

// Perform the delete operation
$query = "DELETE FROM your_user_table WHERE id = $userId"; // Replace 'your_user_table' with your actual table name
$result = mysqli_query($conn, $query);

// Close the database connection
mysqli_close($conn);

// Check the result and redirect accordingly
if ($result) {
    echo "success";
} else {
    echo "error";
}
?>
