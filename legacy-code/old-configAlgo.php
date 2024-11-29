<?php

try {
    include_once('connection.php');
    include_once('sessionhandler.php');

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize form data
        $emergencytype = htmlspecialchars($_POST['emergency-type']);
        $medicaldetails = htmlspecialchars($_POST['medical-details']);
        $email = $_SESSION['email'];
        // SQL query to insert data into the database
        $sqlUpdate = "
            UPDATE user_details
            SET emergencytype=$emergencytype , medicaldetails=$medicaldetails
            WHERE email=$email
        ";

        // Prepare and bind
        $stmt = $conn->prepare($sqlInsert);
        if ($stmt) {
            $stmt->bind_param("ss", $emergencytype, $medicaldetails);

            // Execute the statement
            if ($stmt->execute()) {
                $message = "<h3>Configured successfully!</h3>";
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