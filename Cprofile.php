<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Get the first and last name of the logged-in customer from the session
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];

// Fetch data for the logged-in customer
$sqlLoggedInCustomer = "SELECT * FROM customers WHERE fname = '$firstName' AND lname = '$lastName'";
$resultLoggedInCustomer = $conn->query($sqlLoggedInCustomer);

// Fetch data for all other customers (optional)
// You can remove this if you only want to display the details of the logged-in customer

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include navbar-specific CSS -->
    <link rel="stylesheet" href="css/navbar.css">
    <!-- Include footer-specific CSS -->
    <link rel="stylesheet" href="css/footer.css">
    <!-- Include table-specific CSS -->
    <link rel="stylesheet" href="css/table.css">
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Cheader.php'; ?>
    
    <!-- Include navbar -->
    <?php include 'include/Cnavbar.php'; ?>
    
    <!-- Content -->
    <div class="content">
        <h2>Customer Details</h2>
        <!-- Display customer details -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                    <!-- Add more columns if needed -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if the logged-in customer exists
                if ($resultLoggedInCustomer && $resultLoggedInCustomer->num_rows > 0) {
                    // Output data of the customer
                    $rowLoggedInCustomer = $resultLoggedInCustomer->fetch_assoc();
                    echo "<tr>";
                    echo "<td>" . $rowLoggedInCustomer['fname'] . "</td>";
                    echo "<td>" . $rowLoggedInCustomer['lname'] . "</td>";
                    echo "<td>" . $rowLoggedInCustomer['age'] . "</td>";
                    echo "<td>" . $rowLoggedInCustomer['gender'] . "</td>";                  
                    echo "<td>" . $rowLoggedInCustomer['email'] . "</td>";
                    echo "<td>" . $rowLoggedInCustomer['address'] . "</td>";
                    // Add edit and delete buttons
                    echo "<td>";
                    echo "<a href='Cprofileedit.php?id=" . $rowLoggedInCustomer['cust_ID'] . "'>Edit</a> | ";
                    echo "<a href='Cprofiledel.php?id=" . $rowLoggedInCustomer['cust_ID'] . "' onclick='return confirm(\"Are you sure you want to delete this customer?\")'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='7'>Customer not found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>

<?php
// Close database connection
$conn->close();
?>
