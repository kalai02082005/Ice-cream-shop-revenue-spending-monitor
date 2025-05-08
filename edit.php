<?php
require_once "include/header.php";
require_once "include/database-connection.php";

if (!isset($_SESSION["email"])) {
    die("<p style='color:red'>You must be logged in to manage expenses.</p>");
}

$email = $_SESSION["email"];

// Handle Delete Action
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM expensesnew WHERE id = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        echo "<script>alert('Expense deleted successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error deleting expense.');</script>";
    }
    $stmt->close();
}

// Handle Update Expense
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_expense"])) {
    $id = $_POST["id"];
    $date = $_POST["date"];
    $category = $_POST["category"];
    $amount = $_POST["amount"];
    $account = $_POST["account"];
    $description = $_POST["description"];

    $sql = "UPDATE expensesnew SET date = ?, category = ?, amount = ?, account = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdsdi", $date, $category, $amount, $account, $description, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Expense updated successfully!'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error updating expense.');</script>";
    }
    $stmt->close();
}

// Fetch Expenses
$sql_expense = "SELECT * FROM expensesnew WHERE user_email = ? ORDER BY date";
$stmt = $conn->prepare($sql_expense);
$stmt->bind_param("s", $email);
$stmt->execute();
$result_expense = $stmt->get_result();
?>

<div class="container bg-light shadow mt-5">
    <h2>EXPENSE REPORT</h2>

    <table class="table table-bordered table-hover border-primary">
        <thead>
            <tr>
                <th>S.No.</th>
                <th>Date</th>
                <th>Category</th>
                <th>Amount ($)</th>
                <th>Account</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            while ($row = $result_expense->fetch_assoc()) {
                $id = $row["id"];
                $date = $row["date"];
                $category = $row["category"];
                $amount = $row["amount"];
                $account = $row["account"];
                $description = $row["description"];
            ?>
                <tr>
                    <th><?= $i++ ?>.</th>
                    <td><?= date("jS F", strtotime($date)) ?></td>
                    <td><?= htmlspecialchars($category) ?></td>
                    <td><?= htmlspecialchars($amount) ?></td>
                    <td><?= htmlspecialchars($account) ?></td>
                    <td><?= htmlspecialchars($description) ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="openEditModal('<?= $id ?>', '<?= $date ?>', '<?= $category ?>', '<?= $amount ?>', '<?= $account ?>', '<?= $description ?>')">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="?delete_id=<?= $id ?>" class="btn btn-danger btn-sm ml-2" onclick="return confirm('Are you sure?')">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Edit Expense Modal -->
<div class="modal fade" id="editExpenseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Expense</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST">
                    <input type="hidden" id="editExpenseId" name="id">
                    <div class="mb-3">
                        <label>Date:</label>
                        <input type="date" class="form-control" id="editExpenseDate" name="date" required>
                    </div>
                    <div class="mb-3">
                        <label>Category:</label>
                        <input type="text" class="form-control" id="editExpenseCategory" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label>Amount:</label>
                        <input type="number" class="form-control" id="editExpenseAmount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label>Account:</label>
                        <input type="text" class="form-control" id="editExpenseAccount" name="account" required>
                    </div>
                    <div class="mb-3">
                        <label>Description:</label>
                        <textarea class="form-control" id="editExpenseDescription" name="description" required></textarea>
                    </div>
                    <button type="submit" name="update_expense" class="btn btn-success w-100">Update Expense</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Modal -->
<script>
function openEditModal(id, date, category, amount, account, description) {
    document.getElementById("editExpenseId").value = id;
    document.getElementById("editExpenseDate").value = date;
    document.getElementById("editExpenseCategory").value = category;
    document.getElementById("editExpenseAmount").value = amount;
    document.getElementById("editExpenseAccount").value = account;
    document.getElementById("editExpenseDescription").value = description;
    new bootstrap.Modal(document.getElementById("editExpenseModal")).show();
}
</script>

<?php require_once "include/footer.php"; ?>
