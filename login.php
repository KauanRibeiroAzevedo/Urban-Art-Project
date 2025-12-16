<?php
session_start();
require_once 'db_connect.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT user_id, username, password_hash FROM Users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password_hash'])) {

        // 🍪 SET COOKIE (7 DAYS)
        setcookie(
            "urbanarts_user",
            $row['username'],
            time() + (7 * 24 * 60 * 60),
            "/"
        );

        // ✅ SESSIONS
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id']  = $row['user_id'];
        $_SESSION['username'] = $row['username'];

        // ✅ REDIRECT
        header("Location: index.php");
        exit;
    }
}

// ❌ FAILED LOGIN
header("Location: login_form.php?error=1");
exit;
