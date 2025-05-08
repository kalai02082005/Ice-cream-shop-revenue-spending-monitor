<?php
require_once "include/header.php";
require_once "include/database-connection.php";

// Check if user is logged in
if (!isset($_SESSION["email"])) {
    die("<p style='color:red'>You must be logged in to manage income.</p>");
}

$email = $_SESSION["email"];
$message = "";

// Handle Form Submission for Adding Income
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_income"])) {
    $income_date = trim($_POST["income_date"]);
    $income_category = trim($_POST["income_category"]);
    $income_amount = trim($_POST["income_amount"]);
    $income_account = trim($_POST["income_account"]);
    $income_description = trim($_POST["income_description"]);

    if (!empty($income_date) && !empty($income_category) && !empty($income_amount) && is_numeric($income_amount) && !empty($income_account)) {
        // Insert income record safely using prepared statements
        $stmt = $conn->prepare("INSERT INTO incomenew (user_email, category, amount, account, date, description) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsss", $email, $income_category, $income_amount, $income_account, $income_date, $income_description);

        if ($stmt->execute()) {
            $message = "<div class='alert alert-success'>Income added successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger'>Error adding income. Please try again.</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='alert alert-danger'>Please fill all fields correctly.</div>";
    }
}

// Handle Form Submission for Adding New Category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_category"])) {
    $new_category = trim($_POST["new_category"]);

    if (!empty($new_category)) {
        $stmt = $conn->prepare("INSERT INTO income_categories_new (category_name) VALUES (?)");
        $stmt->bind_param("s", $new_category);

        if ($stmt->execute()) {
            $message .= "<div class='alert alert-success'>Category added successfully!</div>";
        } else {
            $message .= "<div class='alert alert-danger'>Error adding category. Please try again.</div>";
        }
        $stmt->close();
    } else {
        $message .= "<div class='alert alert-danger'>Please enter a category name.</div>";
    }
}

// Handle Form Submission for Adding New Account
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_account"])) {
    $new_account = trim($_POST["new_account"]);

    if (!empty($new_account)) {
        $stmt = $conn->prepare("INSERT INTO income_accounts_new (account_name) VALUES (?)");
        $stmt->bind_param("s", $new_account);

        if ($stmt->execute()) {
            $message .= "<div class='alert alert-success'>Account added successfully!</div>";
        } else {
            $message .= "<div class='alert alert-danger'>Error adding account. Please try again.</div>";
        }
        $stmt->close();
    } else {
        $message .= "<div class='alert alert-danger'>Please enter an account name.</div>";
    }
}
?>

<div class="container">
    <?php echo $message; ?>

    <!-- Form to Add Income -->
    <div class="form-input-content m-5">
        <div class="card login-form mb-0">
            <div class="card-body pt-5 shadow">
                <h4 class="text-center">Add Income</h4>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="form-group">
                        <label>Date:</label>
                        <input type="date" class="form-control" name="income_date" required>
                    </div>
                    <div class="form-group">
                        <label>Category:</label>
                        <select class="form-control" name="income_category" required>
                            <?php
                            $category_query = "SELECT category_name FROM income_categories_new";
                            $result = $conn->query($category_query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['category_name']}'>{$row['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Account:</label>
                        <select class="form-control" name="income_account" required>
                            <?php
                            $account_query = "SELECT account_name FROM income_accounts_new";
                            $result = $conn->query($account_query);
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='{$row['account_name']}'>{$row['account_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Amount ($):</label>
                        <input type="number" class="form-control" name="income_amount" min="0" required>
                    </div>
                    <div class="form-group">
                        <label>Description:</label>
                        <textarea class="form-control" name="income_description"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Add Income" class="btn btn-success" name="add_income">
                    </div>
                </form>
               

            </div>
        </div>
    </div>
</div>





<?php
require_once "include/footer.php";
?>

<style>
    body {
    background: url(ice2.jpg) no-repeat;
    background-size: cover;
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 30px auto;
    text-align: center;
}

h4 {
    color: #343a40;
    margin-bottom: 20px;
}

.form-group {
    text-align: left;
    margin-bottom: 15px;
    color: #333;
}

.form-control {
    border-radius: 5px;
    padding: 10px;
    border: 1px solid #ccc;
    width: 100%;
    background-color: #f9f9f9;
    color: #333;
}

.btn-success {
    background-color: #28a745;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

.btn-success:hover {
    background-color: #218838;
}

.alert {
    padding: 10px;
    border-radius: 5px;
    text-align: center;
    background-color: #ffebcc;
    color: #b5651d;
}

/* Ice Cream Image Styling */
.ice-cream-img {
    width: 100px;
    height: auto;
    position: absolute;
    top: -30px;
    right: -30px;
}

    
</style>