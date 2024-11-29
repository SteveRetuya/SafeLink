<?php
    session_start();

    unset($_SESSION['deviceID'])
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin-top: 50px;
            background-color: #f9f9f9;
        }
        .message {
            background-color: #ffffff; /* Red background */
            color: black;
            padding: 20px;
            border-radius: 5px;
            display: inline-block;
            font-size: 1.2rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-size: 2rem;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="message">
        <img src="../pictures/safelink-logo.png">
        <h2>Logging out...</h2>
        <p>Please wait while we log you out of your account.</p>
    </div>

    <script>
        // Redirect the user after 3 seconds
        setTimeout(function() {
            window.location.href = '../index.php'; 
        }, 2000);
    </script>

</body>
</html>