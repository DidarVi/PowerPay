<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION["adminid"])) {
    header("Location: admin_login.php"); // Redirect to admin login page if not logged in
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

// Fetch all users from the user table
$query = "SELECT * FROM your_user_table"; // Replace 'your_user_table' with your actual table name
$result = mysqli_query($conn, $query);

// Check if there are users in the database
if ($result && mysqli_num_rows($result) > 0) {
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $users = array(); // Set to an empty array if there are no users or there's an error
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users</title>
    <script>
        function deleteUser(userId) {
          var confirmDelete = confirm("Are you sure you want to delete user with ID " + userId + "?");
      
          if (confirmDelete) {
              // Perform delete operation using AJAX
              var xhr = new XMLHttpRequest();
              xhr.onreadystatechange = function () {
                  if (xhr.readyState == 4) {
                      if (xhr.status == 200) {
                          // Check the response
                          if (xhr.responseText === "success") {
                              alert("User deleted successfully!");
                              // Redirect to all_users.php
                              window.location.href = "all_users.php";
                          } else {
                              alert("Error deleting user.");
                          }
                      } else {
                          alert("Error deleting user. Status: " + xhr.status);
                      }
                  }
              };
              xhr.open("GET", "delete_user.php?id=" + userId, true);
              xhr.send();
          }
      }
      
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        
        h2 {
            color: #333;
        }
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        
        table, th, td {
            border: 1px solid #ddd;
        }
        
        th, td {
            padding: 10px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
        }
        
        a {
            text-decoration: none;
            color: #007BFF;
            cursor: pointer;
        }
        
        button {
            background-color: #DC3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        
        button:hover {
            background-color: #c82333;
        }
        
        p {
            margin-top: 10px;
        }
        
        p.success {
            color: green;
        }
        
        p.error {
            color: red;
        }
        /* Add this CSS after the previous styles */
        
        /* Styling for the "Edit" link */
        a.edit-link {
            color: #28a745; /* Green color for the edit link */
            font-weight: bold;
            margin-right: 10px;
        }
        
        a.edit-link:hover {
            text-decoration: underline;
            color: #218838; /* Darker green color on hover */
        }
        /* Add this CSS after the previous styles */
        
        /* Styling for the Admin Dashboard button */
        .admin-dashboard-button-container {
            text-align: center;
            margin-top: 20px;
        }
        
        .admin-dashboard-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease-in-out;
        }
        
        .admin-dashboard-button:hover {
            background-color: #0056b3;
        }
        
    </style>
</head>
<body>
    <h2>All Users</h2>

    <?php
    if (empty($users)) {
        echo "<p>No users found.</p>";
    } else {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Username</th><th>Age</th><th>Gender</th><th>Phone</th><th>Address</th><th>Meter No</th><th>Meter Type</th><th>Actions</th></tr>";

        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>{$user['id']}</td>";
            echo "<td>{$user['username']}</td>";
            echo "<td>{$user['age']}</td>";
            echo "<td>{$user['gender']}</td>";
            echo "<td>{$user['phone']}</td>";
            echo "<td>{$user['address']}</td>";
            echo "<td>{$user['meter_no']}</td>";
            echo "<td>{$user['meter_type']}</td>";
            echo "<td>";
            echo "<a class='edit-link' href='edit_user.php?id={$user['id']}'>Edit</a>";
            echo "<button onclick='deleteUser({$user['id']})'>Delete</button>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    ?>
         <!-- Add this HTML and CSS at the end of your file -->
     <div class="admin-dashboard-button-container">
         <a class="admin-dashboard-button" href="admin_dashboard.php">Admin Dashboard</a>
     </div>

</body>
</html>
