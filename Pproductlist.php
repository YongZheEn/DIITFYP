<?php
// Include database connection
include 'db_connection.php';

// Fetch products data from the database
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Pharmalink</title>
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
        <h2>Products</h2>
        <!-- Button to add a new entry -->
        <a href="Pproductlistadd.php"><button>Add New Product</button></a>
        <!-- Display products table -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Prod_ID</th>
                    <th>Prod_Cat</th>
                    <th>Prod_Name</th>
                    <th>Prod_Desc</th>
                    <th>ProdP</th>
                    <th>ProdStock</th>
                    <th>Total_profit(MYR)</th>
                    <th>Actions</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any products
                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['prod_ID'] . "</td>";
                        echo "<td>" . $row['prod_Cat'] . "</td>";
                        echo "<td>" . $row['prod_Name'] . "</td>";
                        echo "<td>" . $row['prod_Desc'] . "</td>";
                        echo "<td>" . $row['ProdP'] . "</td>";
                        echo "<td>" . $row['ProdStock'] . "</td>";
                        echo "<td>" . $row['total_profit'] . "</td>";
                        // Actions column with edit and delete links
                        echo "<td><a href='Pproductlistedit.php?id=" . $row['prod_ID'] . "'>Edit</a> | <a href='#' onclick='confirmDelete(\"Pproductlistdel.php?id=" . $row['prod_ID'] . "\")'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No products found</td></tr>";
                }
                // Close database connection
                $conn->close();
                ?>
            </tbody>
        </table>

        
    </div>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>

    <!-- JavaScript for confirmation popup -->
    <script>
        function confirmDelete(url) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = url;
            }
        }
    </script>
</body>
</html>
