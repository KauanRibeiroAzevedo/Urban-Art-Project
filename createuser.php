<?php
include 'db_connect.php';
include 'config.php'; // Add this

$username = isset($_POST['username']) ? htmlspecialchars($_POST['username']) : '';
$email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
$password = isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '';

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$emailExists = 0;
$usernameExists = 0;

// Use constants
$sql = "SELECT " . DB_COLUMN_USERNAME . " FROM " . DB_TABLE_USERS . " WHERE " . DB_COLUMN_USERNAME . "=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_username = $stmt->get_result();

if ($result_username->num_rows > 0) {
    $usernameExists = 1;
}

// Use constants
$sql = "SELECT " . DB_COLUMN_EMAIL . " FROM " . DB_TABLE_USERS . " WHERE " . DB_COLUMN_EMAIL . "=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result_email = $stmt->get_result();

if ($result_email->num_rows > 0) {
    $emailExists = 1;
}

if ($usernameExists != 1 && $emailExists != 1) {
    // Use constants
    $stmt = $conn->prepare("INSERT INTO " . DB_TABLE_USERS . " (" . DB_COLUMN_USERNAME . ", " . DB_COLUMN_EMAIL . ", " . DB_COLUMN_PASSWORD_HASH . ") VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    if ($stmt->execute()) {
        header("Location: " . URL_LOGIN . "?registered=1");
        exit();
    } else {
        header("Location: " . URL_REGISTER . "?error=1");
        exit();
    }
} else {
    $error = "";
    if ($usernameExists == 1) $error .= "username_exists&";
    if ($emailExists == 1) $error .= "email_exists";
    
    header("Location: " . URL_REGISTER . "?" . $error);
    exit();
}

$conn->close();
?>