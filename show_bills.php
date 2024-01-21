<?php
// Establish a database connection
$hostname = "localhost";
$username = "root";
$password = "";
$database = "powerpay";
$conn = mysqli_connect($hostname, $username, $password, $database);

// Check the connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch data from the user_bill table
$query = "SELECT * FROM user_bill";
$result = mysqli_query($conn, $query);

// Check if there are any rows in the result
if (mysqli_num_rows($result) > 0) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Show Bills</title>
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
                color: #3498db;
                margin: 10px;
            }

            table {
                width: 80%;
                border-collapse: collapse;
                margin: 20px auto;
                background-color: #fff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
            }

            th, td {
                border: 1px solid #ddd;
                padding: 12px;
                text-align: left;
            }

            th {
                background-color: #3498db;
                color: #fff;
            }

            tbody tr:nth-child(even) {
                background-color: #f2f2f2;
            }

            .back-btn, .sign-out-btn {
                background-color: #3498db;
                color: #fff;
                padding: 10px 20px;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                margin-top: 15px;
                text-decoration: none;
                display: inline-block;
                margin-right: 10px;
            }

            .sign-out-btn {
                background-color: #e74c3c;
            }
        </style>
    </head>
    <body>
    <div class="logo-container">
    <img class="logo" src="powerpay_img.png" alt="Logo">
</div>
        <h2>User Bills</h2>
        <table>
            <thead>
                <tr>
                    <th>Bill No</th>
                    <th>Meter No</th>
                    <th>Previously Used Unit</th>
                    <th>Currently Used Unit</th>
                    <th>Bill</th>
                    <th>Late Payment Amount</th>
                    <th>Billing Month</th>
                    <th>Issue Date</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the rows and display data
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['bill_no']}</td>";
                    echo "<td>{$row['meter_no']}</td>";
                    echo "<td>{$row['previously_used_unit']}</td>";
                    echo "<td>{$row['currently_used_unit']}</td>";
                    echo "<td>{$row['bill']}</td>";
                    echo "<td>{$row['late_payment_amount']}</td>";
                    echo "<td>" . date('F, Y', strtotime($row['billing_month'])) . "</td>";
                    echo "<td>{$row['issue_date']}</td>";
                    echo "<td>{$row['due_date']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="admin_dashboard.php" class="back-btn">Back to Admin Dashboard</a>
        <a href="admin_logout.php" class="sign-out-btn">Sign Out</a>
    </body>
    </html>
    <?php
} else {
    echo "No records found in the user_bill table.";
}

// Close the database connection
mysqli_close($conn);
?>
