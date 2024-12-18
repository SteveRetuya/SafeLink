<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Emergency Configuration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f4f4f4;
        }

        .container {
            display: flex;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 80%;
            max-width: 600px;
            padding: 20px;
        }

        .safelink-image {
            flex: 1;
            margin-right: 20px;
        }

        .safelink-image img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-left: 30%;
        }

        .config-form {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .config-form label {
            margin-bottom: 8px;
            font-weight: bold;
        }

        .config-form select, .config-form input[type="text"], .config-form button {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .config-form button {
            background-color: #000;
            color: white;
            border: none;
            cursor: pointer;
        }

        .config-form button:hover {
            background-color: #797979;
        }

        .config-form input[type="text"]:disabled {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>

<?php include 'configAlgo.php';?>

<div class="container">
    <div class="safelink-image">
        <img src="../pictures/safelink.png" alt="Product Image" width="70" height="120">
    </div>

    <form class="config-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <h2>Configure Emergency Type</h2>

        <label for="emergency-type">Choose an emergency type:</label>
        <select id="emergency-type" name="emergency-type" onchange="toggleMedicalEmergency()">
            <option value="fire">Fire</option>
            <option value="theft">Theft</option>
            <option value="kidnapping">Kidnapping</option>
            <option value="physical-assault">Physical Assault</option>
            <option value="medical">Medical Emergency (Specify)</option>
            <option value="accident">Accident</option>
            <option value="flood">Flood</option>
            <option value="earthquake">Earthquake</option>
            <option value="violent-incidents">Violent Incidents (e.g. active shooting, physical fights)</option>
        </select>

        <div class="checkbox-container">
            <input type="checkbox" id="use-medical-services" name="use-medical-services" value="Yes">
            <label for="use-medical-services">I would like to use Emergency Services</label>
        </div>

        <div id="medical-emergency-field" style="display: none;">
            <label for="medical-details">Specify Medical Emergency:</label>
            <input type="text" id="medical-details" name="medical-details" placeholder="Enter medical emergency details">
        </div>

        <button type="submit">Set Emergency</button>

        <!-- Add a back button -->
        <button onclick="window.history.back();">Back</button>
    </form>

    

</div>

<script>
    function toggleMedicalEmergency() {
        const emergencyType = document.getElementById('emergency-type').value;
        const medicalEmergencyField = document.getElementById('medical-emergency-field');
        
        if (emergencyType === 'medical') {
            medicalEmergencyField.style.display = 'block';
        } else {
            medicalEmergencyField.style.display = 'none';
        }
    }
</script>

</body>
</html>
