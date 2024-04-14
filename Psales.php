<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales - Pharmalink</title>
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
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Pheader.php'; ?>
    
    <!-- Include navbar -->
    <?php include 'include/Pnavbar.php'; ?>
    
    <!-- Content -->
    <div class="content">
        <h2>Sales</h2>
        <!-- Display sales data -->
        <div class="sales-table">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product ID</th>
                        <th>Customer ID</th>
                        <th>Quantity</th>
                        <th>Total Cost</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Actions</th> <!-- Added Actions column -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Include database connection
                    include 'db_connection.php';
                    
                    // Fetch orders data
                    $sql = "SELECT * FROM orders";
                    $result = $conn->query($sql);
                    
                    // Check if there are any orders
                    if ($result && $result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['order_ID'] . "</td>";
                            echo "<td>" . $row['prod_ID'] . "</td>";
                            echo "<td>" . $row['cust_ID'] . "</td>";
                            echo "<td>" . $row['quantity'] . "</td>";
                            echo "<td>" . $row['totalcost'] . "</td>";
                            echo "<td>" . $row['date'] . "</td>";
                            echo "<td>" . $row['time'] . "</td>";
                            echo "<td>" . $row['status'] . "</td>";
                            // Edit and delete buttons
                            echo "<td>";
                            echo "<a href='Psalesedit.php?id=" . $row['order_ID'] . "'>Edit</a> | ";
                            echo "<a href='Psalesdel.php?id=" . $row['order_ID'] . "' onclick='return confirm(\"Are you sure you want to delete this order?\")'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9'>No orders found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>
