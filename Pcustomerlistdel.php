<?php
// Include database connection
include 'db_connection.php';

// Check if customer ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: Pcustomerlist.php");
    exit();
}

// Fetch customer details from the database based on the provided ID
$id = $_GET['id'];

// Delete customer record from the database
$sql = "DELETE FROM customers WHERE cust_ID = $id";

if ($conn->query($sql) === TRUE) {
    // Redirect to customer list page after successful deletion
    header("Location: Pcustomerlist.php");
    exit();
} else {
    // Redirect to customer list page if deletion fails
    header("Location: Pcustomerlist.php");
    exit();
}
?>

<?php
// Close database connection
$conn->close();
?>
