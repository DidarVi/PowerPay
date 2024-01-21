<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: user_login.php"); // Redirect to user login page if not logged in
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

// Fetch user information based on the session variable
$userID = $_SESSION["user_id"];
$query = "SELECT * FROM your_user_table WHERE id = $userID";
$result = mysqli_query($conn, $query);

if ($result) {
    $userInfo = mysqli_fetch_assoc($result);
} else {
    $userInfo = array(); // Set to an empty array if there's an error
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update user information in the database
    $newName = $_POST["new_name"];
    $newAddress = $_POST["new_address"];
    $newPhone = $_POST["new_phone"];
    $newGender = $_POST["new_gender"];

    $updateQuery = "UPDATE your_user_table SET username = '$newName', address = '$newAddress', phone = '$newPhone', gender = '$newGender' WHERE id = $userID";

    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        // Redirect to the user dashboard after successful update
        header("Location: user_dashboard.php");
        exit();
    } else {
        $errorMessage = "Failed to update user information. Please try again.";
    }
}

// Close the database connection after all operations
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update User Info</title>
    <link rel="stylesheet" href="styles.css">
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
            color: #3498db;
            margin: 10px;
        }

        .update-form {
            max-width: 400px;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #3498db;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
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
        }

        #back-btn:hover {
            background-color: #c0392b;
        }

        .error-message {
            color: #e74c3c;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="logo-container">
    <img class="logo" src="powerpay_img.png" alt="Logo">
</div>
    <h2>Update User Information</h2>
    

    <div class="update-form">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="new_name">Name:</label>
            <input type="text" id="new_name" name="new_name" value="<?php echo $userInfo["username"]; ?>" required>

            <label for="new_address">Address:</label>
            <input type="text" id="new_address" name="new_address" value="<?php echo $userInfo["address"]; ?>" required>

            <label for="new_phone">Phone Number:</label>
            <input type="tel" id="new_phone" name="new_phone" value="<?php echo $userInfo["phone"]; ?>" required>

            <label for="new_gender">Gender:</label>
            <select id="new_gender" name="new_gender" required>
                <option value="male" <?php echo ($userInfo["gender"] === 'male') ? 'selected' : ''; ?>>Male</option>
                <option value="female" <?php echo ($userInfo["gender"] === 'female') ? 'selected' : ''; ?>>Female</option>
                <option value="other" <?php echo ($userInfo["gender"] === 'other') ? 'selected' : ''; ?>>Other</option>
            </select>

            <button type="submit">Update Information</button>
        </form>

        <?php
        // Display error message if exists
        if (isset($errorMessage)) {
            echo '<div class="error-message">' . $errorMessage . '</div>';
        }
        ?>
    </div>

    <a href="user_dashboard.php" id="back-btn">Back to Dashboard</a>
    <a href="user_logout.php" id="sign-out-btn">Sign Out</a>
</body>
</html>
