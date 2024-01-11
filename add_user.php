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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $username = $_POST["username"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $meterNo = $_POST["meter_no"];
    $meterType = $_POST["meter_type"];
    $password = $_POST["password"];

    // Check if the meter number is unique
    $checkQuery = "SELECT * FROM your_user_table WHERE meter_no = '$meterNo'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $error = "Meter number already exists. Please choose a different one.";
    } else {
        // Insert new user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertQuery = "INSERT INTO your_user_table (username, age, gender, phone, address, meter_no, meter_type, password) VALUES ('$username', '$age', '$gender', '$phone', '$address', '$meterNo', '$meterType', '$hashedPassword')";
        
        $insertResult = mysqli_query($conn, $insertQuery);

        if ($insertResult) {
            $success = "User added successfully!";
            header("Location: admin_dashboard.php");
            exit();

        } else {
            $error = "Error adding user: " . mysqli_error($conn);
        }
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>
    <link rel="stylesheet" href="form.css">
</head>
<body>
    <h2>Add User</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>Error: $error</p>";
    }

    if (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" required><br>

        <label for="gender">Gender:</label>
        <select name="gender" required>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
        </select><br>

        <label for="phone">Phone:</label>
        <input type="text" name="phone" required><br>

        <label for="address">Address:</label>
        <textarea name="address" required></textarea><br>

        <label for="meter_no">Meter No:</label>
        <input type="text" name="meter_no" required><br>

        <label for="meter_type">Meter Type:</label>
        <select name="meter_type" required>
            <option value="residential">Residential</option>
            <option value="garments">Garments</option>
            <option value="industry">Industry</option>
        </select><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Add User">
    </form>
</body>
</html>
