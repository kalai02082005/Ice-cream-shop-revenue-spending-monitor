<?php
require_once "include/header.php";
require_once "include/database-connection.php";

date_default_timezone_set("Asia/Kolkata");

// Fetch dates
$current_date = date("Y-m-d");
$ten_days_ago = date("Y-m-d", strtotime("-10 days"));
$first_day_of_month = date("Y-m-01");

// Queries for summary
$queries = [
    'todayIncome' => "SELECT COALESCE(SUM(amount), 0) AS total FROM incomenew WHERE DATE(date) = '$current_date' AND user_email = '{$_SESSION['email']}'",
    'todayExpense' => "SELECT COALESCE(SUM(amount), 0) AS total FROM expensesnew WHERE DATE(date) = '$current_date' AND user_email = '{$_SESSION['email']}'",
    'last10DaysIncome' => "SELECT COALESCE(SUM(amount), 0) AS total FROM incomenew WHERE date BETWEEN '$ten_days_ago' AND '$current_date' AND user_email = '{$_SESSION['email']}'",
    'last10DaysExpense' => "SELECT COALESCE(SUM(amount), 0) AS total FROM expensesnew WHERE date BETWEEN '$ten_days_ago' AND '$current_date' AND user_email = '{$_SESSION['email']}'",
    'monthlyIncome' => "SELECT COALESCE(SUM(amount), 0) AS total FROM incomenew WHERE date BETWEEN '$first_day_of_month' AND '$current_date' AND user_email = '{$_SESSION['email']}'",
    'monthlyExpense' => "SELECT COALESCE(SUM(amount), 0) AS total FROM expensesnew WHERE date BETWEEN '$first_day_of_month' AND '$current_date' AND user_email = '{$_SESSION['email']}'"
];

$summaryData = [];
foreach ($queries as $key => $query) {
    $result = mysqli_query($conn, $query);
    $summaryData[$key] = mysqli_fetch_assoc($result)['total'] ?? 0;
}

// Fetch last 10 days' income and expenses for line chart
$dates = [];
$incomeData = [];
$expenseData = [];

for ($i = 9; $i >= 0; $i--) {
    $date = date("Y-m-d", strtotime("-$i days"));
    $dates[] = date("jS M", strtotime($date));
    
    $sql_income = "SELECT COALESCE(SUM(amount), 0) AS total FROM incomenew WHERE DATE(date) = '$date' AND user_email = '{$_SESSION['email']}'";
    $sql_expense = "SELECT COALESCE(SUM(amount), 0) AS total FROM expensesnew WHERE DATE(date) = '$date' AND user_email = '{$_SESSION['email']}'";
    
    $result_income = mysqli_query($conn, $sql_income);
    $result_expense = mysqli_query($conn, $sql_expense);
    
    $incomeData[] = mysqli_fetch_assoc($result_income)['total'] ?? 0;
    $expenseData[] = mysqli_fetch_assoc($result_expense)['total'] ?? 0;
}

// Fetch total income and expense by category for bar chart
$sql_income_by_category = "SELECT category, COALESCE(SUM(amount), 0) AS total FROM incomenew WHERE user_email = '{$_SESSION['email']}' GROUP BY category";
$sql_expense_by_category = "SELECT category, COALESCE(SUM(amount), 0) AS total FROM expensesnew WHERE user_email = '{$_SESSION['email']}' GROUP BY category";

$result_income_by_category = mysqli_query($conn, $sql_income_by_category);
$result_expense_by_category = mysqli_query($conn, $sql_expense_by_category);

$incomeCategories = [];
$incomeAmounts = [];
while ($row = mysqli_fetch_assoc($result_income_by_category)) {
    $incomeCategories[] = $row['category'];
    $incomeAmounts[] = $row['total'];
}

$expenseCategories = [];
$expenseAmounts = [];
while ($row = mysqli_fetch_assoc($result_expense_by_category)) {
    $expenseCategories[] = $row['category'];
    $expenseAmounts[] = $row['total'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* Global Styles */
        body {
          background: white;
            color: #fff;
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
        }

        .summary-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .summary-box {
            background: black;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .summary-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .summary-box i {
            font-size: 30px;
            margin-bottom: 10px;
            color: #ff6b6b;
        }

        .summary-box h3 {
            margin: 0;
            font-size: 18px;
            color: #ff6b6b;
        }

        .summary-box p {
            margin: 10px 0 0;
            font-size: 24px;
            font-weight: bold;
        }

        .chart-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            padding: 20px;
        }

        canvas {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 15px;
            padding: 20px;
            margin: 10px;
            max-width: 45%;
            height: 300px !important;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .summary-container {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            canvas {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="summary-container">
        <div class="summary-box">
            <i class="fas fa-money-bill-wave"></i>
            <h3>Today's Income</h3>
            <p>₹<?php echo number_format($summaryData['todayIncome'], 2); ?></p>
        </div>
        <div class="summary-box">
            <i class="fas fa-shopping-cart"></i>
            <h3>Today's Expense</h3>
            <p>₹<?php echo number_format($summaryData['todayExpense'], 2); ?></p>
        </div>
        <div class="summary-box">
            <i class="fas fa-calendar-day"></i>
            <h3>Last 10 Days Income</h3>
            <p>₹<?php echo number_format($summaryData['last10DaysIncome'], 2); ?></p>
        </div>
        <div class="summary-box">
            <i class="fas fa-calendar-week"></i>
            <h3>Last 10 Days Expense</h3>
            <p>₹<?php echo number_format($summaryData['last10DaysExpense'], 2); ?></p>
        </div>
        <div class="summary-box">
            <i class="fas fa-wallet"></i>
            <h3>This Month's Income</h3>
            <p>₹<?php echo number_format($summaryData['monthlyIncome'], 2); ?></p>
        </div>
        <div class="summary-box">
            <i class="fas fa-credit-card"></i>
            <h3>This Month's Expense</h3>
            <p>₹<?php echo number_format($summaryData['monthlyExpense'], 2); ?></p>
        </div>
    </div>

    <div class="chart-container">
        <canvas id="lineChart"></canvas>
        <canvas id="barChart"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const lineChartData = {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [
                {
                    label: 'Income',
                    data: <?php echo json_encode($incomeData); ?>,
                    borderColor: '#4caf50',
                    backgroundColor: 'rgba(76, 175, 80, 0.2)',
                    fill: true
                },
                {
                    label: 'Expense',
                    data: <?php echo json_encode($expenseData); ?>,
                    borderColor: '#ff6b6b',
                    backgroundColor: 'rgba(255, 107, 107, 0.2)',
                    fill: true
                }
            ]
        };

        const barChartData = {
            labels: <?php echo json_encode(array_merge($incomeCategories, $expenseCategories)); ?>,
            datasets: [
                {
                    label: 'Income',
                    data: <?php echo json_encode($incomeAmounts); ?>,
                    backgroundColor: '#4caf50'
                },
                {
                    label: 'Expense',
                    data: <?php echo json_encode($expenseAmounts); ?>,
                    backgroundColor: '#ff6b6b'
                }
            ]
        };

        new Chart(document.getElementById('lineChart'), { type: 'line', data: lineChartData });
        new Chart(document.getElementById('barChart'), { type: 'bar', data: barChartData });
    </script>
</body>
</html>

<?php require_once "include/footer.php"; ?>