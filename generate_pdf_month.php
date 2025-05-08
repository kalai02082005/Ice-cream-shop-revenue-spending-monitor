<?php
session_start();
require_once 'include/database-connection.php';
require 'fpdf/fpdf.php';

// Validate input
if (!isset($_GET["selected_month"]) || empty($_GET["selected_month"])) {
    die("Error: Month and year are required.");
}

$selected_month = $_GET["selected_month"]; // Format: YYYY-MM
$type = isset($_GET["type"]) ? $_GET["type"] : "both"; // Default to "both"
$user_email = $_SESSION["email"] ?? "";

// Extract year and month
$year = date('Y', strtotime($selected_month . "-01"));
$month = date('m', strtotime($selected_month . "-01"));

// Validate month-year format
if (!$year || !$month) {
    die("Error: Invalid month format.");
}

// Sanitize inputs
$year = mysqli_real_escape_string($conn, $year);
$month = mysqli_real_escape_string($conn, $month);
$user_email = mysqli_real_escape_string($conn, $user_email);

$formatted_month = date('F Y', strtotime($selected_month . "-01")); // Example: January 2025
$name = ucwords($_SESSION["name"] ?? "User");
$current_date = date('jS F, Y');

// Prepare SQL query for month-wise report
$sql_query = "";

if ($type == "income") {
    $sql_query = "SELECT 'Income' as type, date, category, amount, account FROM incomenew 
                  WHERE YEAR(date) = '$year' AND MONTH(date) = '$month' AND user_email = '$user_email'";
} elseif ($type == "expense") {
    $sql_query = "SELECT 'Expense' as type, date, category, amount, account FROM expensesnew 
                  WHERE YEAR(date) = '$year' AND MONTH(date) = '$month' AND user_email = '$user_email'";
} else {
    $sql_query = "(SELECT 'Income' as type, date, category, amount, account FROM incomenew 
                   WHERE YEAR(date) = '$year' AND MONTH(date) = '$month' AND user_email = '$user_email')
                  UNION
                  (SELECT 'Expense' as type, date, category, amount, account FROM expensesnew 
                   WHERE YEAR(date) = '$year' AND MONTH(date) = '$month' AND user_email = '$user_email')";
}

$result = mysqli_query($conn, $sql_query);

// Check for query errors
if (!$result) {
    die("Database Query Failed: " . mysqli_error($conn));
}

// Start PDF generation
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 25);
$pdf->Cell(190, 15, "Financial Management System", 0, 1, 'C'); 
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 14);
$pdf->Cell(190, 10, "Client Name: $name", 0, 1, 'C');
$pdf->Cell(190, 10, "Current Date: $current_date", 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(190, 10, "Month-wise Report for: $formatted_month", 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 12);

// Table Header
$pdf->Cell(15, 10, "S.No", 1, 0, 'C');
$pdf->Cell(35, 10, "Date", 1, 0, 'C');
$pdf->Cell(30, 10, "Type", 1, 0, 'C');
$pdf->Cell(40, 10, "Category", 1, 0, 'C');
$pdf->Cell(35, 10, "Account", 1, 0, 'C');
$pdf->Cell(35, 10, "Amount", 1, 1, 'C');

$i = 1;
if (mysqli_num_rows($result) > 0) {
    $pdf->SetFont('Arial', '', 12);

    while ($row = mysqli_fetch_assoc($result)) {
        $pdf->Cell(15, 10, $i, 1, 0, 'C'); 
        $pdf->Cell(35, 10, date('d-M-Y', strtotime($row['date'])), 1, 0, 'C'); 
        $pdf->Cell(30, 10, $row['type'], 1, 0, 'C'); 
        $pdf->Cell(40, 10, $row['category'], 1, 0, 'C');
        $pdf->Cell(35, 10, $row['account'], 1, 0, 'C');  
        $pdf->Cell(35, 10, "$" . number_format($row['amount'], 2), 1, 1, 'C');   
        $i++;   
    }
} else {
    // No records found
    $pdf->Cell(190, 10, "No records found for this month.", 1, 1, 'C');
}

// Output PDF
$pdf->Output();
?>
