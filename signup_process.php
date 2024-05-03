<?php
// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if pharmacist checkbox is checked
    if (isset($_POST["pharmacist"])) {
        // If pharmacist checkbox is checked, redirect to Preports.php
        header("Location: Preports.php");
        exit();
    } else {
        // If pharmacist checkbox is not checked, redirect to Ccatalogue.php
        header("Location: Ccatalogue.php");
        exit();
    }
} else {
    // If form is not submitted, redirect to the signup page
    header("Location: signin.php");
    exit();
}
?>
