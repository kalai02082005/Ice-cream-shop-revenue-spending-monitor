<?php
require_once "include/header.php";
require_once "include/database-connection.php";

// Initialize message variable
$message = "";

// Check if user is logged in
if (!isset($_SESSION["email"])) {
    die("<p style='color:red'>You must be logged in to manage expenses.</p>");
}

$email = $_SESSION["email"];
$i = 1;
$id = $date = $category = $amount = $account = $description = "";

// Handle Delete Action
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Convert to integer to prevent SQL injection
    $delete_sql = "DELETE FROM expensesnew WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        $message = "<div class='alert alert-success'>Expense record deleted successfully!</div>";
    } else {
        $message = "<div class='alert alert-danger'>Error deleting expense record. Please try again.</div>";
    }

    $stmt->close();
}

// Handle Search Functionality
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql_expense = "SELECT * FROM expensesnew WHERE user_email = ? AND (category LIKE ? OR account LIKE ? OR description LIKE ?) ORDER BY date";
    $stmt = $conn->prepare($sql_expense);
    $searchTerm = "%" . $search . "%";
    $stmt->bind_param("ssss", $email, $searchTerm, $searchTerm, $searchTerm);
} else {
    $sql_expense = "SELECT * FROM expensesnew WHERE user_email = ? ORDER BY date";
    $stmt = $conn->prepare($sql_expense);
    $stmt->bind_param("s", $email);
}

$stmt->execute();
$result_expense = $stmt->get_result();
$row_expense = $result_expense->num_rows;
?>

<div class="container bg-light shadow mt-5">
    <?php echo $message; ?>

    <h2>EXPENSE REPORT</h2>

    <!-- Search Form -->
    <form method="GET" class="search-form">
        <input type="text" name="search" class="form-control" placeholder="Search by category, account, or description" value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>

    <table class="table table-bordered table-hover border-primary">
        <thead>
            <tr>
                <th scope="col">S.No.</th>
                <th scope="col">Date</th>
                <th scope="col">Category</th>
                <th scope="col">Amount ($)</th>
                <th scope="col">Account</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($row_expense > 0) {
                $i = 1;
                while ($row = $result_expense->fetch_assoc()) {
                    $id = htmlspecialchars($row["id"]);
                    $date = htmlspecialchars($row["date"]);
                    $datef = date("jS F", strtotime($date));
                    $category = htmlspecialchars($row["category"]);
                    $amount = htmlspecialchars($row["amount"]);
                    $account = htmlspecialchars($row["account"]);
                    $description = htmlspecialchars($row["description"]);

                    $edit = "<a href='edit.php?id={$id}' class='btn-sm btn-primary'><i class='fa fa-edit'></i></a>";
                    $bin = "<a href='?delete_id={$id}' class='btn-sm btn-danger ml-2'><i class='fa fa-trash'></i></a>";

                    echo "<tr><th>{$i}.</th><td>{$datef}</td><td>{$category}</td><td>{$amount}</td><td>{$account}</td><td>{$description}</td><td>{$bin} {$edit}</td></tr>";
                    $i++;
                }
            } else {
                echo "<tr><td colspan='7' class='text-center text-danger'>No matching records found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php require_once "include/footer.php"; ?>

<!-- CSS Styling -->
<style>
/* General Page Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 0;
    padding: 0;
    background: url(ice2.jpg) no-repeat;
    background-size: cover;
}

.container {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Search Form */
.search-form {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 20px;
}

.search-form input {
    width: 35%;
    padding: 6px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
}

.search-form button {
    margin-left: 8px;
    padding: 6px 12px;
    font-size: 14px;
    border-radius: 5px;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table th, table td {
    padding: 12px;
    text-align: center;
    border: 1px solid #ddd;
}

table thead {
    background-color: #007bff;
    color: white;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

/* Buttons */
.btn-sm {
    padding: 5px 10px;
    font-size: 14px;
    border-radius: 5px;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background-color: #007bff;
    color: white;
    border: none;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
    border: none;
}

.btn-sm:hover {
    opacity: 0.8;
}

/* Responsive Design */
@media (max-width: 768px) {
    .search-form {
        flex-direction: column;
        gap: 5px;
    }

    .search-form input {
        width: 100%;
    }

    table th, table td {
        padding: 8px;
        font-size: 14px;
    }

    .btn-sm {
        font-size: 12px;
        padding: 4px 8px;
    }
}
</style>
