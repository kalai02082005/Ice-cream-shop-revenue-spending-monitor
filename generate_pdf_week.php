<?php 
session_start();
require_once 'include/database-connection.php';
require 'fpdf/fpdf.php';

// Check if date is provided
if (!isset($_GET["start_date"]) || empty($_GET["start_date"])) {
    die("Error: Start date is required.");
}

$start_date = $_GET["start_date"];
$type = isset($_GET["type"]) ? $_GET["type"] : "both"; // Default to "both" if not set
$user_email = $_SESSION["email"] ?? "";

// Validate date format
if (!strtotime($start_date)) {
    die("Error: Invalid date format.");
}

// Sanitize input
$start_date = mysqli_real_escape_string($conn, $start_date);
$user_email = mysqli_real_escape_string($conn, $user_email);

// Calculate end date (7 days from start)
$end_date = date('Y-m-d', strtotime($start_date . ' +6 days'));

$date_range_formatted = date('jS F, Y', strtotime($start_date)) . " to " . date('jS F, Y', strtotime($end_date));
$name = ucwords($_SESSION["name"] ?? "User");
$current_date = date('jS F, Y');

// Prepare SQL query for week-wise report
$sql_query = "";

if ($type == "income") {
    $sql_query = "SELECT 'Income' as type, date, category, amount, account FROM incomenew 
                  WHERE date BETWEEN '$start_date' AND '$end_date' AND user_email = '$user_email'";
} elseif ($type == "expense") {
    $sql_query = "SELECT 'Expense' as type, date, category, amount, account FROM expensesnew 
                  WHERE date BETWEEN '$start_date' AND '$end_date' AND user_email = '$user_email'";
} else {
    $sql_query = "(SELECT 'Income' as type, date, category, amount, account FROM incomenew 
                   WHERE date BETWEEN '$start_date' AND '$end_date' AND user_email = '$user_email')
                  UNION
                  (SELECT 'Expense' as type, date, category, amount, account FROM expensesnew 
                   WHERE date BETWEEN '$start_date' AND '$end_date' AND user_email = '$user_email')";
}

$result = mysqli_query($conn, $sql_query);

// Check for query errors
if (!$result) {
    die("Database Query Failed: " . mysqli_error($conn));
}

$i = 1;
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 25);
$pdf->Cell(190, 70, "Financial Management System", '', 0, 'C');
$pdf->Ln(60);
$pdf->SetFont('Arial', '', 18);
$pdf->Cell(40, 10, "Client Name: ", 0, 0, 'C');
$pdf->Cell(24, 10, "$name", 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(40, 10, "Current Date: ", 0, 0, 'C');
$pdf->Cell(45, 10, "$current_date", 0, 0, 'C');
$pdf->Ln(40);

$pdf->Cell(190, 10, "Report for Week:", 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(190, 10, "$date_range_formatted", 0, 0, 'C');
$pdf->Ln(50);

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(15, 10, "S.No.", 1, 0, 'C');
$pdf->Cell(30, 10, "Type", 1, 0, 'C');
$pdf->Cell(35, 10, "Date", 1, 0, 'C');
$pdf->Cell(40, 10, "Category", 1, 0, 'C');
$pdf->Cell(35, 10, "Account", 1, 0, 'C');
$pdf->Cell(35, 10, "Amount", 1, 0, 'C');
$pdf->Ln(10);

while ($row = mysqli_fetch_assoc($result)) {
    $pdf->Cell(15, 10, $i, 1, 0, 'C'); 
    $pdf->Cell(30, 10, $row['type'], 1, 0, 'C'); 
    $pdf->Cell(35, 10, $row['date'], 1, 0, 'C'); 
    $pdf->Cell(40, 10, $row['category'], 1, 0, 'C');
    $pdf->Cell(35, 10, $row['account'], 1, 0, 'C');    
    $pdf->Cell(35, 10, "$" . $row['amount'], 1, 0, 'C');    
    $pdf->Ln(10);   
    $i++;   
}

$pdf->Output();
?>
