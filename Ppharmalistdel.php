<?php
// Include database connection
include 'db_connection.php';

// Check if pharmacist ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: Ppharmalist.php");
    exit();
}

// Fetch pharmacist details from the database based on the provided ID
$id = $_GET['id'];

// Delete pharmacist record from the database
$sql = "DELETE FROM pharmacists WHERE pharmID = $id";

if ($conn->query($sql) === TRUE) {
    // Redirect to pharmacist list page after successful deletion
    header("Location: Ppharmalist.php");
    exit();
} else {
    // Redirect to pharmacist list page if deletion fails
    header("Location: Ppharmalist.php");
    exit();
}
?>

<?php
// Close database connection
$conn->close();
?>
