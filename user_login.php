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
    $meterNo = $_POST["meter_no"];
    $password = $_POST["password"];

    // Check if the user exists in the database
    $query = "SELECT * FROM your_user_table WHERE meter_no = '$meterNo'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Verify the password
            if (password_verify($password, $row["password"])) {
                // Password is correct, set session variables and redirect
                $_SESSION["user_id"] = $row["id"];
                header("Location: user_dashboard.php"); // Redirect to user dashboard or wherever you want
                exit();
            } else {
                echo '<script>alert("Invalid password");</script>';
            }
        } else {
            $error = "User not found";
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
    <title>User Login</title>
    <link rel="stylesheet" href="form.css">

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

        input {
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

        .register-link {
            text-align: center;
            margin-top: 10px;
        }

        .register-link a {
            color: #61dafb;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <h2>User Login</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>Error: $error</p>";
    }
    ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="meter_no">Meter No:</label>
        <input type="text" name="meter_no" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>
