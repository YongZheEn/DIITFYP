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
</head>
<body>
    <header>
        <h1>Sign Up for Pharmalink</h1>
    </header>
    <div class="container">
        <div class="login-container"> <!-- New container for the form -->
            <h2>Sign Up</h2>
            <form action="signup_process.php" method="post">
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
                    <input type="checkbox" id="pharmacist" name="pharmacist">
                    <label for="pharmacist">Pharmacist</label><br>
                </div>
                <input type="text" id="pharmacy_code" name="pharmacy_code" placeholder="Pharmacy Code" required><br>
                <input type="submit" value="Sign Up">
            </form>
            <p>Already have an account? <a href="signin.php">Sign in here</a></p>
        </div>
    </div>
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>
