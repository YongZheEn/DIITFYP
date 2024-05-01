<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Check if the total price is posted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['totalPrice'])) {
    // Get the total price from the form
    $totalPrice = $_POST['totalPrice'];

    // Get the customer ID from the session data
    $firstName = $_SESSION['firstName'];
    $lastName = $_SESSION['lastName'];
    $sqlCustomerID = "SELECT cust_ID FROM customers WHERE fname = '$firstName' AND lname = '$lastName'";
    $resultCustomerID = $conn->query($sqlCustomerID);

    // Check if customer ID exists
    if ($resultCustomerID && $resultCustomerID->num_rows > 0) {
        $rowCustomerID = $resultCustomerID->fetch_assoc();
        $cust_ID = $rowCustomerID['cust_ID'];

        // Fetch product price from the products table based on prod_ID in the cart
        $fetchProductPriceSql = "SELECT cart.prod_ID, cart.quantity, products.ProdP FROM cart JOIN products ON cart.prod_ID = products.prod_ID WHERE cart.cust_ID = $cust_ID";
        $resultProductPrice = $conn->query($fetchProductPriceSql);

        // Check if product price is fetched successfully
        if ($resultProductPrice && $resultProductPrice->num_rows > 0) {
            // Prepare the insert query
            $insertOrdersSql = "INSERT INTO orders (prod_ID, cust_ID, quantity, totalcost, date, time, status) VALUES ";

            // Loop through the fetched product prices to construct the insert query
            while ($rowProductPrice = $resultProductPrice->fetch_assoc()) {
                $prod_ID = $rowProductPrice['prod_ID'];
                $quantity = $rowProductPrice['quantity'];
                $unitPrice = $rowProductPrice['ProdP'];
                $totalCost = $quantity * $unitPrice;
                $insertOrdersSql .= "($prod_ID, $cust_ID, $quantity, $totalCost, CURDATE(), CURTIME(), 'Pending'), ";
            }

            // Remove the last comma and space from the insert query
            $insertOrdersSql = rtrim($insertOrdersSql, ", ");

            // Execute the insert query
            if ($conn->query($insertOrdersSql) === TRUE) {
                // Clear the cart after moving items to orders table
                $clearCartSql = "DELETE FROM cart WHERE cust_ID = $cust_ID";
                if ($conn->query($clearCartSql) === TRUE) {
                    echo "<script>alert('Checkout successful.');</script>";
                } else {
                    echo "<script>alert('Error clearing cart: " . $conn->error . "');</script>";
                }
            } else {
                echo "<script>alert('Error moving items to orders table: " . $conn->error . "');</script>";
            }
        } else {
            echo "<script>alert('Error fetching product prices: " . $conn->error . "');</script>";
        }
    } else {
        echo "<script>alert('Customer ID not found.');</script>";
    }
} else {
    echo "<script>alert('Total price not provided.');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include navbar-specific CSS -->
    <link rel="stylesheet" href="css/navbar.css">
    <!-- Include footer-specific CSS -->
    <link rel="stylesheet" href="css/footer.css">
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Cheader.php'; ?>

    <!-- Include navbar -->
    <?php include 'include/Cnavbar.php'; ?>

    <!-- Content -->
    <div class="content">
        <h2>Checkout</h2>
        <p>Your items have been successfully checked out.</p>
    </div>

    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
