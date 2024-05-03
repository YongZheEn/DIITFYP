<?php
// Include database connection
include 'db_connection.php';

// Check if customer ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: Cprofile.php");
    exit();
}

// Fetch pharmacist details from the database based on the provided ID
$id = $_GET['id'];

// Delete pharmacist record from the database
$sql = "DELETE FROM customers WHERE cust_id = $id";

if ($conn->query($sql) === TRUE) {
    // Redirect to pharmacist list page after successful deletion
    header("Location: Cprofile.php");
    exit();
} else {
    // Redirect to pharmacist list page if deletion fails
    header("Location: Cprofile.php");
    exit();
}
?>

<?php
// Close database connection
$conn->close();
?>
