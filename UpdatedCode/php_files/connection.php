<?php
    // Database connection settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "UserLog";
    
    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }
?>