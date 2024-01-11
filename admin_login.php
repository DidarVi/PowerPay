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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $adminID = $_POST["adminid"];
    $password = $_POST["password"];

    // Check if the admin exists in the database
    $query = "SELECT * FROM your_admin_table WHERE adminid = '$adminID'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Verify the password
            if (password_verify($password, $row["password"])) {
                // Password is correct, set session variables and redirect
                $_SESSION["admin_id"] = $row["id"];
                header("Location: admin_dashboard.php"); // Redirect to admin dashboard or wherever you want
                exit();
            } else {
                echo '<script>alert("Incorrect Password");</script>';
            }
        } else {
            echo '<script>alert("Invalid Admin ID");</script>';
        }
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="form.css">

</head>
<body>
    <h2>Admin Login</h2>
    
    <?php
    if (isset($error)) {
        echo "<p>Error: $error</p>";
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="adminid">Admin ID:</label>
        <input type="text" name="adminid" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>

    <div class="register-link">
        <p>If you are not registered, <a href="admin_registration.php">register now</a>.</p>
    </div>
</body>
</html>
