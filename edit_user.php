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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $userId = $_POST["user_id"];
    $newUsername = $_POST["new_username"];
    $newAge = $_POST["new_age"];
    $newGender = $_POST["new_gender"];
    $newPhone = $_POST["new_phone"];
    $newAddress = $_POST["new_address"];
    $newMeterNo = $_POST["new_meter_no"];
    $newMeterType = $_POST["new_meter_type"];

    // Update user information in the database
    $updateQuery = "UPDATE your_user_table SET username = '$newUsername', age = '$newAge', gender = '$newGender', phone = '$newPhone', address = '$newAddress', meter_no = '$newMeterNo', meter_type = '$newMeterType' WHERE id = $userId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $success = "User information updated successfully!";
    } else {
        $error = "Error updating information: " . mysqli_error($conn);
    }
}

// Fetch user information based on the user ID from the URL
if (isset($_GET["id"])) {
    $userId = $_GET["id"];
    $query = "SELECT * FROM your_user_table WHERE id = $userId";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $userInfo = mysqli_fetch_assoc($result);
    } else {
        $userInfo = array(); // Set to an empty array if there's an error
    }
} else {
    // Redirect if user ID is not provided
    header("Location: all_users.php");
    exit();
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <h2>Edit User</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>Error: $error</p>";
    }

    if (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
        
        <label for="new_username">New Username:</label>
        <input type="text" name="new_username" value="<?php echo $userInfo["username"]; ?>" required><br>

        <label for="new_age">New Age:</label>
        <input type="number" name="new_age" value="<?php echo $userInfo["age"]; ?>" required><br>

        <label for="new_gender">New Gender:</label>
        <select name="new_gender" required>
            <option value="male" <?php if ($userInfo["gender"] === "male") echo "selected"; ?>>Male</option>
            <option value="female" <?php if ($userInfo["gender"] === "female") echo "selected"; ?>>Female</option>
            <option value="other" <?php if ($userInfo["gender"] === "other") echo "selected"; ?>>Other</option>
        </select><br>

        <label for="new_phone">New Phone:</label>
        <input type="text" name="new_phone" value="<?php echo $userInfo["phone"]; ?>" required><br>

        <label for="new_address">New Address:</label>
        <textarea name="new_address" required><?php echo $userInfo["address"]; ?></textarea><br>

        <label for="new_meter_no">New Meter No:</label>
        <input type="text" name="new_meter_no" value="<?php echo $userInfo["meter_no"]; ?>" required><br>

        <label for="new_meter_type">New Meter Type:</label>
        <select name="new_meter_type" required>
            <option value="residential" <?php if ($userInfo["meter_type"] === "residential") echo "selected"; ?>>Residential</option>
            <option value="garments" <?php if ($userInfo["meter_type"] === "garments") echo "selected"; ?>>Garments</option>
            <option value="industry" <?php if ($userInfo["meter_type"] === "industry") echo "selected"; ?>>Industry</option>
        </select><br>

        <input type="submit" value="Update User">
    </form>
</body>
</html>
