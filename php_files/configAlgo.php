<?php

try {
    include_once('connection.php');
    include_once('sessionhandler.php');

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize form data
        $emergencytype = htmlspecialchars($_POST['emergency-type']);
        $useMedicalServices = isset($_POST['use-medical-services']) ? true : false;
        $medicaldetails = isset($_POST['medical-details']) ? htmlspecialchars($_POST['medical-details']) : null;
        $deviceid = $_SESSION['deviceID'];

        // Check if the record exists
        $sqlSelect = "SELECT * FROM user_config WHERE device_id = ?";
        $stmt = $conn->prepare($sqlSelect);

        if ($stmt) {
            $stmt->bind_param("s", $deviceid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // Record exists, update it
                $sqlUpdate = "
                    UPDATE user_config
                    SET config = ?, medical_details = ?, use_services = ?
                    WHERE device_id = ?
                ";
                $stmtUpdate = $conn->prepare($sqlUpdate);

                if ($stmtUpdate) {
                    $stmtUpdate->bind_param("ssss", $emergencytype, $medicaldetails, $useMedicalServices, $deviceid);

                    if ($stmtUpdate->execute()) {
                        header("Location: successfullyrecorded.php");
                    } else {
                        $message = "<h3>Error updating record: " . $stmtUpdate->error . "</h3>";
                    }
                    $stmtUpdate->close();
                } else {
                    $message = "<h3>Error preparing update statement: " . $conn->error . "</h3>";
                }
            } else {
                // Record doesn't exist, insert it
                $sqlInsert = "
                    INSERT INTO user_config (device_id, config, medical_details, use_services)
                    VALUES (?, ?, ?, ?)
                ";
                $stmtInsert = $conn->prepare($sqlInsert);

                if ($stmtInsert) {
                    $stmtInsert->bind_param("ssss", $deviceid, $emergencytype, $medicaldetails, $useMedicalServices);

                    if ($stmtInsert->execute()) {
                        header("Location: medicalrecordform.php");
                    } else {
                        $message = "<h3>Error inserting record: " . $stmtInsert->error . "</h3>";
                    }
                    $stmtInsert->close();
                } else {
                    $message = "<h3>Error preparing insert statement: " . $conn->error . "</h3>";
                }
            }
            $stmt->close();
        } else {
            $message = "<h3>Error preparing select statement: " . $conn->error . "</h3>";
        }
    }
} catch (Exception $e) {
    die("<h3>Error: " . $e->getMessage() . "</h3>");
} finally {
    // Close the connection
    $conn->close();
}
?>