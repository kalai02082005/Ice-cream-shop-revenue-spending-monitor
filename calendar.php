<?php 
require_once "include/header.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['email'])) {
    die("You need to log in to view and add income records.");
}

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "expense_management";

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = intval($_GET['month']);
    $year = intval($_GET['year']);
} else {
    $month = date('m');
    $year = date('Y');
}

$prevMonth = $month - 1;
$prevYear = $year;
if ($prevMonth < 1) {
    $prevMonth = 12;
    $prevYear--;
}

$nextMonth = $month + 1;
$nextYear = $year;
if ($nextMonth > 12) {
    $nextMonth = 1;
    $nextYear++;
}

$email = $_SESSION['email'];
$query = "SELECT * FROM incomenew WHERE MONTH(date) = '$month' AND YEAR(date) = '$year' AND user_email = '$_SESSION[email]'";
$result = mysqli_query($conn, $query);

$incomeRecords = [];
while ($row = mysqli_fetch_assoc($result)) {
    $day = date('j', strtotime($row['date']));
    $incomeRecords[$day][] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Income Calendar</title>
    <style>
        body{
            background: url(ice5.jpg) no-repeat;
            background-size: cover;
        }

h1 {
    margin-top: 20px;
    color: green; /* Dark Blue */
}

.navigation {
    margin: 20px 0;
}

.navigation a {
    display: inline-block;
    padding: 10px 20px;
   
    color: black;
    text-decoration: none;
    font-weight: bold;
    border-radius: 5px;
    transition: 0.3s;
}



table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
   
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    border: 4px solid #1e40af; /* Thick Blue Border */
}

th, td {
    border: 2px solid ; /* Medium Blue Border */
    padding: 12px;
    text-align: center;
    vertical-align: top;
}

th {
    background-color: #93c5fd; /* Light Blue */
    color: black;
    font-weight: bold;
}

td {
    height: 100px;
    width: 14%;
 /* Very Light Blue */
}

td strong {
    display: block;
    margin-bottom: 5px;
    color: green; /* Dark Blue */
}

td div {
    color: black; /* Green for Income Records */
    font-weight: bold;
    font-size: 14px;
}

    </style>
</head>
<body>
    <h1><?php echo date('F Y', strtotime("$year-$month-01")); ?></h1>
    <div class="navigation">
        <a href="?month=<?php echo $prevMonth; ?>&year=<?php echo $prevYear; ?>">&#9664; Previous</a>
        <a href="?month=<?php echo $nextMonth; ?>&year=<?php echo $nextYear; ?>">Next &#9654;</a>
    </div>
    <table border="3">
        <tr border="3">
            <th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th>
        </tr>
        <tr>
        <?php
        $firstDayOfMonth = date('w', strtotime("$year-$month-01"));
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        for ($i = 0; $i < $firstDayOfMonth; $i++) {
            echo "<td></td>";
        }
        for ($day = 1; $day <= $daysInMonth; $day++) {
            if (($day + $firstDayOfMonth - 1) % 7 == 0 && $day != 1) {
                echo "</tr><tr>";
            }
            echo "<td><strong>$day</strong><br>";
            if (isset($incomeRecords[$day])) {
                foreach ($incomeRecords[$day] as $record) {
                    echo "{$record['category']}: ₹{$record['amount']}<br>";
                }
            }
            echo "</td>";
        }
        echo "</tr>";
        ?>
    </table>
</body>
</html>
<?php require_once "include/footer.php"; ?>
