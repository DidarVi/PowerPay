<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: user_login.php"); // Redirect to login page if not logged in
    exit();
}

// Include FPDF library
require_once 'fpdf/fpdf.php';
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

// Function to generate PDF using FPDF
function generatePDF($userData, $billData) {
    // Create FPDF instance
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->Image('powerpay_img.png', 70, 10, 70); // Adjust the path and dimensions


    // Set font
    $pdf->SetFont('Arial', 'B', 12); // Set font to bold

    // Add user information to the PDF with bold and center aligned text
    $pdf->Cell(0, 30, "", 0, 1, 'C');
    $pdf->Cell(0, 10, "Welcome, {$userData['username']}!", 0, 1, 'C');
    $pdf->Cell(0, 10, "User Information", 0, 1, 'C');
    $pdf->SetFont('Arial', '', 14); // Reset font to normal
    $pdf->Cell(0, 8, "Username: {$userData['username']}", 0, 1, 'C');
    $pdf->Cell(0, 8, "Phone: {$userData['phone']}", 0, 1, 'C');
    $pdf->Cell(0, 8, "Address: {$userData['address']}", 0, 1, 'C');
    $pdf->Cell(0, 8, "Meter No: {$userData['meter_no']}", 0, 1, 'C');
    $pdf->Cell(0, 8, "Meter Type: {$userData['meter_type']}", 0, 1, 'C');
    $pdf->Ln(10); // Add some space between sections

    // Add bill information to the PDF with bold and center aligned text
    $pdf->SetFont('Arial', 'B', 12); // Set font to bold
    $pdf->Cell(0, 10, "Bill Information", 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12); // Reset font to normal
    $pdf->Cell(0, 8, "Bill No: {$billData['bill_no']}", 0, 1, 'C');
    $pdf->Cell(0, 8, "Billing Month: " . date('F, Y', strtotime($billData['billing_month'])), 0, 1, 'C');
    $pdf->Cell(0, 8, "Issue Date: " . date('d-m-Y', strtotime($billData['issue_date'])), 0, 1, 'C');
    $pdf->Cell(0, 8, "Due Date: " . date('d-m-Y', strtotime($billData['due_date'])), 0, 1, 'C');
    $pdf->Cell(0, 8, "Previous Used Unit: {$billData['previously_used_unit']}", 0, 1, 'C');
    $pdf->Cell(0, 8, "Current Used Unit: {$billData['currently_used_unit']}", 0, 1, 'C');
    $diff = $billData['currently_used_unit'] - $billData['previously_used_unit'];
    // Format the difference to display decimal places
    $diffFormatted = number_format($diff, 2);
    $pdf->Cell(0, 8, "Difference: {$diffFormatted}", 0, 1, 'C');
    $pdf->Cell(0, 8, "Total Amount To be Paid: {$billData['bill']}", 0, 1, 'C');
    $pdf->Cell(0, 8, "Total if paid after due date: {$billData['late_payment_amount']}", 0, 1, 'C');
    
// Set text color to red for the notice
$pdf->SetTextColor(255, 0, 0);
// Add notice to the PDF
$billingMonth = new DateTime($billData['billing_month']);
$billingMonth->modify('+2 months')->modify('+2 days');
$parsedDate = $billingMonth->format('d-m-Y');
$pdf->Ln(10); // Add some space between sections
$pdf->MultiCell(0, 8, "Notice: if the bill is not paid within $parsedDate, the line will be disconnected. No further notice will be issued. This will be treated as the final notice for Disconnection", 0, 'C');

// Reset text color to black
$pdf->SetTextColor(0, 0, 0);
    // Output PDF as a download
    $pdf->Output('user_bill_fpdf.pdf', 'D');
}

// Generate PDF when the download button is clicked
generatePDF($userData, $billData);
?>
