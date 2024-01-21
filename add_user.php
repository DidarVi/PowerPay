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
    $previouslyUsedUnit = $_POST["previously_used_unit"];
    $password = $_POST["password"];

    // Check if the meter number is unique
    $checkQuery = "SELECT * FROM your_user_table WHERE meter_no = '$meterNo'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if ($checkResult && mysqli_num_rows($checkResult) > 0) {
        $error = "Meter number already exists. Please choose a different one.";
    } else {
        // Insert new user into the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insertUserQuery = "INSERT INTO your_user_table (username, age, gender, phone, address, meter_no, meter_type, password) VALUES ('$username', '$age', '$gender', '$phone', '$address', '$meterNo', '$meterType', '$hashedPassword')";
        
        $insertUserResult = mysqli_query($conn, $insertUserQuery);

        if ($insertUserResult) {
            // Insert data into user_bill table
            $insertBillQuery = "INSERT INTO user_bill (meter_no, previously_used_unit, currently_used_unit, bill, late_payment_amount) VALUES ('$meterNo', $previouslyUsedUnit, 0, 0, 0)";
            $insertBillResult = mysqli_query($conn, $insertBillQuery);

            if ($insertBillResult) {
                $success = "User added successfully!";
                header("Location: admin_dashboard.php");
                exit();
            } else {
                $error = "Error adding user to user_bill: " . mysqli_error($conn);
            }
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
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
}

.container {
    width: 70%;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

h2 {
    text-align: center;
    color: #333;
}

.user-form {
    display: flex;
    flex-direction: column;
    max-width: 400px;
    margin: 0 auto;
}

label {
    margin-bottom: 5px;
}

input,
select,
textarea {
    margin-bottom: 10px;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

.error {
    color: #ff0000;
}

.success {
    color: #008000;

}
button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        button:hover {
            background-color: #2980b9;
        }

        #back-btn {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
    

        #back-btn:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add User</h2>

        <?php
        if (isset($error)) {
            echo "<p class='error'>Error: $error</p>";
        }

        if (isset($success)) {
            echo "<p class='success'>$success</p>";
        }
        ?>

        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="user-form">
            
        <div><label for="username">Username:</label>
            <input type="text" name="username" required>
</div>
            <div><label for="age">Age:</label>
            <input type="number" name="age" required>
</div>
<div> <label for="gender">Gender:</label>
            <select name="gender" required>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select></div>
           
<div><label for="phone">Phone:</label>
            <input type="text" name="phone" required>
</div>
            
<label for="address">Address:</label>
            <textarea name="address" required></textarea>
            <div><label for="meter_no">Meter No:</label>
            <input type="text" name="meter_no" required></div>

            
<div><label for="meter_type">Meter Type:</label>
            <select name="meter_type" required>
                <option value="residential">Residential</option>
                <option value="garments">Garments</option>
                <option value="industry">Industry</option>
            </select></div>
            
<div><label for="password">Password:</label>
            <input type="password" name="password" required></div>
            
<div><label for="previously_used_unit">Previously Used Unit:</label>
<input type="number" name="previously_used_unit" step="0.01"></div>
            

            <!-- <input type="number" name="previously_used_unit" step="0.01" value="0.00"> -->

            <input type="submit" value="Add User">
            <a href="admin_dashboard.php" id="back-btn">Back to Admin Dashboard</a>
            <button id="sign-out-btn" onclick="location.href='admin_logout.php'">Sign Out</button>
        
        </form>
        
    </div>
</body>
</html>
