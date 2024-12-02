<?php
header('Content-Type: application/json');

include_once('..\php_files\connection.php');

$file_path = "C:/xampp/htdocs/arduino/receiver/logs/log.json"; // JSON file path

if (file_exists($file_path)) {

    echo file_get_contents($file_path);

} else {
    echo json_encode(["error" => "No data available"]);
}
?>
