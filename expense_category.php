<?php
require_once "include/header.php";
require_once "include/database-connection.php";

// Handle adding a new category
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["category_name"])) {
    $category_name = trim($_POST["category_name"]);
    if (!empty($category_name)) {
        $stmt = $conn->prepare("INSERT INTO expenses_categories_new (category_name) VALUES (?)");
        $stmt->bind_param("s", $category_name);
        if ($stmt->execute()) {
            echo "<script>alert('Category added successfully!'); window.location.href = 'expense_category.php';</script>";
        } else {
            echo "<script>alert('Error: Category might already exist.');</script>";
        }
        $stmt->close();
    }
}

// Fetch categories
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
if ($search) {
    $stmt = $conn->prepare("SELECT * FROM expenses_categories_new WHERE category_name LIKE ? ORDER BY category_name ASC");
    $likeSearch = "%" . $search . "%";
    $stmt->bind_param("s", $likeSearch);
    $stmt->execute();
    $categories = $stmt->get_result();
    $stmt->close();
} else {
    $categories = $conn->query("SELECT * FROM expenses_categories_new ORDER BY category_name ASC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Categories</title>
    <style>
        /* General Styles */
       
        body{
    background: url(ice5.jpg) no-repeat;
    background-size: cover;
 }
        /* Heading */
        h2 {
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        /* Form Container */
        .form-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 70%;
            margin: 0 auto 20px auto;
        }

        /* Add Category Form (Left Side) */
        .add-category-form {
            display: flex;
            gap: 10px;
        }

        input[type="text"] {
            padding: 10px;
            width: 250px;
            border: 2px solid #1e3a8a;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            padding: 10px 15px;
            background-color: #3b82f6;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
        }

        button:hover {
            background-color: #2563eb;
        }

        /* Search Form (Right Side) */
        .search-form {
            display: flex;
            gap: 10px;
        }

        /* Table Styles */
        table {
            width: 70%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            border: 1px solid #1e3a8a;
            text-align: left;
            font-size: 16px;
        }

        th {
            background: #93c5fd;
            color: #1e3a8a;
        }

        tr:nth-child(even) {
            background: #f9fafb;
        }

        /* Delete Button */
        .delete-btn {
            background: red;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }

        .delete-btn:hover {
            background: darkred;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .form-container {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .add-category-form,
            .search-form {
                width: 100%;
                justify-content: center;
            }

            table {
                width: 90%;
            }
        }
    </style>
</head>
<body>

    <h2>Manage Expense Categories</h2>

    <div class="form-container">
        <!-- Add Category Form (Left Side) -->
        <form method="POST" class="add-category-form">
            <input type="text" name="category_name" placeholder="Enter Category Name" required>
            <button type="submit">Add Category</button>
        </form>

        <!-- Search Form (Right Side) -->
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search Category" value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit">Search</button>
        </form>
    </div>

    <table>
        <tr>
            <th>Category Name</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $categories->fetch_assoc()) : ?>
            <tr>
                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                <td>
                    <a href="delete_category_ex.php?id=<?php echo $row['id']; ?>" class="delete-btn" 
                       onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
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
