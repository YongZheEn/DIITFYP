<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- Include global CSS -->
    <link rel="stylesheet" href="css/global.css">
    <!-- Include header-specific CSS -->
    <link rel="stylesheet" href="css/header.css">
    <!-- Include navbar-specific CSS -->
    <link rel="stylesheet" href="css/navbar.css">
    <!-- Include footer-specific CSS -->
    <link rel="stylesheet" href="css/footer.css">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
         integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
         crossorigin=""/>
    <!-- Define map container height -->
    <style>
        #map { height: 200px; }
    </style>
</head>
<body>
    <!-- Include header -->
    <?php include 'include/Cheader.php'; ?>

    <!-- Include navbar -->
    <?php include 'include/Cnavbar.php'; ?>
    
    <!-- Content -->
    <div class="content">
        <h1>About Us Page</h1>
        <!-- Add your about us content here -->
        <p>“Pharmalink” is an online pharmacy platform that allows customers to order and purchase prescription as well as non-prescription medicines and other health products. 
            <br> It is a web-based application that also enables pharmacies to improve inventory management and track orders. Other benefits include keeping track of customer details 
            <br> such as names, phone numbers, home addresses, and so forth.
        </p>
        <h1>Our Locations</h1>
        <p>Sunway College, 2, Jalan Universiti, Bandar Sunway, 47500 Petaling Jaya, Selangor</p>
        <!-- Leaflet Map -->
        <div id="map"></div>
    </div>

    <!-- Include Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
         integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
         crossorigin=""></script>
    <script>
        // Initialize the map
        var map = L.map('map').setView([3.0679, 101.6041], 15);

        // Add OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Add marker for Pharmalink HQ - Sunway College
        var marker = L.marker([3.0679, 101.6041]).addTo(map);
        marker.bindPopup("<b>Pharmalink HQ - Sunway College</b><br><a href='https://www.google.com/maps?client=firefox-b-d&um=1&ie=UTF-8&fb=1&gl=my&sa=X&geocode=Kd3ce7SPTMwxMSts79tCR645&daddr=Sunway+College,+2,+Jalan+Universiti,+Bandar+Sunway,+47500+Petaling+Jaya,+Selangor' target='_blank'>Get Directions</a>").openPopup();
    </script>
    
    <!-- Include footer -->
    <?php include 'include/footer.php'; ?>
</body>
</html>
