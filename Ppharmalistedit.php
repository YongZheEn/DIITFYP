<?php
// Include database connection
include 'db_connection.php';

// Check if pharmacist ID is provided in the URL
if (!isset($_GET['id'])) {
    header("Location: Ppharmacistlist.php");
    exit();
}

// Fetch pharmacist details from the database based on the provided ID
$id = $_GET['id'];
$sql = "SELECT * FROM pharmacists WHERE PharmID = $id";
$result = $conn->query($sql);

// Check if pharmacist exists
if ($result && $result->num_rows > 0) {
    $pharmacist = $result->fetch_assoc();
} else {
    // Redirect to pharmacist list page if pharmacist does not exist
    header("Location: Ppharmacistlist.php");
    exit();
}

// Initialize error message variable
$errorMsg = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form data to update pharmacist details
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $gender = $_POST["gender"];
    $age = $_POST["age"];
    $address = $_POST["address"];
    $email = $_POST["email"];

    // Update pharmacist details in the database
    $sql = "UPDATE pharmacists SET fname = '$fname', lname = '$lname', gender = '$gender', age = $age, address = '$address', email = '$email' WHERE PharmID = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to pharmacist list page after successful update
        header("Location: Ppharmacistlist.php");
        exit();
    } else {
        // Set error message if update fails
        $errorMsg = "Error updating pharmacist: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pharmacist</title>
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
        <h2>Edit Pharmacist</h2>
        <!-- Display error message if any -->
        <?php if ($errorMsg !== ""): ?>
            <p class="error-message"><?php echo $errorMsg; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" value="<?php echo $pharmacist['fname']; ?>" required><br><br>
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" value="<?php echo $pharmacist['lname']; ?>" required><br><br>
            <label for="gender">Gender:</label>
            <input type="text" id="gender" name="gender" value="<?php echo $pharmacist['gender']; ?>" required><br><br>
            <label for="age">Age:</label>
            <input type="number" id="age" name="age" value="<?php echo $pharmacist['age']; ?>" required><br><br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo $pharmacist['address']; ?>" required><br><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo $pharmacist['email']; ?>" required><br><br>
            <button type="submit">Update Pharmacist</button>
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
