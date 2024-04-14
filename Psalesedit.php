<?php
// Include database connection
include 'db_connection.php';

// Check if order ID is provided
if (!isset($_GET['id'])) {
    header("Location: Psales.php");
    exit();
}

// Fetch order details
$order_id = $_GET['id'];
$sql = "SELECT * FROM orders WHERE order_ID = $order_id";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Store order details in variables for easier access
    $prod_id = $row['prod_ID'];
    $cust_id = $row['cust_ID'];
    $quantity = $row['quantity'];
    $total_cost = $row['totalcost'];
    $date = $row['date'];
    $time = $row['time'];
    $status = $row['status'];
} else {
    // Redirect to error page if order ID is not found
    header("Location: error.php");
    exit();
}

// Initialize error message variable
$errorMsg = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $new_quantity = $_POST['quantity'];
    $new_total_cost = $_POST['total_cost'];
    $new_date = $_POST['date'];
    $new_time = $_POST['time'];
    $new_status = $_POST['status'];

    // Update order in the database
    $update_sql = "UPDATE orders SET quantity = $new_quantity, totalcost = $new_total_cost, date = '$new_date', time = '$new_time', status = '$new_status' WHERE order_ID = $order_id";

    if ($conn->query($update_sql) === TRUE) {
        // Redirect back to orders page after successful update
        header("Location: Psales.php");
        exit();
    } else {
        // Handle error
        $errorMsg = "Error updating order: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include form-specific CSS -->
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Pheader.php'; ?>

    <div class="container">
        <h2>Edit Order</h2>
        <!-- Display error message if any -->
        <?php if ($errorMsg !== ""): ?>
            <p class="error-message"><?php echo $errorMsg; ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?php echo $order_id; ?>" method="post">
            <div class="form-group">
                <label for="quantity">Quantity:</label>
                <input type="number" id="quantity" name="quantity" value="<?php echo $quantity; ?>" required>
            </div>
            <div class="form-group">
                <label for="total_cost">Total Cost:</label>
                <input type="text" id="total_cost" name="total_cost" value="<?php echo $total_cost; ?>" required>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo $date; ?>" required>
            </div><br>
            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" value="<?php echo $time; ?>" required>
            </div><br>
            <div class="form-group">
                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Pending" <?php if ($status === 'Pending') echo 'selected'; ?>>Pending</option>
                    <option value="Processing" <?php if ($status === 'Processing') echo 'selected'; ?>>Processing</option>
                    <option value="Shipped" <?php if ($status === 'Shipped') echo 'selected'; ?>>Shipped</option>
                    <option value="Delivered" <?php if ($status === 'Delivered') echo 'selected'; ?>>Delivered</option>
                </select>
            </div><br>
            <button type="submit">Update Order</button>
        </form>
    </div>

    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
