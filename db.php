<?php

$host = 'localhost';    // Database host
$username = 'root';     // Database username
$password = '';         // Database password (usually empty for local XAMPP)
$dbname = 'student_management'; // Database name

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optional: Set the charset to avoid issues with special characters
$conn->set_charset("utf8");

?>
