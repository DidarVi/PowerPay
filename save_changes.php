<?php
session_start();

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

if (isset($_GET['meter_no']) && isset($_GET['prev_used_unit']) && isset($_GET['curr_used_unit'])) {
    $meter_no = $_GET['meter_no'];
    $prev_used_unit = $_GET['prev_used_unit'];
    $curr_used_unit = $_GET['curr_used_unit'];

    // Update used units in user_bill table
    $updateQuery = "UPDATE user_bill SET previously_used_unit = '$prev_used_unit', currently_used_unit = '$curr_used_unit' WHERE meter_no = '$meter_no'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        echo "Changes saved successfully";
    } else {
        echo "Error saving changes";
    }
} else {
    echo "Invalid parameters";
}

// Close the database connection
mysqli_close($conn);
?>
