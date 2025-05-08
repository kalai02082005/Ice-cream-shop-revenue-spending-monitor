<?php
require_once "include/header.php";
require_once "include/database-connection.php";

// Check if user is logged in
if (!isset($_SESSION["email"])) {
    die("<p style='color:red'>You must be logged in to manage expenses.</p>");
}

$email = $_SESSION["email"];
$message = "";

// Handle form submission for setting the monthly limit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["set_limit"])) {
    $limit_amount = trim($_POST["limit_amount"]);
    if (!empty($limit_amount) && is_numeric($limit_amount) && $limit_amount > 0) {
        // Insert or update the expense limit
        $stmt = $conn->prepare("INSERT INTO monthly_expense_limits (user_email, limit_amount) VALUES (?, ?) ON DUPLICATE KEY UPDATE limit_amount = ?");
        $stmt->bind_param("sdd", $email, $limit_amount, $limit_amount);
        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Monthly limit set successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error setting limit. Please try again.</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert alert-danger'>Please enter a valid amount.</div>";
    }
}

// Retrieve the current month's total expenses
$current_month = date("Y-m");
$stmt = $conn->prepare("SELECT SUM(amount) FROM expensesnew WHERE user_email = ? AND DATE_FORMAT(date, '%Y-%m') = ?");
$stmt->bind_param("ss", $email, $current_month);
$stmt->execute();
$stmt->bind_result($total_expense);
$stmt->fetch();
$stmt->close();
$total_expense = $total_expense ?: 0;

// Retrieve the user's expense limit
$stmt = $conn->prepare("SELECT limit_amount FROM monthly_expense_limits WHERE user_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->bind_result($expense_limit);
$stmt->fetch();
$stmt->close();
$expense_limit = $expense_limit ?: 0;

// Calculate remaining balance
$remaining_limit = $expense_limit - $total_expense;

// Calculate percentage spent
$percentage_spent = $expense_limit > 0 ? ($total_expense / $expense_limit) * 100 : 0;

// Prevent adding expense if it exceeds the limit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_expense"])) {
    $expense_date = trim($_POST["expense_date"]);
    $expense_category = trim($_POST["expense_category"]);
    $expense_amount = trim($_POST["expense_amount"]);
    $expense_account = trim($_POST["expense_account"]);
    $expense_description = trim($_POST["expense_description"]);

    if (!empty($expense_date) && !empty($expense_category) && !empty($expense_amount) && is_numeric($expense_amount) && !empty($expense_account)) {
        if (($total_expense + $expense_amount) > $expense_limit) {
            $remaining_balance = $expense_limit - $total_expense;
            $message = "<div class='alert alert-danger'>Expense exceeds the monthly limit! Remaining limit: $" . number_format($remaining_balance, 2) . "</div>";
        } else {
            // Insert expense record safely using prepared statements
            $stmt = $conn->prepare("INSERT INTO expensesnew (user_email, category, amount, account, date, description) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdsss", $email, $expense_category, $expense_amount, $expense_account, $expense_date, $expense_description);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Expense added successfully!</div>";
            } else {
                $message = "<div class='alert alert-danger'>Error adding expense. Please try again.</div>";
            }
            $stmt->close();
        }
    } else {
        $message = "<div class='alert alert-danger'>Please fill all fields correctly.</div>";
    }
}
?>

<div class="container">
    <?php echo $message; ?>
    <h2>Set Monthly Expense Limit</h2>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label>Monthly Limit ($):</label>
        <input type="number" name="limit_amount" class="form-control" min="0" required value="<?php echo htmlspecialchars($expense_limit); ?>">
        <br>
        <input type="submit" value="Set Limit" class="btn btn-primary" name="set_limit">
    </form>

    <h3>Monthly Expense Overview</h3>
    <p>Total Expenses: <strong>$<?php echo number_format($total_expense, 2); ?></strong></p>
    <p>Expense Limit: <strong>$<?php echo number_format($expense_limit, 2); ?></strong></p>
    <p>Remaining Limit: <strong>$<?php echo number_format($remaining_limit, 2); ?></strong></p>
    
    <div class="progress">
        <div class="progress-bar <?php echo ($percentage_spent >= 100) ? 'bg-danger' : 'bg-success'; ?>" role="progressbar" style="width: <?php echo min(100, $percentage_spent); ?>%">
            <?php echo round($percentage_spent, 2); ?>%
        </div>
    </div>
</div>

<?php require_once "include/footer.php"; ?>


<style>

body{
    background: url(ice5.jpg) no-repeat;
    background-size: cover;
 }
.container {
    max-width: 600px;
    background: #ffffff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
}

/* Form Styles */
form {
    margin-top: 10px;
}

input, select, textarea {
    width: 100%;
    padding: 12px;
    margin: 8px 0;
    border: 2px solid #ccc;
    border-radius: 8px;
    font-size: 16px;
    transition: border 0.3s ease;
}

input:focus, select:focus, textarea:focus {
    border-color: #007bff;
    outline: none;
}

/* Buttons */
button, input[type="submit"] {
    width: 100%;
    padding: 12px;
    background-color: #007bff;
    border: none;
    color: white;
    font-size: 16px;
    font-weight: bold;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover, input[type="submit"]:hover {
    background-color: #0056b3;
}

/* Alert Messages */
.alert {
    padding: 12px;
    margin: 15px 0;
    border-radius: 8px;
    font-size: 14px;
}

.alert-success {
    background-color: #d4edda;
    color: #155724;
}

.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
}

/* Progress Bar */
.progress {
    background-color: #ddd;
    border-radius: 8px;
    overflow: hidden;
    height: 30px;
    margin: 15px 0;
}

.progress-bar {
    height: 100%;
    text-align: center;
    line-height: 30px;
    color: white;
    font-weight: bold;
    border-radius: 8px;
}

.bg-success {
    background: linear-gradient(to right, #28a745, #1e7e34);
}

.bg-danger {
    background: linear-gradient(to right, #dc3545, #a71d2a);
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        width: 90%;
        padding: 15px;
    }
    
    input, select, textarea {
        font-size: 14px;
    }
}

</style>