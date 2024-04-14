<?php
// Include database connection
include 'db_connection.php';

// Check if product ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: Pproductlist.php");
    exit();
}

// Fetch product details from the database based on the provided ID
$id = $_GET['id'];

// Delete product from the database
$sql = "DELETE FROM products WHERE prod_ID = $id";

if ($conn->query($sql) === TRUE) {
    // Redirect to products page after successful deletion
    header("Location: Pproductlist.php");
    exit();
} else {
    // Redirect to products page with error message if deletion fails
    header("Location: Pproductlist.php?error=delete_failed");
    exit();
}

// Close database connection
$conn->close();
?>
