<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Get the first and last name of the logged-in pharmacist from the session
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];

// Fetch data for the logged-in pharmacist
$sql = "SELECT * FROM pharmacists WHERE fname = '$firstName' AND lname = '$lastName'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List - Pharmalink</title>
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
    <?php include 'include/Pheader.php'; ?>
    
    <!-- Include navbar -->
    <?php include 'include/Pnavbar.php'; ?>
    
    <!-- Content -->
    <div class="content">
        <h2>Pharmacist Details</h2>
        <!-- Display pharmacist details -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Pharmacist ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any pharmacists
                if ($result && $result->num_rows > 0) {
                    // Output data of the pharmacist
                    $row = $result->fetch_assoc();
                    echo "<tr>";
                    echo "<td>" . $row['PharmID'] . "</td>";
                    echo "<td>" . $row['fname'] . "</td>";
                    echo "<td>" . $row['lname'] . "</td>";
                    echo "<td>" . $row['gender'] . "</td>";
                    echo "<td>" . $row['age'] . "</td>";
                    echo "<td>" . $row['address'] . "</td>";
                    echo "<td>" . $row['email'] . "</td>";
                    echo "<td><a href='Ppharmalistedit.php?id=" . $row['PharmID'] . "'>Edit</a> | <a href='#' onclick='confirmDelete(" . $row['PharmID'] . ")'>Delete</a></td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='8'>Pharmacist not logged in</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>

    <!-- JavaScript for confirmation popup -->
    <script>
        function confirmDelete(pharmacistId) {
            if (confirm("Are you sure you want to delete this pharmacist?")) {
                window.location.href = 'Ppharmalistdel.php?id=' + pharmacistId;
            }
        }
    </script>
</body>
</html>
