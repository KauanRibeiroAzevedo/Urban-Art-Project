<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_form.php");
    exit();
}

$user_id = $_SESSION['user_id'] ?? 0;
$artwork_id = $_POST['artwork_id'] ?? 0;

if ($artwork_id <= 0) {
    header("Location: index.php");
    exit();
}

/*
  Delete ONLY if the artwork belongs to the logged-in user
*/
$stmt = $conn->prepare("
    DELETE FROM Artworks 
    WHERE artwork_id = ? AND user_id = ?
");
$stmt->bind_param("ii", $artwork_id, $user_id);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: index.php");
exit();
