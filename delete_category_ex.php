<?php
require_once "include/database-connection.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Check if the category exists before deleting
    $check_stmt = $conn->prepare("SELECT id FROM expenses_categories_new WHERE id = ?");
    $check_stmt->bind_param("i", $id);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        $stmt = $conn->prepare("DELETE FROM expenses_categories_new WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Category deleted successfully!'); window.location.href = 'expense_category.php';</script>";
        } else {
            echo "<script>alert('Error deleting category.'); window.location.href = 'expense_category.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Category not found!'); window.location.href = 'expense_category.php';</script>";
    }
    $check_stmt->close();
} else {
    echo "<script>alert('Invalid request!'); window.location.href = 'expense_category.php';</script>";
}

$conn->close();
?>
