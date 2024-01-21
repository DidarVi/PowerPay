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

// Check if the meter_no parameter is set
if (isset($_GET["meter_no"])) {
    $meter_no = $_GET["meter_no"];

    // Fetch user information from your_user_table and user_bill table
    $userQuery = "SELECT u.username, u.meter_no, u.meter_type, ub.previously_used_unit, ub.currently_used_unit
                  FROM your_user_table u
                  JOIN user_bill ub ON u.meter_no = ub.meter_no
                  WHERE u.meter_no = '$meter_no'";
    $userResult = mysqli_query($conn, $userQuery);

    if ($userResult) {
        $userData = mysqli_fetch_assoc($userResult);
    } else {
        die("Error fetching user information: " . mysqli_error($conn));
    }

    // Define energy rates and late penalties based on meter types
    $energyRate = 0.0;
    $latePenalty = 0.0;

    switch ($userData['meter_type']) {
        case 'residential':
            if ($userData['currently_used_unit'] - $userData['previously_used_unit'] <= 150.00) {
                $energyRate = 5.50;
            } elseif ($userData['currently_used_unit'] - $userData['previously_used_unit'] <= 400.00) {
                $energyRate = 6.50;
            } elseif ($userData['currently_used_unit'] - $userData['previously_used_unit'] <= 600.00) {
                $energyRate = 7.10;
            } else {
                $energyRate = 9.00;
            }
            $latePenalty = 150.00;
            break;

        case 'garments':
            if ($userData['currently_used_unit'] - $userData['previously_used_unit'] <= 250.00) {
                $energyRate = 9.40;
            } elseif ($userData['currently_used_unit'] - $userData['previously_used_unit'] <= 550.00) {
                $energyRate = 10.57;
            } else {
                $energyRate = 13.00;
            }
            $latePenalty = 400.00;
            break;

        case 'industry':
            if ($userData['currently_used_unit'] - $userData['previously_used_unit']<= 400.00) {
                $energyRate = 11.65;
            } elseif ($userData['currently_used_unit'] - $userData['previously_used_unit'] <= 850.00) {
                $energyRate = 13.45;
            } else {
                $energyRate = 15.53;
            }
            $latePenalty = 650.00;
            break;
    }

    // Calculate the bill amount
    $billAmount = ($userData['currently_used_unit'] - $userData['previously_used_unit']) * $energyRate;

    // Check for late payment
    $latePaymentAmount = 0.0;
    if ($latePenalty > 0) {
        // Calculate late payment amount
        $latePaymentAmount = $billAmount + $latePenalty;
    }

    // Get today's date
    $issueDate = date('Y-m-d');

    // Get the first day of the billing month
    $billingMonth = date('Y-m-01');

    // Get the due date (14th of the next month)
    $dueDate = date('Y-m-d', strtotime('13 days', strtotime('+1 month', strtotime($billingMonth))));


    // Update the bill amount, late payment amount, issue_date, billing_month, and due_date in the user_bill table
    $updateBillQuery = "UPDATE user_bill 
                        SET bill = $billAmount, 
                            late_payment_amount = $latePaymentAmount,
                            issue_date = '$issueDate',
                            billing_month = '$billingMonth',
                            due_date = '$dueDate'
                        WHERE meter_no = '$meter_no'";
    $updateResult = mysqli_query($conn, $updateBillQuery);

    if ($updateResult) {
        // Redirect back to the assign_bill.php page with a success message
        header("Location: assign_bill.php?meter_no=$meter_no&success=1");
        exit();
    } else {
        die("Error updating bill information: " . mysqli_error($conn));
    }
} else {
    die("Error: Missing 'meter_no' parameter.");
}

// Close the database connection
mysqli_close($conn);
?>
