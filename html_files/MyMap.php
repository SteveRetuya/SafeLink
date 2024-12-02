<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
    <title>Display a map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        #map {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 380px; /* Adjusted to leave space for the sidebar */
        }
        .sidebar {
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 380px; /* Fixed width for the sidebar */
            background-color: #f8f9fa; /* Light background color */
            padding: 20px;
        }
        .sidebar h2 {
            margin-top: 0;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 15px 0;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: #333;
            font-size: 16px;
        }
        .sidebar ul li a:hover {
            color: #007bff; /* Change color on hover */
        }
    </style>
    <link href="MainSiteCSS"
</head>
<body>
    <div class="sidebar">
        <h2>Emergency Information</h2>
        <ul>
            <li><a href="#"><i class="fas fa-home"></i> Name: ----</a></li>
            <li><a href="#"><i class="fas fa-user"></i> Gender: ----</a></li>
            <li><a href="#"><i class="fas fa-address-card"></i> Age: ---</a></li>
            <li><a href="#"><i class="fas fa-project-diagram"></i> Type of Emergency: ----</a></li>
            <li><a href="#"><i class="fas fa-blog"></i> Emergency Contact: ----</a></li>
            <li><a href="#"><i class="fas fa-map-pin"></i> Coordinates: ----, ----</a></li>
        </ul> 
    </div>
    <div id="map"></div>
    <p>
        <a href="https://www.maptiler.com/copyright/" target="_blank" rel="noopener">&copy; MapTiler</a> 
        <a href="https://www.openstreetmap.org/copyright" target="_blank" rel="noopener">&copy; OpenStreetMap contributors</a>
    </p>
    <script>
       
        const key = 'C7XGpviZGpWgPzGVoI5B'; // DO NOT TOUCH

        const map = L.map('map').setView([0, 0], 14); // default to null

        L.tileLayer(`https://api.maptiler.com/maps/streets-v2/{z}/{x}/{y}.png?key=${key}`, {
            tileSize: 512,
            zoomOffset: -1,
            minZoom: 1,
            attribution: "\u003ca href=\"https://www.maptiler.com/copyright/\" target=\"_blank\"\u003e\u0026copy; MapTiler\u003c/a\u003e \u003ca href=\"https://www.openstreetmap.org/copyright\" target=\"_blank\"\u003e\u0026copy; OpenStreetMap contributors\u003c/a\u003e",
            crossOrigin: true
        }).addTo(map);

        // Create a marker (initial position can be anything, will update later)
        const marker = L.marker([0, 0]).addTo(map);
        marker.bindPopup("Emergency Location").openPopup();

        // Function to check if the logs.json file exists
        async function checkFileExists() {
            const response = await fetch('http://localhost/arduino/receiver/logs/log.json', { method: 'HEAD' });
            return response.ok; // Returns true if the file exists, false otherwise
        }

        // Function to fetch and display data from the PHP endpoint and update the map
        // Function to fetch JSON data (location coordinates) and set markers
async function fetchLocationData() {
    try {
        const response = await fetch('http://localhost/html_files/datafetcher.php');
        const result = await response.json();

        if (result.error) {
            console.error(result.error);
        } else {
            // Assuming you have a map set up (e.g., using Leaflet or Google Maps)
            const lat = parseFloat(result.Latitude);
            const lon = parseFloat(result.Longitude);

            // Example: Set the map marker position
            const marker = L.marker([lat, lon]).addTo(map);
            marker.bindPopup("Emergency Location").openPopup();

            // Optionally, update the map's center if necessary
            map.setView([lat, lon], 13);
        }
    } catch (error) {
        console.error('Error fetching location data:', error);
    }
}

// Function to fetch user details from userfetcher.php
async function fetchUserData() {
    try {
        const response = await fetch('http://localhost/html_files/userfetcher.php');
        const result = await response.json();

        if (result.error) {
            console.error(result.error);
        } else {
            // Update the sidebar or any other part of the webpage with user data
            document.querySelector('.sidebar li:nth-child(1) a').textContent = `Name: ${result.Name}`;
            document.querySelector('.sidebar li:nth-child(2) a').textContent = `Gender: ${result.Gender}`;
            document.querySelector('.sidebar li:nth-child(3) a').textContent = `Age: ${result.Age}`;
            document.querySelector('.sidebar li:nth-child(4) a').textContent = `Type of Emergency: ${result.EmergencyType}`;
            document.querySelector('.sidebar li:nth-child(5) a').textContent = `Emergency Contact: ${result.EmergencyContact}`;
            document.querySelector('.sidebar li:nth-child(6) a').textContent = `Coordinates: ${result.Coordinates.Latitude}, ${result.Coordinates.Longitude}`;
        }
    } catch (error) {
        console.error('Error fetching user data:', error);
    }
}

// Fetch both the user data and location data at regular intervals
setInterval(() => {
    fetchLocationData();
    fetchUserData();
}, 1000);

    </script>
</body>
</html>