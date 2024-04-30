<?php
// Include database connection
include 'db_connection.php';

// Check if product ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: Pproductlist.php");
    exit();
}

// Fetch product details from the database based on the provided ID
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE prod_ID = $id";
$result = $conn->query($sql);

// Check if product exists
if ($result && $result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    // Redirect to products page if product does not exist
    header("Location: Pproductlist.php");
    exit();
}

// Initialize error message variable
$errorMsg = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data to update product details
    $cat = $_POST["prod_Cat"];
    $name = $_POST["prod_Name"];
    $desc = $_POST["prod_Desc"];
    $price = $_POST["ProdP"];
    $stock = $_POST["ProdStock"];

    // Check if file is uploaded
    if ($_FILES['image']['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES['image']['tmp_name'])) {
        // Define upload directory
        $upload_dir = 'uploads/';
        // Generate unique file name
        $file_name = uniqid() . '_' . basename($_FILES['image']['name']);
        // Concatenate directory and file name
        $target_path = $upload_dir . $file_name;

        // Move uploaded file to target path
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
            // Update product details in the database with file path
            $sql = "UPDATE products SET prod_Cat = '$cat', prod_Name = '$name', prod_Desc = '$desc', ProdP = $price, ProdStock = $stock, img_path = '$target_path' WHERE prod_ID = $id";

            if ($conn->query($sql) === TRUE) {
                // Redirect to products page after successful update
                header("Location: Pproductlist.php");
                exit();
            } else {
                // Set error message if update fails
                $errorMsg = "Error updating product: " . $conn->error;
            }
        } else {
            $errorMsg = "Error uploading file.";
        }
    } else {
        // No image uploaded, retain the existing image path
        $sql = "UPDATE products SET prod_Cat = '$cat', prod_Name = '$name', prod_Desc = '$desc', ProdP = $price, ProdStock = $stock WHERE prod_ID = $id";

        if ($conn->query($sql) === TRUE) {
            // Redirect to products page after successful update
            header("Location: Pproductlist.php");
            exit();
        } else {
            // Set error message if update fails
            $errorMsg = "Error updating product: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
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
        <h2>Edit Product</h2>
        <!-- Display error message if any -->
        <?php if ($errorMsg !== ""): ?>
            <p class="error-message"><?php echo $errorMsg; ?></p>
        <?php endif; ?>
        <form action="" method="post" enctype="multipart/form-data">
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
            <label for="image">Choose Image:</label>
            <input type="file" id="image" name="image"><br><br>
            <button type="submit">Update Product</button>
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
