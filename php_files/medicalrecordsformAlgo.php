<?php
include_once('connection.php');
include_once('sessionhandler.php');

$message = ""; // Initialize message variable for user feedback
$user = []; // Placeholder for fetched record data

// Ensure device_id is set before proceeding with the form actions
$deviceid = $_SESSION['deviceID']; // Ensure deviceID is set correctly from the session

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect and sanitize input values
    $patientName = htmlspecialchars($_POST['patient-name']);
    $dob = htmlspecialchars($_POST['dob']);
    $contactInfo = htmlspecialchars($_POST['contact-info']);
    $insuranceDetails = htmlspecialchars($_POST['insurance-details']);
    $allergies = htmlspecialchars($_POST['allergies']);
    $surgeries = htmlspecialchars($_POST['surgeries']);
    $illnesses = htmlspecialchars($_POST['illnesses']);
    $medicalHistory = htmlspecialchars($_POST['family-medical-history']);
    $emergencyContact = htmlspecialchars($_POST['emergency-contact-number']);

    // Check if the record exists
    $sqlSelect = "SELECT * FROM medical_records WHERE device_id = ?";
    $stmt = $conn->prepare($sqlSelect);
    $stmt->bind_param("s", $deviceid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update existing record
        $sqlUpdate = "
            UPDATE medical_records 
            SET patient_name = ?, date_of_birth = ?, contact_info = ?, insurance_details = ?, allergies = ?, surgeries = ?, illnesses = ?, medical_history = ?, emergency_contact_number = ? 
            WHERE device_id = ?
        ";
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bind_param(
            "ssssssssss",
            $patientName,
            $dob,
            $contactInfo,
            $insuranceDetails,
            $allergies,
            $surgeries,
            $illnesses,
            $medicalHistory,
            $emergencyContact,
            $deviceid
        );

        if ($stmt->execute()) {
            header("Location: successfullyrecorded.php");
        } else {
            $message = "Error updating record: " . $stmt->error;
        }
    } else {
        // Insert new record
        $sqlInsert = "
            INSERT INTO medical_records (device_id, patient_name, date_of_birth, contact_info, insurance_details, allergies, surgeries, illnesses, medical_history, emergency_contact_number) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ";
        $stmt = $conn->prepare($sqlInsert);
        $stmt->bind_param(
            "ssssssssss",
            $deviceid,
            $patientName,
            $dob,
            $contactInfo,
            $insuranceDetails,
            $allergies,
            $surgeries,
            $illnesses,
            $medicalHistory,
            $emergencyContact
        );

        if ($stmt->execute()) {
            header("Location: successfullyrecorded.php");
        } else {
            $message = "Error inserting record: " . $stmt->error;
        }
    }

    $stmt->close();
} else {
    // Fetch existing record for pre-filling the form
    $sqlSelect = "SELECT * FROM medical_records WHERE device_id = ?";
    $stmt = $conn->prepare($sqlSelect);
    $stmt->bind_param("s", $deviceid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); // Assign fetched data to $user
    }

    $stmt->close();
}

// Close the database connection
$conn->close();
?>