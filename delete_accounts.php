<?php
require_once "include/database-connection.php";

if (isset($_GET['id']) && isset($_GET['type'])) {
    $id = (int) $_GET['id'];
    $table = ($_GET['type'] === 'income') ? 'income_accounts_new' : 'expenses_accounts_new';

    $stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Account deleted successfully!'); window.location.href = 'accounts_category.php';</script>";
    } else {
        echo "<script>alert('Error deleting account.');</script>";
    }
    $stmt->close();
}
$conn->close();
?>
