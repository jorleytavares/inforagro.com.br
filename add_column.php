<?php
$host = 'localhost';
$username = 'root';
$password = ''; // Assume empty or try default
$database = 'inforagro';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "ALTER TABLE posts ADD COLUMN custom_schema LONGTEXT DEFAULT NULL AFTER faq_schema";

if ($conn->query($sql) === TRUE) {
    echo "Column custom_schema created successfully";
} else {
    echo "Error creating column: " . $conn->error;
}

$conn->close();
?>
