<?php
// db_connect.php
include 'db_info.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set
$conn->set_charset("utf8mb4");

// Optional: For debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
?>