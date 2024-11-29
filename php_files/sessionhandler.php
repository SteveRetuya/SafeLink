<?php
    if (!isset($_SESSION['deviceID'])) {
        die("Error: deviceID not set in the session.");
    }
    $deviceid = $_SESSION['deviceID'];
?>