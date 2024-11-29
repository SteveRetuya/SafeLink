<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Home | SafeLink</title>
        <link href="..\css_files\MedicalRecordCSS.css" rel="stylesheet" type="text/css">
        <style>
        /* CSS to center the buttons on the page */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
            font-family: Arial, sans-serif;
        }

        .button-container {
            text-align: center;
        }

        button {
            background-color: #4CAF50; /* Green background */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #45a049; /* Darker green on hover */
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="button-container">
    <img src="../pictures/safelink-logo.png">
        <button onclick="window.location.href='config.php'">Setup Portable Emergency Button Type</button>
        <button onclick="window.location.href='medicalrecordform.php'">Medical Record Form</button>
        <button onclick="window.location.href='logout.php'">Log Out</button>
    </div>

    </body>
</html>