<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Information and Bill</title>
    
    <style>
        .logo-container {
    width: 100%;
    text-align: center;
    margin:0px;
    background: white;
}

.logo {
    max-width: 17%;
    height: auto;
}
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: left;
            overflow: hidden; /* Clear the float */
        }

        h2, h3 {
            color: #007BFF;
            margin-bottom: 10px;
        }

        p {
            margin: 5px 0;
            font-size: 14px;
            text-align: left;
        }

        /* Split the container into two columns */
        .user-info, .bill-info {
            float: left;
            width: 48%; /* Adjust the width as needed */
            margin-right: 2%; /* Adjust the margin between columns */
            box-sizing: border-box; /* Include padding and border in the width */
        }

        .btn-container {
            text-align: center;
            margin-top: 20px;
            clear: both; /* Clear the float */
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            margin: 10px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn-secondary {
            background-color: #555;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #444;
        }

        .btn-download {
            background-color: #3498db;
            color: white;
        }

        .btn-download:hover {
            background-color: #217dbb;
        }

        .btn-sign-out {
            background-color: #dc3545;
            color: white;
        }

        .btn-sign-out:hover {
            background-color: #c82333;
        }

        .cen {
            text-align: center;
        }
        
    </style>
</head>
<body>
    <?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION["user_id"])) {
        header("Location: user_login.php"); // Redirect to the login page if not logged in
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
    $userId = $_SESSION["user_id"];

    // Fetch user information from your_user_table
    $userQuery = "SELECT * FROM your_user_table WHERE id = '$userId'";
    $userResult = mysqli_query($conn, $userQuery);

    // Check if the query was successful
    if (!$userResult) {
        die("Error fetching user information: " . mysqli_error($conn));
    }

    // Fetch user data
    $userData = mysqli_fetch_assoc($userResult);

    // Fetch bill information from user_bill table based on meter_no
    $billQuery = "SELECT * FROM user_bill WHERE meter_no = '{$userData['meter_no']}'";
    $billResult = mysqli_query($conn, $billQuery);

    // Check if the query was successful
    if (!$billResult) {
        die("Error fetching bill information: " . mysqli_error($conn));
    }

    // Fetch bill data
    $billData = mysqli_fetch_assoc($billResult);
    ?>
    <div class="logo-container">
    <img class="logo" src="powerpay_img.png" alt="Logo">
</div>
    
    <div class="container">
        
        <h2 class="cen">Welcome, <?php echo $userData['username']; ?>!</h2>
        <div class="user-info cen">
            <h3>User Information</h3>
            <div class="cen">
                <p class="cen"><strong>Username:</strong> <?php echo $userData['username']; ?></p>
                <p class="cen"><strong>Phone:</strong> <?php echo $userData['phone']; ?></p>
                <p class="cen"><strong>Address:</strong> <?php echo $userData['address']; ?></p>
                <p class="cen"><strong>Meter No:</strong> <?php echo $userData['meter_no']; ?></p>
                <p class="cen"><strong>Meter Type:</strong> <?php echo $userData['meter_type']; ?></p>
            </div>
        </div>

        <div class="bill-info cen"  >
            <h3>Bill Information</h3>
            <p class="cen"><strong>Bill No:</strong> <?php echo $billData['bill_no']; ?></p>
            <p class="cen"><strong>Billing Month:</strong> <?php echo date('F, Y', strtotime($billData['billing_month'])); ?></p>
            <p class="cen"><strong>Issue Date:</strong> <?php echo date('d-m-Y', strtotime($billData['issue_date'])); ?></p>
            <p class="cen"><strong>Due Date:</strong> <?php echo date('d-m-Y', strtotime($billData['due_date'])); ?></p>
            <p class="cen"><strong>Previous Used Unit:</strong> <?php echo $billData['previously_used_unit']; ?></p>
            <p class="cen"><strong>Current Used Unit:</strong> <?php echo $billData['currently_used_unit']; ?></p>
            <p class="cen"><strong>Difference:</strong> <?php echo $billData['currently_used_unit'] - $billData['previously_used_unit']; ?></p>
        </div>
        
        <div class="cen">
            <p class="cen"><strong>Total Amount To be Paid:</strong> <?php echo $billData['bill']; ?></p>
            <p class="cen"><strong>Total if paid after due date:</strong> <?php echo $billData['late_payment_amount']; ?></p>
            <p class="cen"><strong>Notice: if the bill is not paid within <?php echo date('d-m-Y', strtotime('2 days', strtotime('+2 month', strtotime($billData['billing_month']))));?>, the line will be disconnected. No further notice will be issued. This will be treated as the final notice for Disconnection</p>
        </div>

        <div class="btn-container">
            
            <!-- Add download button -->
            <a href="download.php" class="btn btn-sign-out">Download</a>
            <!-- Add return to the dashboard button -->
            <a href="user_dashboard.php" class="btn btn-download">Return to Dashboard</a>
            
            <!-- Add sign-out button -->
            <a href="user_logout.php" class="btn btn-sign-out">Sign Out</a>
        </div>
    </div>
</body>
</html>
