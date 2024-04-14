<?php
// Include database connection
include 'db_connection.php';

// Fetch the 3 lowest stock products
$sql = "SELECT prod_Name, ProdStock FROM products ORDER BY ProdStock ASC LIMIT 3";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Page</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include navbar-specific CSS -->
    <link rel="stylesheet" href="css/navbar.css">
    <!-- Include footer-specific CSS -->
    <link rel="stylesheet" href="css/footer.css">
    <!-- Custom CSS for reports page -->
    <style>
        .content {
            padding: 20px;
        }

        .report-container {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }

        .report-container h3 {
            margin-top: 0;
        }

        .low-stock-list {
            list-style: none;
            padding: 0;
        }

        .low-stock-list li {
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Pheader.php'; ?>
    
    <!-- Include navbar -->
    <?php include 'include/Pnavbar.php'; ?>
    
    <!-- Content -->
    <div class="content">
        <h2>Reports Page</h2>
        <!-- Display welcome message -->
        <?php
        // Check if welcome message is set
        if (isset($_GET['message'])) {
            echo "<p>" . $_GET['message'] . "</p>";
        }
        ?>
        
        <!-- Metrics containers -->
        <!-- Other metric containers... -->
        
        <div class="report-container">
            <h3>Products Low on Stock</h3>
            <!-- Display low stock products -->
            <ul>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li><?php echo $row['prod_Name']; ?> - Stock Remaining: <?php echo $row['ProdStock']; ?></li>
                    <?php endwhile; ?>
                <?php else: ?>
                    <li>No low stock products found.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>
