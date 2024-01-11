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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch form data
    $name = $_POST["name"];
    $adminid = $_POST["adminid"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $password = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Validate input (you may need to add more validation)
    if ($password != $confirmPassword) {
        $error = "Password and Confirm Password do not match";
    } else {
        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert data into the database
        $query = "INSERT INTO your_admin_table (name, adminid, phone, address, password) VALUES ('$name', '$adminid', '$phone', '$address', '$hashedPassword')";
        
        $result = mysqli_query($conn, $query);

        if ($result) {
            $success = "Admin registration successful!";

            // JavaScript to show success popup and redirect
            echo '<script>
                    alert("Admin registration successful!");
                    window.location.href = "admin_login.php";
                  </script>';
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
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
    <title>PowerPay Admin Registration</title>
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

    form {
        width: 30%;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        color: #333;
    }

    input,
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #61dafb;
        color: #fff;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
        background-color: #4fa3d1;
    }

    p {
        color: red;
        text-align: center;
        margin-top: 15px;
    }

    p.success {
        color: green;
        text-align: center;
        margin-top: 15px;
    }
</style>

</head>
<body>
    <h2>Admin Registration</h2>
    
    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>Error: $error</p>";
    }

    if (isset($success)) {
        echo "<p style='color: green;'>$success</p>";
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        Name: <input type="text" name="name" required><br>
        Admin ID: <input type="text" name="adminid" required><br>
        Phone Number: <input type="text" name="phone" required><br>
        Address: <textarea name="address" required></textarea><br>
        Password: <input type="password" name="password" required><br>
        Confirm Password: <input type="password" name="confirm_password" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
