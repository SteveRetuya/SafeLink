<?php
    include_once('connection.php');

    $deviceid = $_SESSION['deviceID'];

    $sqlSelect = "SELECT * FROM user_config WHERE device_id = ?";
    $stmt = $conn->prepare($sqlSelect);
    $stmt->bind_param("s", $deviceid);
    $stmt->execute();
    $result = $stmt->get_result();
    $rowNum = $result->num_rows;

    if($rowNum == 0){
        header("Location: php_files/config.php");
    } else {
        header("Location: php_files/homepage.php");
    }
?>