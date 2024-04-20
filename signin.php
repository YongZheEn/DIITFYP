<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Initialize error message variable
$errorMsg = "";

// Initialize variables for first and last names
$firstName = "";
$lastName = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve email and password from the form
    $email = $_POST["Email"];
    $password = $_POST["password"];

    // Query to check if the user exists in the customers table
    $sql = "SELECT * FROM customers WHERE email = '$email' AND pass = '$password'";
    $result = $conn->query($sql);

    // Check if user exists in customers table
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        // Set first and last names
        $firstName = $row['fname'];
        $lastName = $row['lname'];
        
        // Start session and store user data in session variables
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        
        // Redirect user to Ccart.php
        header("Location: Ccatalogue.php");
        exit();
    }

    // Query to check if the user exists in the pharmacists table
    $sql = "SELECT * FROM pharmacists WHERE email = '$email' AND pass = '$password'";
    $result = $conn->query($sql);

    // Check if user exists in pharmacists table
    if ($result && $result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();
        // Set first and last names
        $firstName = $row['fname'];
        $lastName = $row['lname'];
        
        // Start session and store user data in session variables
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        
        // Redirect user to Preports.php
        header("Location: Preports.php");
        exit();
    }

    // If user is not found in either table, set error message
    $errorMsg = "Invalid email or password. Please try again.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In to Pharmalink</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include signin-specific CSS -->
    <link rel="stylesheet" href="css/signin.css">
</head>
<body>
    <header>
        <h1>Sign In to Pharmalink</h1>
    </header>
    <div class="container">
        <div class="login-container">
            <h2>Sign In</h2>
            <!-- Display error message if any -->
            <?php if ($errorMsg !== ""): ?>
                <p class="error-message"><?php echo $errorMsg; ?></p>
            <?php endif; ?>
            <form action="" method="post">
                <input type="text" name="Email" placeholder="Email" required><br>
                <input type="password" name="password" placeholder="Password" required><br>
                <input type="submit" value="Sign In">
            </form>
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>
