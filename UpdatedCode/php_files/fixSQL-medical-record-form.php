<?php
// Database connection settings
$servername = "localhost";
$username = "michael";
$password = "12345";
$dbname = "medicalrecords";

try {
    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Create database if it doesn't exist
    $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS $dbname";
    if (!$conn->query($sqlCreateDB)) {
        throw new Exception("Database creation failed: " . $conn->error);
    }

    // Select the database
    $conn->select_db($dbname);

    //Create table if it doesn't exist
    $sqlCreateDB = "
        CREATE TABLE IF NOT EXISTS MedicalRecords (
            CREATE TABLE `medical_records`.`MedicalRecordsDB` (`id` VARCHAR(15) NOT NULL , `patient_name` VARCHAR(100) NOT NULL , `dob` DATE NOT NULL , `contact_info` TEXT NOT NULL , `insurance_details` TEXT NOT NULL , `allergies` TEXT NOT NULL , `surgeries` TEXT NOT NULL , `illnesses` TEXT NOT NULL , `family_medical_history` TEXT NOT NULL )
        )
    ";
    // if (!$conn->query($sqlCreateTable)) {
    //     throw new Exception("Table creation failed: " . $conn->error);
    // }

    // Initialize variables for form processing
    $message = "";

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize form data
        $patientName = htmlspecialchars($_POST['patient-name']);
        $dob = htmlspecialchars($_POST['dob']);
        $contactInfo = htmlspecialchars($_POST['contact-info']);
        $insuranceDetails = htmlspecialchars($_POST['insurance-details']);
        $allergies = htmlspecialchars($_POST['allergies']);
        $surgeries = htmlspecialchars($_POST['surgeries']);
        $illnesses = htmlspecialchars($_POST['illnesses']);
        $familyMedicalHistory = htmlspecialchars($_POST['family-medical-history']);

        // SQL query to insert data into the database
        $sqlInsert = "
            INSERT INTO medical_records
            (patient_name, dob, contact_info, insurance_details, allergies, surgeries, illnesses, family_medical_history)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ";

        // Prepare and bind
        $stmt = $conn->prepare($sqlInsert);
        if ($stmt) {
            $stmt->bind_param("ssssssss", $patientName, $dob, $contactInfo, $insuranceDetails, $allergies, $surgeries, $illnesses, $familyMedicalHistory);

            // Execute the statement
            if ($stmt->execute()) {
                $message = "<h3>Medical record successfully saved!</h3>";
            } else {
                $message = "<h3>Error: " . $stmt->error . "</h3>";
            }
            $stmt->close();
        } else {
            $message = "<h3>Error: " . $conn->error . "</h3>";
        }
    }
} catch (Exception $e) {
    die("<h3>Error: " . $e->getMessage() . "</h3>");
} finally {
    // Close the connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Medical Record Form</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                margin: 20px;
                background-color: #f9f9f9;
            }
            .form-container {
                max-width: 600px;
                margin: auto;
                background: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }
            h2, h3 {
                text-align: center;
            }
            form {
                margin-top: 20px;
            }
            label {
                display: block;
                margin: 10px 0 5px;
            }
            input, textarea, button {
                width: 100%;
                padding: 10px;
                margin: 5px 0 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
            }
            button {
                background-color: #28a745;
                color: white;
                font-weight: bold;
                cursor: pointer;
            }
            button:hover {
                background-color: #218838;
            }
        </style>
    </head>

    <body>

        <div class="form-container">
            <h2>Medical Record Form</h2>

            <!-- Display messages -->

            <!-- Render the form dynamically -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                <label for="patient-name">Patient Name:</label>
                <input type="text" id="patient-name" name="patient-name" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>

                <label for="contact-info">Contact Information:</label>
                <input type="text" id="contact-info" name="contact-info" placeholder="Phone number or email" required>

                <label for="insurance-details">Insurance Details:</label>
                <input type="text" id="insurance-details" name="insurance-details" required>

                <label for="allergies">List any allergies:</label>
                <textarea id="allergies" name="allergies" rows="4" placeholder="e.g., penicillin, peanuts"></textarea>

                <label for="surgeries">Surgeries (if any):</label>
                <textarea id="surgeries" name="surgeries" rows="4" placeholder="e.g., appendectomy, knee surgery"></textarea>

                <label for="illnesses">Illnesses (if any):</label>
                <textarea id="illnesses" name="illnesses" rows="4" placeholder="e.g., diabetes, asthma"></textarea>

                <label for="family-medical-history">Family Medical History:</label>
                <textarea id="family-medical-history" name="family-medical-history" rows="4" placeholder="e.g., heart disease, cancer"></textarea>

                <button type="submit">Submit Record</button>
            </form>
        </div>

    </body>
</html>