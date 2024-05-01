<?php
// Include database connection
include 'db_connection.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['prod_ID']) && isset($_POST['quantity'])) {
    // Sanitize inputs to prevent SQL injection
    $prod_ID = mysqli_real_escape_string($conn, $_POST['prod_ID']);
    $quantity = intval($_POST['quantity']);

    // Fetch product name for the message
    $sql_prod_name = "SELECT prod_Name FROM products WHERE prod_ID = '$prod_ID'";
    $result_prod_name = $conn->query($sql_prod_name);
    $row_prod_name = $result_prod_name->fetch_assoc();
    $itemName = $row_prod_name['prod_Name'];

    // Update stock quantity in the database
    $sql_update = "UPDATE products SET ProdStock = ProdStock + $quantity WHERE prod_ID = '$prod_ID'";
    if ($conn->query($sql_update) === TRUE) {
        // Call JavaScript function to show purchase message
        echo "<script>showPurchaseMessage($quantity, '$itemName');</script>";
        // Redirect back to product list
        header("Location: Pproductlist.php");
        exit();
    } else {
        // Handle error if update fails
        echo "Error updating record: " . $conn->error;
    }
}

// Fetch products data from the database
$sql = "SELECT p.prod_ID, p.prod_Cat, p.prod_Name, p.img_path AS image_link, p.prod_Desc, p.ProdP, p.ProdStock, p.total_profit 
FROM products p";
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
                    <th>Image</th>
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
                        echo "<td><img src='" . $row['image_link'] . "' alt='Product Image' style='max-width: 100px; max-height: 100px;'></td>";
                        echo "<td>" . $row['prod_Desc'] . "</td>";
                        echo "<td>" . $row['ProdP'] . "</td>";
                        echo "<td>" . $row['ProdStock'] . "</td>";
                        echo "<td>" . $row['total_profit'] . "</td>";
                        // Actions column with edit and delete links
                        echo "<td>";
                        echo "<a href='Pproductlistedit.php?id=" . $row['prod_ID'] . "'>Edit</a> | <a href='#' onclick='confirmDelete(\"Pproductlistdel.php?id=" . $row['prod_ID'] . "\")'>Delete</a><br><br>";
                        echo "<form action='Pproductlist.php' method='post' onsubmit='return showPurchaseMessage(" . $row['prod_ID'] . ", \"" . $row['prod_Name'] . "\")'>";
                        echo "<input type='hidden' name='prod_ID' value='" . $row['prod_ID'] . "'>";
                        echo "<input type='number' name='quantity' value='1' min='1'>";
                        echo "<input type='submit' value='Buy Stock'>";
                        echo "</form>";

                        echo "</td>";
                        echo "</tr>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>

    <!-- JavaScript for confirmation popup -->
    <script>
    function showPurchaseMessage(prod_ID, itemName) {
        var quantity = document.querySelector('input[name="quantity"]').value;
        alert(quantity + " " + itemName + " purchased.");
        return true;
    }

    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this product?")) {
            window.location.href = url;
        }
    }
    </script>

</body>
</html>
