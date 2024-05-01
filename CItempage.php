<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Check if prod_ID is set in the URL
if (!isset($_GET['prod_ID']) || empty($_GET['prod_ID'])) {
    // Redirect to catalogue page if prod_ID is not provided
    header("Location: catalogue.php");
    exit;
}

// Fetch product data based on prod_ID from the URL
$prod_ID = $_GET['prod_ID'];
$sql = "SELECT * FROM products WHERE prod_ID = $prod_ID";
$result = $conn->query($sql);

// Check if product exists
if ($result && $result->num_rows > 0) {
    // Fetch product details
    $row = $result->fetch_assoc();
    $prod_Name = $row['prod_Name'];
    $prod_Desc = $row['prod_Desc'];
    $prod_Cat = $row['prod_Cat'];
    $ProdP = $row['ProdP'];
    $ProdStock = $row['ProdStock'];
    $img_path = $row['img_path'];
} else {
    // Redirect to catalogue page if product does not exist
    header("Location: catalogue.php");
    exit;
}

// Add item to cart
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if quantity is provided and numeric
    if (isset($_POST['quantity']) && is_numeric($_POST['quantity'])) {
        // Check if quantity is positive and does not exceed available stock
        if ($_POST['quantity'] > 0 && $_POST['quantity'] <= $ProdStock) {
            // Fetch customer ID from the database based on first and last name
            $firstName = isset($_SESSION['firstName']) ? $_SESSION['firstName'] : null;
            $lastName = isset($_SESSION['lastName']) ? $_SESSION['lastName'] : null;

            if ($firstName !== null && $lastName !== null) {
                // Query to fetch customer ID
                $customer_query = "SELECT cust_ID FROM customers WHERE fname = '$firstName' AND lname = '$lastName'";
                $customer_result = $conn->query($customer_query);

                // Check if customer exists
                if ($customer_result && $customer_result->num_rows > 0) {
                    $customer_row = $customer_result->fetch_assoc();
                    $cust_ID = $customer_row['cust_ID'];

                    // Add item to cart with quantity
                    $item = array(
                        'prod_ID' => $prod_ID,
                        'quantity' => $_POST['quantity']
                    );
                    array_push($_SESSION['cart'], $item);

                    // Insert cart item into the database
                    $quantity = $_POST['quantity'];
                    $insert_sql = "INSERT INTO cart (prod_ID, quantity, cust_ID) VALUES ($prod_ID, $quantity, $cust_ID)";
                    if ($conn->query($insert_sql) === TRUE) {
                        echo "<script>alert('Item added to cart successfully.');</script>";
                    } else {
                        echo "<script>alert('Error adding item to cart.');</script>";
                    }
                } else {
                    echo "<script>alert('Error: Customer not found.');</script>";
                }
            } else {
                echo "<script>alert('Error: First name or last name not found in session data.');</script>";
            }
        } else {
            echo "<script>alert('Invalid quantity.');</script>";
        }
    } else {
        echo "<script>alert('Please provide a valid quantity.');</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $prod_Name; ?></title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include navbar-specific CSS -->
    <link rel="stylesheet" href="css/navbar.css">
    <!-- Include footer-specific CSS -->
    <link rel="stylesheet" href="css/footer.css">
    <!-- Include itempage-specific CSS -->
    <link rel="stylesheet" href="css/itempage.css">
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Cheader.php'; ?>

    <!-- Include navbar -->
    <?php include 'include/Cnavbar.php'; ?>
    
    <!-- Content -->
    <div class="content">
        <div class="product-details">
            <div class="image-container">
                <img src="<?php echo $img_path; ?>" alt="<?php echo $prod_Name; ?>">
            </div>
            <div class="details-container">
                <h2><?php echo $prod_Name; ?></h2>
                <p><b>Category:</b> <?php echo $prod_Cat; ?></p>
                <p><b>Description:</b> <?php echo $prod_Desc; ?></p>
                <p><b>Price:</b> RM<?php echo $ProdP; ?></p>
                <p><b>Stock:</b> <?php echo $ProdStock; ?></p>
                <form method="post">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $ProdStock; ?>" required>
                    <button type="submit" class="button add-to-cart">Add to Cart</button>
                </form>
            </div>
        </div>
    </div>

    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>
