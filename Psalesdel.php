<?php
// Include database connection
include 'db_connection.php';

// Check if order ID is provided
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    // Delete order from the database
    $delete_sql = "DELETE FROM orders WHERE order_ID = $order_id";

    if ($conn->query($delete_sql) === TRUE) {
        // Redirect back to orders page after successful delete
        header("Location: sales.php");
        exit();
    } else {
        // Handle error
        echo "Error deleting order: " . $conn->error;
    }
} else {
    // Redirect to error page if order ID is not provided
    header("Location: error.php");
    exit();
}

// Close database connection
$conn->close();
?>
