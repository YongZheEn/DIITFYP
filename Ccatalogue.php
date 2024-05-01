<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Fetch product data
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Catalogue</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include navbar-specific CSS -->
    <link rel="stylesheet" href="css/navbar.css">
    <!-- Include footer-specific CSS -->
    <link rel="stylesheet" href="css/footer.css">
    <!-- Include catalogue-specific CSS -->
    <link rel="stylesheet" href="css/catalogue.css">
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Cheader.php'; ?>

    <!-- Include navbar -->
    <?php include 'include/Cnavbar.php'; ?>
    
    <!-- Content -->
    <div class="content">
        <h2>Product Catalogue</h2>
        <div class="product-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="product-card">
                        <h3><a href="CItempage.php?prod_ID=<?php echo $row['prod_ID']; ?>"><?php echo $row['prod_Name']; ?></a></h3>
                        <img src="<?php echo $row['img_path']; ?>" alt="<?php echo $row['prod_Name']; ?>">
                        <p><?php echo $row['prod_Cat']; ?></p>
                        <p><b>Price: RM<?php echo $row['ProdP']; ?></b></p>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>No products available.</p>
            <?php endif; ?>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>
