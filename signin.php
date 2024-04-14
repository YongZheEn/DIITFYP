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
            <form action="signin_process.php" method="post">
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
