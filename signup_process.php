<?php
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
        // Set the welcome message including first and last names
        $welcome_message = "Welcome back, " . $firstName . " " . $lastName . "! You have successfully signed in!";
        // Redirect user to Preports.php with the welcome message included in the URL
        header("Location: Preports.php?message=" . urlencode($welcome_message));
        exit();
    }

    // If user is not found in either table, set error message
    $errorMsg = "Invalid email or password. Please try again.";
}

// Get form data
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$gender = $_POST['gender'];
$age = $_POST['age'];
$address = $_POST['address'];
$email = $_POST['email'];
$password = $_POST['password'];
$pharmacist = isset($_POST['pharmacist']) ? 1 : 0; // Check if user is a pharmacist
$pharmacy_code = $_POST['pharmacy_code'];

// Insert user data into the appropriate table based on pharmacist status
if ($pharmacist) {
    // Insert into pharmacists table
    $sql = "INSERT INTO pharmacists (fname, lname, gender, age, address, email, pass) VALUES ('$fname', '$lname', '$gender', $age, '$address', '$email', '$password')";
} else {
    // Insert into customers table
    $sql = "INSERT INTO customers (fname, lname, gender, age, address, email, pass) VALUES ('$fname', '$lname', '$gender', $age, '$address', '$email', '$password')";
}

if ($conn->query($sql) === TRUE) {
    // Determine redirect URL based on user type
    $redirect_url = $pharmacist ? 'Preports.php' : 'Ccart.php';
    // Redirect user to the appropriate page
    header("Location: $redirect_url");
    exit();
} else {
    // Handle error
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close database connection
$conn->close();
?>
