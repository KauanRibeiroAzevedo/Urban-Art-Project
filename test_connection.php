<?php
include 'db_info.php';

echo "<h2>Testing Database Connection...</h2>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    echo "<p style='color: red;'>✗ FAILED: " . $conn->connect_error . "</p>";
} else {
    echo "<p style='color: green;'>✓ SUCCESS! Connected to database: $dbname</p>";
    
    // Show tables (should be empty for now)
    $result = $conn->query("SHOW TABLES");
    if ($result->num_rows > 0) {
        echo "<p>Tables found:</p>";
        while($row = $result->fetch_array()) {
            echo "<p>• " . $row[0] . "</p>";
        }
    } else {
        echo "<p>No tables yet. You need to create them.</p>";
    }
}

$conn->close();
?>