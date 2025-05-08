<?php
    require_once "include/header.php";
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php
    require "include/database-connection.php";

    $selectedMonthErr = "";
    $selectedMonth = "";
    $chartTypeErr = "";
    $chartType = "";
    $transactionTypeErr = "";
    $transactionType = "";
    $incomeData = [];
    $expenseData = [];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["expense_month"])) {
            $selectedMonthErr = "<p style='color:red'>* Please Select a Month</p>";
        } else {
            $selectedMonth = mysqli_real_escape_string($conn, trim($_POST["expense_month"]));
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

        if (!empty($selectedMonth) && !empty($chartType) && !empty($transactionType)) {
            $userEmail = mysqli_real_escape_string($conn, $_SESSION['email']);

            // Fetch Income Data for the Month
            if ($transactionType === "income" || $transactionType === "both") {
                $income_query = "SELECT category, SUM(amount) AS amount 
                                 FROM incomenew 
                                 WHERE DATE_FORMAT(date, '%Y-%m') = '$selectedMonth' AND user_email = '$userEmail'
                                 GROUP BY category";
                $income_result = mysqli_query($conn, $income_query);
                while ($row = mysqli_fetch_assoc($income_result)) {
                    $incomeData[] = $row;
                }
            }

            // Fetch Expense Data for the Month
            if ($transactionType === "expense" || $transactionType === "both") {
                $expense_query = "SELECT category, SUM(amount) AS amount 
                                  FROM expensesnew 
                                  WHERE DATE_FORMAT(date, '%Y-%m') = '$selectedMonth' AND user_email = '$userEmail'
                                  GROUP BY category";
                $expense_result = mysqli_query($conn, $expense_query);
                while ($row = mysqli_fetch_assoc($expense_result)) {
                    $expenseData[] = $row;
                }
            }

            if (empty($incomeData) && empty($expenseData)) {
                echo "<script>alert('No records found for the selected month.');</script>";
            }
        }
    }
?>

<div class="container mb-5">
    <div id="form" class="pt-5 form-input-content">
        <div class="card login-form mb-0">
            <div class="card-body pt-5 shadow">
                <h4 class="text-center">Month-wise Transaction Report</h4>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="form-group">
                        <label>Select A Month:</label>
                        <input type="month" class="form-control" name="expense_month">
                        <?php echo $selectedMonthErr; ?>
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
                            <option value="bar">Bar Chart</option>
                            <option value="pie">Pie Chart</option>
                            <option value="line">Line Chart</option>
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
    <script>
        const ctx = document.getElementById('transactionChart').getContext('2d');
        const chartType = '<?php echo $chartType; ?>';
        const transactionType = '<?php echo $transactionType; ?>';

        const incomeLabels = <?php echo json_encode(array_column($incomeData, 'category')); ?>;
        const incomeValues = <?php echo json_encode(array_column($incomeData, 'amount')); ?>.map(Number);

        const expenseLabels = <?php echo json_encode(array_column($expenseData, 'category')); ?>;
        const expenseValues = <?php echo json_encode(array_column($expenseData, 'amount')); ?>.map(Number);

        let labels = [];
        let datasets = [];

        if (transactionType === 'income' || transactionType === 'both') {
            labels = labels.concat(incomeLabels);
            datasets.push({
                label: 'Income',
                data: incomeValues,
                backgroundColor: chartType === 'line' ? 'rgba(75, 192, 192, 1)' : 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                fill: chartType !== 'line'
            });
        }

        if (transactionType === 'expense' || transactionType === 'both') {
            labels = labels.concat(expenseLabels);
            datasets.push({
                label: 'Expense',
                data: expenseValues,
                backgroundColor: chartType === 'line' ? 'rgba(255, 99, 132, 1)' : 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 2,
                fill: chartType !== 'line'
            });
        }

        new Chart(ctx, {
            type: chartType,
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Month-wise ' + transactionType.charAt(0).toUpperCase() + transactionType.slice(1) + ' Report'
                    }
                }
            }
        });
    </script>
<?php } ?>

<?php
    require_once "include/footer.php";
?>


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