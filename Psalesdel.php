<?php
// Include database connection
include 'db_connection.php';

// Check if order ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: Psales.php");
    exit();
}

// Fetch order details from the database based on the provided ID
$order_id = $_GET['id'];

// Delete order from the database
$sql = "DELETE FROM orders WHERE order_ID = $order_id";

if ($conn->query($sql) === TRUE) {
    // Redirect back to orders page after successful delete
    header("Location: Psales.php");
    exit();
} else {
    // Redirect to error page with error message if deletion fails
    header("Location: error.php?message=delete_failed");
    exit();
}

// Close database connection
$conn->close();
?>
