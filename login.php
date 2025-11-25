<?php
session_start();
header('Content-Type: application/json');

include 'db_connect.php';

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Get JSON input
$input = json_decode(file_get_contents('php://input'), true);
$username = $input['username'] ?? '';
$password = $input['password'] ?? '';

// Validate input
if (empty($username) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Username and password are required']);
    exit;
}

try {
    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT user_id, username, password, user_type FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Your code here:
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $user_id = $row['user_id'];

        // Retrieve the hashed password from the database
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION["username"] = $username;
            $_SESSION["user_id"] = $user_id;
            $_SESSION["user_type"] = $row['user_type'];
            
            // Return success response with user_id
            echo json_encode([
                'success' => true,
                'message' => 'Login successful!',
                'user_id' => $user_id,
                'username' => $username,
                'user_type' => $row['user_type']
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid password']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'User not found']);
    }

    $stmt->close();
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?>