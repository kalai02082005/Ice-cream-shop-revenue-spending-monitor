<?php
require_once "include/header.php";
require "include/database-connection.php"; // Ensure database connection is included

$selectedDateErr = "";
$selectedDate = "";
$chartTypeErr = "";
$chartType = "";
$transactionTypeErr = "";
$transactionType = "";
$incomeData = [];
$expenseData = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["expense_date"])) {
        $selectedDateErr = "<p style='color:red'>* Please Select a Date</p>";
    } else {
        $selectedDate = mysqli_real_escape_string($conn, trim($_POST["expense_date"]));
    }

    if (empty($_POST["chart_type"])) {
        $chartTypeErr = "<p style='color:red'>* Please Select a Chart Type</p>";
    } else {
        $chartType = mysqli_real_escape_string($conn, trim($_POST["chart_type"]));
    }

    if (empty($_POST["transaction_type"])) {
        $transactionTypeErr = "<p style='color:red'>* Please Select Income, Expense, or Both</p>";
    } else {
        $transactionType = mysqli_real_escape_string($conn, trim($_POST["transaction_type"]));
    }

    if (!empty($selectedDate) && !empty($chartType) && !empty($transactionType)) {
        $userEmail = mysqli_real_escape_string($conn, $_SESSION['email']);

        // Get the week number and year of the selected date
        $week_number = date('oW', strtotime($selectedDate));

        // Fetch Income Data for the week
        if ($transactionType === "income" || $transactionType === "both") {
            $income_query = "SELECT DATE_FORMAT(date, '%Y-%m-%d') AS day, category, SUM(amount) AS amount 
                             FROM incomenew 
                             WHERE YEARWEEK(date, 1) = '$week_number' AND user_email = '$userEmail'
                             GROUP BY day, category 
                             ORDER BY day";
            $income_result = mysqli_query($conn, $income_query);
            while ($row = mysqli_fetch_assoc($income_result)) {
                $incomeData[] = $row;
            }
        }

        // Fetch Expense Data for the week
        if ($transactionType === "expense" || $transactionType === "both") {
            $expense_query = "SELECT DATE_FORMAT(date, '%Y-%m-%d') AS day, category, SUM(amount) AS amount 
                              FROM expensesnew 
                              WHERE YEARWEEK(date, 1) = '$week_number' AND user_email = '$userEmail'
                              GROUP BY day, category 
                              ORDER BY day";
            $expense_result = mysqli_query($conn, $expense_query);
            while ($row = mysqli_fetch_assoc($expense_result)) {
                $expenseData[] = $row;
            }
        }

        if (empty($incomeData) && empty($expenseData)) {
            echo "<script>alert('No records found for the selected week.');</script>";
        }
    }
}
?>

<div class="container mb-5">
    <div id="form" class="pt-5 form-input-content">
        <div class="card login-form mb-0">
            <div class="card-body pt-5 shadow">
                <h4 class="text-center">Week-wise Transaction Report</h4>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="form-group">
                        <label>Select A Date:</label>
                        <input type="date" class="form-control" name="expense_date">
                        <?php echo $selectedDateErr; ?>
                    </div>

                    <div class="form-group">
                        <label>Select Transaction Type:</label>
                        <select class="form-control" name="transaction_type">
                            <option value="">Select Type</option>
                            <option value="income">Income</option>
                            <option value="expense">Expense</option>
                            <option value="both">Both</option>
                        </select>
                        <?php echo $transactionTypeErr; ?>
                    </div>

                    <div class="form-group">
                        <label>Select Chart Type:</label>
                        <select class="form-control" name="chart_type">
                            <option value="">Select Chart Type</option>
                            <option value="line">Line Chart</option>
                            <option value="bar">Bar Chart</option>
                            <option value="pie">Pie Chart</option>
                        </select>
                        <?php echo $chartTypeErr; ?>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Show Report" class="btn login-form__btn submit w-100" name="submit_expense">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($incomeData) || !empty($expenseData)) { ?>
    <div class="container">
        <canvas id="transactionChart" width="400" height="200"></canvas>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('transactionChart').getContext('2d');
        const chartType = '<?php echo $chartType; ?>';

        const incomeData = <?php echo json_encode($incomeData); ?>;
        const expenseData = <?php echo json_encode($expenseData); ?>;

        let dates = [...new Set([...incomeData.map(d => d.day), ...expenseData.map(d => d.day)])];

        let incomeCategories = [...new Set(incomeData.map(d => d.category))];
        let expenseCategories = [...new Set(expenseData.map(d => d.category))];

        let incomeDatasets = incomeCategories.map(category => ({
            label: "Income - " + category,
            data: dates.map(date => {
                let record = incomeData.find(d => d.day === date && d.category === category);
                return record ? parseFloat(record.amount) : 0;
            }),
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }));

        let expenseDatasets = expenseCategories.map(category => ({
            label: "Expense - " + category,
            data: dates.map(date => {
                let record = expenseData.find(d => d.day === date && d.category === category);
                return record ? parseFloat(record.amount) : 0;
            }),
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }));

        new Chart(ctx, {
            type: chartType,
            data: {
                labels: dates,
                datasets: [...incomeDatasets, ...expenseDatasets]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Week-wise Transaction Report'
                    }
                }
            }
        });

        // Debugging Output
        console.log("Dates:", dates);
        console.log("Income Data:", incomeData);
        console.log("Expense Data:", expenseData);
    </script>
<?php } ?>

<?php require_once "include/footer.php"; ?>


<style>
    body {
    background: url('ice2.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: Arial, sans-serif;
}

.container {
    width: 90%;
    margin: 20px auto;
}



h4 {
    text-align: center;
    color: #333;
    font-weight: bold;
}

.form-group label {
    font-weight: bold;
    color: #333;
}

.form-control {
    border-radius: 5px;
    padding: 8px;
}

.btn {
    background-color: #007bff;
    color: white;
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
    font-weight: bold;
}

.btn:hover {
    background-color: #0056b3;
}

canvas {
    background: rgba(255, 255, 255, 0.8);
    border-radius: 10px;
    padding: 10px;
}

</style>