<?php
// Include database connection
include 'db_connection.php';

// Fetch customer data from the database
$sql = "SELECT * FROM customers";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer List - Pharmalink</title>
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
        <h2>Customers</h2>
        <!-- Display customer list -->
        <table class="data-table">
            <thead>
                <tr>
                    <th>Customer ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Total Spent(MYR)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are any customers
                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['custID'] . "</td>";
                        echo "<td>" . $row['fname'] . "</td>";
                        echo "<td>" . $row['lname'] . "</td>";
                        echo "<td>" . $row['gender'] . "</td>";
                        echo "<td>" . $row['age'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['total_spent'] . "</td>";
                        echo "<td><a href='Pcustomerlistedit.php?id=" . $row['custID'] . "'>Edit</a> | <a href='Pcustomerlistdel.php?id=" . $row['custID'] . "'>Delete</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No customers found</td></tr>";
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

