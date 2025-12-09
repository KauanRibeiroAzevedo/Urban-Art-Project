<?php
session_start();
include 'db_connect.php';

$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

// Prepare the SQL statement
$sql = "SELECT * FROM Users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);

// Execute the Prepared statement
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];

    // FIXED: Use password_hash not password
    $hashed_password = $row['password_hash'];

    if (password_verify($password, $hashed_password)) {
        $_SESSION["username"] = $username;
        $_SESSION["user_id"] = $user_id;
        $_SESSION["logged_in"] = true;
        
        // Return success response with user_id
        echo json_encode([
            'success' => true,
            'message' => 'Login successful!',
            'user_id' => $user_id,
        ]);
    } else {
        // Return failure response
        echo json_encode([
            'success' => false,
            'message' => 'Incorrect Password',
            'user_id' => 0,
        ]);
    }
} else {
    // Return failure response
    echo json_encode([
        'success' => false,
        'message' => 'Invalid Username',
        'user_id' => 0,
    ]);
}

$conn->close();
?>