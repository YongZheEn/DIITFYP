<?php
// Include database connection
include 'db_connection.php';

// Check if customer ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: Cprofile.php");
    exit();
}

// Fetch customer details from the database based on the provided ID
$id = $_GET['id'];
$sql = "SELECT * FROM customers WHERE cust_ID = $id";
$result = $conn->query($sql);

// Check if customer exists
if ($result && $result->num_rows > 0) {
    $customer = $result->fetch_assoc();
} else {
    // Redirect to customer details page if customer does not exist
    header("Location: Cprofile.php");
    exit();
}

// Initialize error message variable
$errorMsg = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data to update customer details
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $email = $_POST["email"];
    $address = $_POST["address"];

    // Update customer details in the database
    $sql = "UPDATE customers SET fname = '$fname', lname = '$lname', age = '$age', gender = '$gender', email = '$email', address = '$address' WHERE cust_ID = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to customer details page after successful update
        header("Location: Cprofile.php");
        exit();
    } else {
        // Set error message if update fails
        $errorMsg = "Error updating customer: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include form-specific CSS -->
    <link rel="stylesheet" href="css/edit.css">
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Cheader.php'; ?>

    <div class="container">
        <h2>Edit Customer</h2>
        <!-- Display error message if any -->
        <?php if ($errorMsg !== ""): ?>
            <p class="error-message"><?php echo $errorMsg; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo $customer['fname']; ?>" required><br><br>
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo $customer['lname']; ?>" required><br><br>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $customer['age']; ?>" required><br><br>
            <label for="gender">Gender:</label>
            <select id="gender" name="gender" required>
                <option value="Male" <?php if ($customer['gender'] === 'Male') echo 'selected'; ?>>Male</option>
                <option value="Female" <?php if ($customer['gender'] === 'Female') echo 'selected'; ?>>Female</option>
            </select><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $customer['email']; ?>" required><br><br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $customer['address']; ?>" required><br><br>
            <button type="submit">Update Customer</button>
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
