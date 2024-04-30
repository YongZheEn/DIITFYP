<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php';

// Get the first and last name of the logged-in pharmacist from the session
$firstName = $_SESSION['firstName'];
$lastName = $_SESSION['lastName'];

// Fetch data for the logged-in pharmacist
$sqlLoggedIn = "SELECT * FROM pharmacists WHERE fname = '$firstName' AND lname = '$lastName'";
$resultLoggedIn = $conn->query($sqlLoggedIn);

// Fetch data for all other pharmacists
$sqlAllPharmacists = "SELECT * FROM pharmacists WHERE NOT (fname = '$firstName' AND lname = '$lastName')";
$resultAllPharmacists = $conn->query($sqlAllPharmacists);
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
        <h2>Currently logged in</h2>
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
                // Check if there are any pharmacists logged in
                if ($resultLoggedIn && $resultLoggedIn->num_rows > 0) {
                    // Output data of the pharmacist
                    $rowLoggedIn = $resultLoggedIn->fetch_assoc();
                    echo "<tr>";
                    echo "<td>" . $rowLoggedIn['pharmID'] . "</td>";
                    echo "<td>" . $rowLoggedIn['fname'] . "</td>";
                    echo "<td>" . $rowLoggedIn['lname'] . "</td>";
                    echo "<td>" . $rowLoggedIn['gender'] . "</td>";
                    echo "<td>" . $rowLoggedIn['age'] . "</td>";
                    echo "<td>" . $rowLoggedIn['address'] . "</td>";
                    echo "<td>" . $rowLoggedIn['email'] . "</td>";
                    echo "<td><a href='Ppharmalistedit.php?id=" . $rowLoggedIn['pharmID'] . "'>Edit</a> | <a href='#' onclick='confirmDelete(" . $rowLoggedIn['pharmID'] . ")'>Delete</a></td>";
                    echo "</tr>";
                } else {
                    echo "<tr><td colspan='8'>Pharmacist not logged in</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <!-- Display other pharmacists -->
        <h2>Other Pharmacists</h2>
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
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any other pharmacists
                if ($resultAllPharmacists && $resultAllPharmacists->num_rows > 0) {
                    // Output data of each other pharmacist
                    while ($rowAllPharmacists = $resultAllPharmacists->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $rowAllPharmacists['pharmID'] . "</td>";
                        echo "<td>" . $rowAllPharmacists['fname'] . "</td>";
                        echo "<td>" . $rowAllPharmacists['lname'] . "</td>";
                        echo "<td>" . $rowAllPharmacists['gender'] . "</td>";
                        echo "<td>" . $rowAllPharmacists['age'] . "</td>";
                        echo "<td>" . $rowAllPharmacists['address'] . "</td>";
                        echo "<td>" . $rowAllPharmacists['email'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No other pharmacists found</td></tr>";
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

<?php
// Close database connection
$conn->close();
?>
