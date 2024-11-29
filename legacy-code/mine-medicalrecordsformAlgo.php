<?php
// Database connection settings
$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'safelink';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$deviceid = "BAG-202400002";

//Check first if there is an existing data
$sqlSelect = "SELECT * FROM safelink.medical_records WHERE device_id = ?";

$stmt = $conn->prepare($sqlSelect);

$stmt->bind_param("s", $deviceid);

$stmt->execute();

$result = $stmt->get_result();

$res = $result->num_rows;

if($res == 1){

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        // do code here for updating the fields in the database
    } else {
        $user = $result->fetch_assoc();
    }
    
} else{
    try {
        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Collect and sanitize form data
            $deviceid = htmlspecialchars($_POST['deviceid']);
            $patientName = htmlspecialchars($_POST['patient-name']);
            $dob = htmlspecialchars($_POST['dob']);
            $contactInfo = htmlspecialchars($_POST['contact-info']);
            $insuranceDetails = htmlspecialchars($_POST['insurance-details']);
            $allergies = htmlspecialchars($_POST['allergies']);
            $surgeries = htmlspecialchars($_POST['surgeries']);
            $illnesses = htmlspecialchars($_POST['illnesses']);
            $familyMedicalHistory = htmlspecialchars($_POST['family-medical-history']);
            $emergencycontactnumber = htmlspecialchars($_POST['emergency-contact-number']);
    
            
    
            // SQL query to insert data into the database
            $sqlInsert = "
            INSERT INTO safelink.medical_records(`device_id`, `patient_name`, `date_of_birth`, `contact_info`, `insurance_details`, `allergies`, `surgeries`, `illnesses`, `medical_history`, `emergency_contact_number`) 
            VALUES (?,?,?,?,?,?,?,?,?,?)
            ";
    
            // Prepare and bind
            $stmt = $conn->prepare($sqlInsert);
            if ($stmt) {
                $stmt->bind_param("ssssssssss", 
                $deviceid, $patientName, $dob, $contactInfo, $insuranceDetails, $allergies, $surgeries, $illnesses, $familyMedicalHistory,$emergencycontactnumber);
    
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
}


?>