<?php
// Database configuration
$dbHost = 'localhost'; // Change this to your MySQL host
$dbUsername = 'root'; // Change this to your MySQL username
$dbPassword = ''; // Change this to your MySQL password
$dbName = 'Pharmalink'; // Change this to your MySQL database name

// Establish a connection to the MySQL database
$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
