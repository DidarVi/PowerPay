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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $newName = $_POST["new_name"];
    $newPhone = $_POST["new_phone"];
    $newAddress = $_POST["new_address"];

    // Update admin information in the database
    $updateQuery = "UPDATE your_admin_table SET name = '$newName', phone = '$newPhone', address = '$newAddress' WHERE adminid = '$adminid'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $success = "Admin information updated successfully!";
    } else {
        $error = "Error updating information: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Admin Information</title>
    <link rel="stylesheet" href="form.css">
    <script>
        function showMessage(message, redirectTo) {
            alert(message);
            window.location.href = redirectTo;
        }
    </script>
</head>
<body>
    <h2>Change Admin Information</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>Error: $error</p>";
    }

    if (isset($success)) {
        // Call JavaScript function to display success message in a popup and redirect
        echo "<script>showMessage('$success', 'admin_dashboard.php');</script>";
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="new_name">New Name:</label>
        <input type="text" name="new_name" value="<?php echo $adminInfo["name"]; ?>" required><br>

        <label for="new_phone">New Phone:</label>
        <input type="text" name="new_phone" value="<?php echo $adminInfo["phone"]; ?>" required><br>

        <label for="new_address">New Address:</label>
        <textarea name="new_address" required><?php echo $adminInfo["address"]; ?></textarea><br>

        <input type="submit" value="Update Information">
    </form>
</body>
</html>
