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

if (!$result) {
    die("Error fetching admin information: " . mysqli_error($conn));
}

$adminInfo = mysqli_fetch_assoc($result);

// Fetch user information from your_user_table and user_bill table
$meter_no = $_GET["meter_no"];

// Check if the meter_no exists in user_bill table
$checkQuery = "SELECT * FROM user_bill WHERE meter_no = '$meter_no'";
$checkResult = mysqli_query($conn, $checkQuery);

if (!$checkResult) {
    die("Error checking user_bill: " . mysqli_error($conn));
}

if (mysqli_num_rows($checkResult) == 0) {
    // If meter_no not found, create a new record in user_bill with default values
    $insertQuery = "INSERT INTO user_bill (meter_no, previously_used_unit, currently_used_unit, bill, late_payment_amount, bill_no, billing_month, issue_date, due_date) 
                    VALUES ('$meter_no', 0, 0, 0, 0, NULL, NULL, NULL, NULL)";
    $insertResult = mysqli_query($conn, $insertQuery);

    if (!$insertResult) {
        die("Error creating a new record for meter_no: $meter_no");
    }
}

// Continue fetching user information
$userQuery = "SELECT u.username, u.meter_no, ub.previously_used_unit, ub.currently_used_unit
              FROM your_user_table u
              JOIN user_bill ub ON u.meter_no = ub.meter_no
              WHERE u.meter_no = '$meter_no'";
$userResult = mysqli_query($conn, $userQuery);

// Check if the query was successful
if (!$userResult) {
    die("Error fetching user information: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PowerPay - Assign Bill</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 1em 0;
        }

        .container {
            max-width: 350px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            text-align: center;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input {
            width: calc(74% - 22px);
            padding: 8px;
            margin-bottom: 10px;
        }

        button {
            background-color: #61dafb;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }

        button.cancel {
            background-color: #ccc;
            margin: 10px;
        }
        
        button.admdash {
            background-color: #008;
        
        }
    </style>
</head>
<body>

    <header>
        <h1>PowerPay</h1>
    </header>

    <div class="container">
        <?php
        // Your PHP code to fetch user information remains unchanged

        while ($row = mysqli_fetch_assoc($userResult)) {
            echo "<h2>Assign Bill</h2>";
            echo "<label>Name:</label> {$row['username']}<br>";
            echo "<label>Meter ID:</label> {$row['meter_no']}<br>";
            echo "<label>Previously Used Unit: {$row['previously_used_unit']}</label> ";
            echo "<label>Currently Used Unit:</label> <input type='number' name='currently_used_unit' value='{$row['currently_used_unit']}' step='0.01' id='currently_used_unit' readonly> 
      <button onclick=\"enableUpdate('currently_used_unit')\">Update</button><br>";
            echo "<button onclick=\"saveChanges('{$row['meter_no']}')\">Save Changes</button>";
            echo "<button class='cancel' onclick=\"cancelChanges()\">Cancel</button>";
            echo "<button onclick=\"generateBill('{$row['meter_no']}')\">Generate Bill</button>";
            echo "<div style='text-align: center;'>";
            echo "<button class='admdash' onclick=\"window.location.href='generate_bill.php'\">Back to Generate Bill</button>";
            echo "<button class='admdash' onclick=\"window.location.href='admin_dashboard.php'\">Back to Admin Dashboard</button>";
            echo "</div>";
        }
        ?>
    </div>

    <script>
    function enableUpdate(fieldName) {
        var inputField = document.getElementById(fieldName);
        inputField.removeAttribute('readonly');
    }

    function saveChanges(meterNo) {
        var currentlyUsedUnit = document.getElementById('currently_used_unit').value;

        // Make an AJAX request to update the values
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("Changes saved successfully!");
                    } else {
                        alert("Error saving changes: " + response.message);
                    }
                } else {
                    alert("Error saving changes. Please try again.");
                }
            }
        };
        xhr.open("POST", "update_used_unit.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("meter_no=" + meterNo + "&currently_used_unit=" + currentlyUsedUnit);
    }

    function cancelChanges() {
        // Reload the page to cancel changes
        location.reload();
    }

    function generateBill(meterNo) {
        var confirmGenerate = confirm("Are you sure you want to generate the bill?");
        if (confirmGenerate) {
            window.location.href = "generate_bill_process.php?meter_no=" + meterNo;
        }
    }
</script>
</body>
</html>
