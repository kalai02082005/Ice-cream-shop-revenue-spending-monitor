<?php
require_once "include/header.php";
require_once "include/database-connection.php";

// Handle adding a new account
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_name = trim($_POST["account_name"] ?? '');
    $account_type = $_POST["account_type"] ?? '';

    if (!empty($account_name) && in_array($account_type, ['income', 'expense'])) {
        $table = $account_type === 'income' ? 'income_accounts_new' : 'expenses_accounts_new';
        
        $stmt = $conn->prepare("INSERT INTO $table (account_name) VALUES (?)");
        $stmt->bind_param("s", $account_name);
        
        if ($stmt->execute()) {
            echo "<script>alert('Account added successfully!'); window.location.href = 'accounts_category.php';</script>";
        } else {
            echo "<script>alert('Error: Account might already exist.');</script>";
        }
        $stmt->close();
    }
}

// Fetch search term
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch income accounts
$income_query = "SELECT * FROM income_accounts_new ORDER BY account_name ASC";
if ($search) {
    $income_query = "SELECT * FROM income_accounts_new WHERE account_name LIKE '%$search%' ORDER BY account_name ASC";
}
$income_accounts = $conn->query($income_query);

// Fetch expense accounts
$expense_query = "SELECT * FROM expenses_accounts_new ORDER BY account_name ASC";
if ($search) {
    $expense_query = "SELECT * FROM expenses_accounts_new WHERE account_name LIKE '%$search%' ORDER BY account_name ASC";
}
$expense_accounts = $conn->query($expense_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Accounts</title>
    <style>
        body { font-family: Arial, sans-serif; }
        h2 { color: #1e3a8a; margin-bottom: 20px; text-align: center; }
        .form-container { display: flex; justify-content: center; gap: 15px; margin-bottom: 20px; }
        .add-account-form, .search-form { display: flex; gap: 10px; }
        input[type="text"], select { padding: 10px; border: 2px solid #1e3a8a; border-radius: 5px; font-size: 16px; }
        button { padding: 10px 15px; background-color: #3b82f6; color: white; border: none; cursor: pointer; border-radius: 5px; font-size: 16px; }
        button:hover { background-color: #2563eb; }
        table { width: 70%; margin: 0 auto 20px auto; border-collapse: collapse; background: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px; border: 1px solid #1e3a8a; text-align: left; font-size: 16px; }
        th { background: #93c5fd; color: #1e3a8a; }
        tr:nth-child(even) { background: #f9fafb; }
        .delete-btn { background: red; color: white; padding: 8px 12px; border-radius: 5px; text-decoration: none; font-size: 14px; }
        .delete-btn:hover { background: darkred; }
        body{
    background: url(ice5.jpg) no-repeat;
    background-size: cover;
 }
    </style>
</head>
<body>

    <h2>Manage Income & Expense Accounts</h2>

    <div class="form-container">
        <!-- Add Account Form -->
        <form method="POST" class="add-account-form">
            <input type="text" name="account_name" placeholder="Enter Account Name" required>
            <select name="account_type">
                <option value="income">Income</option>
                <option value="expense">Expense</option>
            </select>
            <button type="submit">Add Account</button>
        </form>

        <!-- Search Form -->
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search Account" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <!-- Income Accounts Table -->
    <h2>Income Accounts</h2>
    <table>
        <tr>
            <th>Account Name</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $income_accounts->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['account_name']); ?></td>
                <td>
                    <a href="delete_accounts.php?id=<?php echo $row['id']; ?>&type=income" class="delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this income account?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Expense Accounts Table -->
    <h2>Expense Accounts</h2>
    <table>
        <tr>
            <th>Expense Account Name</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $expense_accounts->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['account_name']); ?></td>
                <td>
                    <a href="delete_accounts.php?id=<?php echo $row['id']; ?>&type=expense" class="delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this expense account?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>

<?php 
$conn->close();
require_once "include/footer.php"; 
?>
