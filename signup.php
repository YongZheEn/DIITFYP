<?php
// Start a PHP session
session_start();

// Include database connection
include 'db_connection.php';

// Function to validate form
function validateForm() {
    // Get form inputs
    $isPharmacist = isset($_POST["pharmacist"]); // Check if "pharmacist" checkbox is checked
    $pharmacyCode = isset($_POST["pharmacy_code"]) ? $_POST["pharmacy_code"] : ""; // Get pharmacy code if provided
    
    // Check if user is signing up as a pharmacist
    if ($isPharmacist) {
        // Check if pharmacy code is "0000"
        if ($pharmacyCode !== "0000") {
            echo '<script>alert("Please enter the correct pharmacy code to sign up as a pharmacist.");</script>';
            return false;
        }
    }
    return true;
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store first and last name in session variables
    $_SESSION["fname"] = $_POST["fname"];
    $_SESSION["lname"] = $_POST["lname"];
    
    // Store form data in variables
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $address = $_POST["address"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $pharmacist = isset($_POST["pharmacist"]) ? 1 : 0; // Check if user is a pharmacist
    
    // Insert data into the appropriate table based on the user type
    if ($pharmacist) {
        $sql = "INSERT INTO pharmacists (fname, lname, gender, age, address, email, pass)
                VALUES ('$fname', '$lname', '$gender', '$age', '$address', '$email', '$password')";
    } else {
        $sql = "INSERT INTO customers (fname, lname, gender, age, address, email, pass)
                VALUES ('$fname', '$lname', '$gender', '$age', '$address', '$email', '$password')";
    }

    if ($conn->query($sql) === TRUE) {
        // Data inserted successfully
        $_SESSION["signup_success"] = true;
        // Redirect to signup_process.php
        header("Location: signup_process.php");
        exit();
    } else {
        // Error occurred
        $_SESSION["signup_error"] = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up for Pharmalink</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include signin-specific CSS -->
    <link rel="stylesheet" href="css/signin.css">
    <!-- Include JavaScript for form validation -->
    <script>
        function validateForm() {
            // This function is defined above in PHP
            return <?php echo validateForm() ? 'true' : 'false'; ?>;
        }
    </script>
</head>
<body>
    <header>
        <h1>Sign Up for Pharmalink</h1>
    </header>
    <div class="container">
        <div class="login-container"> <!-- New container for the form -->
            <h2>Sign Up</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return validateForm()">
                <input type="text" id="fname" name="fname" placeholder="First Name" required><br>
                <input type="text" id="lname" name="lname" placeholder="Last Name" required><br>
                <!-- Dropdown menu for Gender -->
                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select><br><br>
                <!-- Number input for Age -->
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" min="18" max="100" required><br><br>
                <input type="text" id="address" name="address" placeholder="Address" required><br>
                <input type="text" id="email" name="email" placeholder="Email" required><br>
                <input type="password" id="password" name="password" placeholder="Password" required><br>
                <div class="checkbox-container">
                    <input type="checkbox" id="pharmacist" name="pharmacist"> <!-- Fix the id and add name attribute -->
                    <label for="pharmacist">Pharmacist</label><br>
                </div>
                <input type="text" id="pharmacy_code" name="pharmacy_code" placeholder="Pharmacy Code"><br>
                <input type="submit" value="Sign Up">
            </form>
            <p>Already have an account? <a href="signin.php">Sign in here</a></p>
        </div>
    </div>
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>
