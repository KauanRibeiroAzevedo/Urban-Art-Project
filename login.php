<?php
session_start();
include 'db_connect.php';
include 'config.php'; // Add this

$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

// Use constants for table and column names
$sql = "SELECT * FROM " . DB_TABLE_USERS . " WHERE " . DB_COLUMN_USERNAME . " = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);

$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $user_id = $row[DB_COLUMN_USER_ID];
    $hashed_password = $row[DB_COLUMN_PASSWORD_HASH];

    if (password_verify($password, $hashed_password)) {
        // Use constants for session keys
        $_SESSION[SESSION_USERNAME] = $username;
        $_SESSION[SESSION_USER_ID] = $user_id;
        $_SESSION[SESSION_LOGGED_IN] = true;
        
        echo json_encode([
            'success' => true,
            'message' => 'Login successful!',
            'user_id' => $user_id,
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Incorrect Password',
            'user_id' => 0,
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid Username',
        'user_id' => 0,
    ]);
}

$conn->close();
?>