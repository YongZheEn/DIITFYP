<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Get the first and last names from the session data
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];

// Fetch customer ID based on first and last names
$sqlCustomerID = "SELECT cust_ID FROM customers WHERE fname = '$firstName' AND lname = '$lastName'";
$resultCustomerID = $conn->query($sqlCustomerID);

// Check if customer ID exists
if ($resultCustomerID && $resultCustomerID->num_rows > 0) {
    $rowCustomerID = $resultCustomerID->fetch_assoc();
    $cust_ID = $rowCustomerID['cust_ID'];

    // Fetch cart data for the current customer including product details
    $cart_sql = "SELECT cart.*, products.prod_Name, products.ProdP FROM cart INNER JOIN products ON cart.prod_ID = products.prod_ID WHERE cart.cust_ID = $cust_ID";
    $cart_result = $conn->query($cart_sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include navbar-specific CSS -->
    <link rel="stylesheet" href="css/navbar.css">
    <!-- Include footer-specific CSS -->
    <link rel="stylesheet" href="css/footer.css">
    <!-- Include table-specific CSS -->
    <link rel="stylesheet" href="css/table.css">
    <!-- Include popup-specific CSS -->
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Cheader.php'; ?>
    
    <!-- Include navbar -->
    <?php include 'include/Cnavbar.php'; ?>
    
    <!-- Content -->
    <div class="content">
        <h2>Your Cart</h2>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Price Per Unit (RM)</th>
                    <th>Quantity</th>
                    <th>Total Price (RM)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($cart_result) && $cart_result->num_rows > 0): ?>
                    <?php $totalPrice = 0; ?>
                    <?php $cartItems = array(); ?>
                    <?php while ($row = $cart_result->fetch_assoc()): ?>
                        <?php $totalPrice += $row['ProdP'] * $row['quantity']; ?>
                        <?php $cartItems[] = $row['prod_Name'] . '(' . $row['quantity'] . ')'; ?>
                        <tr>
                            <td><?php echo $row['prod_Name']; ?></td>
                            <td><?php echo $row['ProdP']; ?></td>
                            <td><?php echo $row['quantity']; ?></td>
                            <td><?php echo $row['ProdP'] * $row['quantity']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                    <tr>
                        <td colspan="3" style="text-align: right;"><b>Total Price:</b></td>
                        <td><?php echo $totalPrice; ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Your cart is empty.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <br>
        <?php if (isset($totalPrice) && $totalPrice > 0): ?>
            <form id="checkoutForm" action="Ccheckout.php" method="post">
                <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
                <button type="button" class="button" onclick="confirmCheckout()">Checkout</button>
            </form>
        <?php endif; ?>
    </div>

    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>

    <!-- JavaScript for confirmation popup -->
    <script>
        function confirmCheckout() {
            var items = "<?php echo implode(', ', $cartItems); ?>";
            if (confirm("Are you sure you want to buy " + items + "?")) {
                document.getElementById("checkoutForm").submit();
            }
        }
    </script>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
