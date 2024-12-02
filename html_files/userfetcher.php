<?php
header('Content-Type: application/json');

include_once('..\php_files\connection.php');  // Include your database connection file

// Path to the JSON file
$file_path = "C:/xampp/htdocs/arduino/receiver/logs/log.json"; 

if (file_exists($file_path)) {
    // Read the JSON file
    $json_data = file_get_contents($file_path);
    
    // Decode the JSON data into an associative array
    $data = json_decode($json_data, true);
    
    // Get the Device Id
    if (isset($data['DID'])) {
        $device_id = $data['DID'];
        
        // Get information related to the person
        $sqlSelectConfig = "SELECT config FROM user_config WHERE device_id = ?";
        $sqlSelectRecords = "SELECT * FROM medical_records WHERE device_id = ?";
        $sqlSelectDetails = "SELECT * FROM user_details WHERE device_id = ?";

        // Prepare and bind
        $stmtPrepConfig = $conn->prepare($sqlSelectConfig);
        $stmtPrepRecords = $conn->prepare($sqlSelectRecords);
        $stmtPrepDetails = $conn->prepare($sqlSelectDetails);
        
        $stmtPrepConfig->bind_param("s", $device_id);
        $stmtPrepRecords->bind_param("s", $device_id);
        $stmtPrepDetails->bind_param("s", $device_id);
        
        // Execute and fetch results for each query
        $stmtPrepConfig->execute();
        $resultConfig = $stmtPrepConfig->get_result();
        $config = $resultConfig->fetch_assoc();
        $stmtPrepConfig->free_result(); // Free result
        
        $stmtPrepRecords->execute();
        $resultRecords = $stmtPrepRecords->get_result();
        $record = $resultRecords->fetch_assoc();
        $stmtPrepRecords->free_result(); // Free result
        
        $stmtPrepDetails->execute();
        $resultDetails = $stmtPrepDetails->get_result();
        $details = $resultDetails->fetch_assoc();
        $stmtPrepDetails->free_result(); // Free result
        
        // Calculate age from DOB
        if (isset($record['date_of_birth'])) { // Assuming 'dob' is the column name in your database
            $dob = new DateTime($record['date_of_birth']);
            $now = new DateTime();
            $age = $dob->diff($now)->y; // Calculate the difference in years
        } else {
            $age = null; // If DOB is missing
        }
        
        // Check if records exist
        if ($config && $record) {
            // Return user data as JSON
            $response = [
                'DID' => $data['DID'],
                'Name' => $record['patient_name'],  // Assuming 'patient_name' is in the medical_records table
                'Age' => $age,                     // Calculated age
                'Gender' => $details['sex'],       // Assuming 'sex' is in the user_details table
                'EmergencyType' => $config['config'],  // Assuming 'config' exists
                'EmergencyContact' => $record['emergency_contact_number'],
                'Coordinates' => [
                    'Latitude' => $data['Latitude'],  // From the JSON file
                    'Longitude' => $data['Longitude'] // From the JSON file
                ]
            ];
            
            echo json_encode($response);
        } else {
            echo json_encode(["error" => "No records found for this device"]);
        }
    } else {
        echo json_encode(["error" => "Device ID not found in JSON data"]);
    }
} else {
    echo json_encode(["error" => "JSON file not found"]);
}
?>
