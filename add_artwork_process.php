<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['logged_in'])) {
    header("Location: login_form.php");
    exit;
}

$user_id     = $_SESSION['user_id'];
$title       = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$location    = $_POST['location'] ?? '';
$image_url   = $_POST['image_url'] ?? '';

$sql = "
    INSERT INTO Artworks (user_id, title, description, location, image_url)
    VALUES (?, ?, ?, ?, ?)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "issss",
    $user_id,
    $title,
    $description,
    $location,
    $image_url
);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "Error adding artwork.";
}

$conn->close();
