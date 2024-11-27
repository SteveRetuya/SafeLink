<?php
    include_once('connection.php');

    // Handles the form submission 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Gets the fields in the HTML form
        $email = $_POST['textemail'];
        $pass = $_POST['textpassword'];

        // The command where it will selects the email and password in the database of user_details 
        $sql = "SELECT * FROM user_details WHERE email = ? AND password = ?";
        
        // Prepares the query statement
        $stmt = $conn->prepare($sql);

        // "Binds" the parameter of the variable $email and $pass
        $stmt->bind_param("ss",$email,$pass);

        // Executes the query to the database
        $stmt->execute();

        // Gets the result of the query in the database
        $result = $stmt->get_result();

        // Gets the number of rows in the result
        $res = $result->num_rows;

        // echo "$res"; // This is only for debugging purposes keep it commented out

        // Check if specified email is on the database
        if ($res == 1) {

                if($email == "admin@gmail.com"){ // Checks if the email is an admin
                    header("Location: ../html_files/MyMap.html"); // Goes to the Map
                } else { // Goes to the config
                    header("Location: config.php"); // Redirect User to homepage if logged in successfully
                }
                
            } else {
                echo "<h3>Login Error. </h3>";
            }
        } else {
            
        }
?>