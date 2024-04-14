<?php
// Include database connection
include 'db_connection.php';

// Initialize product array with empty values
$product = array(
    'prod_Cat' => '',
    'prod_Name' => '',
    'prod_Desc' => '',
    'ProdP' => '',
    'ProdStock' => ''
);

// Initialize error message variable
$errorMsg = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data to add new product
    $cat = $_POST["prod_Cat"];
    $name = $_POST["prod_Name"];
    $desc = $_POST["prod_Desc"];
    $price = $_POST["ProdP"];
    $stock = $_POST["ProdStock"];

    // Insert new product details into the database
    $sql = "INSERT INTO products (prod_Cat, prod_Name, prod_Desc, ProdP, ProdStock) VALUES ('$cat', '$name', '$desc', $price, $stock)";

    if ($conn->query($sql) === TRUE) {
        // Redirect to products page after successful addition
        header("Location: Pproductlist.php");
        exit();
    } else {
        // Set error message if addition fails
        $errorMsg = "Error adding product: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
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
        <h2>Add Product</h2>
        <!-- Display error message if any -->
        <?php if ($errorMsg !== ""): ?>
            <p class="error-message"><?php echo $errorMsg; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="prod_Cat">Category:</label>
            <input type="text" id="prod_Cat" name="prod_Cat" value="<?php echo $product['prod_Cat']; ?>" required><br><br>
            <label for="prod_Name">Name:</label>
            <input type="text" id="prod_Name" name="prod_Name" value="<?php echo $product['prod_Name']; ?>" required><br><br>
            <label for="prod_Desc">Description:</label>
            <textarea id="prod_Desc" name="prod_Desc" rows="4" required><?php echo $product['prod_Desc']; ?></textarea><br><br>
            <label for="ProdP">Price:</label>
            <input type="number" id="ProdP" name="ProdP" value="<?php echo $product['ProdP']; ?>" required><br><br>
            <label for="ProdStock">Stock:</label>
            <input type="number" id="ProdStock" name="ProdStock" value="<?php echo $product['ProdStock']; ?>" required><br><br>
            <button type="submit">Add Product</button>
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
