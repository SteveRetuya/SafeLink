<?php

    // Note: SQL - Structured Query Language

try {
    include_once('connection.php'); // the file where it will connect to the database

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize form data
        $email = htmlspecialchars($_POST['textemail']);
        $password = htmlspecialchars($_POST['textpassword']);
        $sex = htmlspecialchars($_POST['sex']);
        $device_id = htmlspecialchars($_POST['deviceid']);
        
        // SQL query to insert data into the database
        $sqlInsert = "
            INSERT INTO user_details
            (email, password, sex, device_id)
            VALUES (?, ?, ?, ?)
        ";

        // The following code checks if there are existing emails in the database
        
        $sql = "SELECT * FROM user_details WHERE email = ?"; // Selects from the database of user_details where email is "?" (a placeholder)
        $stmt = $conn->prepare($sql); // Prepares the query to the sql

        $stmt->bind_param("s",$email); // "Binds" the parameter of the variable $email to be replaced in the "?"

        $stmt->execute(); // Execute the SQL query to the database

        $result = $stmt->get_result(); // Gets the result from the SQL

        $res = $result->num_rows; // Gets the number of rows from the database

        if($res > 1){ // Checks if the email has been registered in the database more than once
            die('<h3>Email already been registered. Try Again. <a href="signup.php"> Go Back.</a></h3>');
        }


        // The following code inserts the data to the database

        $stmt = $conn->prepare($sqlInsert); // Prepares the query to the database to be inserted

        if ($stmt) {

            // "Binds" the parameter of the variables $email, $password, $sex, and $deviceid to be replaced in the "?"
            $stmt->bind_param("ssss", $email, $password, $sex, $deviceid); 

            // Execute query statement to the sql
            if ($stmt->execute()) {
                $message = "<h3>Registered Successfully! </h3>";
                header("Location: login.php"); // Goes to the login.php page to let the user login

            // The rest below from here are error handling    
            } else {
                $message = "<h3>Error: " . $stmt->error . "</h3>";
            }
            $stmt->close(); // Closes the database
        } else {
            $message = "<h3>Error: " . $conn->error . "</h3>"; // Checks the error in the query in the database
        }
    }
} catch (Exception $ex) {  // Catches errors that will be made during the inserting and executing queries
    die("<h3>Error: " . $ex->getMessage() . "</h3>");
} finally {
    // Close the connection
    $conn->close();
}
?>