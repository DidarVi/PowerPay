<?php
header('Content-Type: application/json');

// Check if it's a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meter_no = $_POST["meter_no"];
    $currently_used_unit = $_POST["currently_used_unit"];

    // Perform the update in your database
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "powerpay";

    $conn = mysqli_connect($hostname, $username, $password, $database);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $updateQuery = "UPDATE user_bill SET currently_used_unit = '$currently_used_unit' WHERE meter_no = '$meter_no'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $response["success"] = true;
    } else {
        $response["success"] = false;
        $response["message"] = "Error updating user data: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    $response["success"] = false;
    $response["message"] = "Invalid request method.";
}

echo json_encode($response);
?>
