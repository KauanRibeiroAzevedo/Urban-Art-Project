<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_form.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get form data
$title       = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$location    = $_POST['location'] ?? '';
$image_url   = $_POST['image_url'] ?? '';

// Insert artwork
$stmt = $conn->prepare("
    INSERT INTO Artworks (user_id, title, description, location, image_url)
    VALUES (?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "issss",
    $user_id,
    $title,
    $description,
    $location,
    $image_url
);

$stmt->execute();

$stmt->close();
$conn->close();

// Redirect back to home
header("Location: index.php");
exit();
