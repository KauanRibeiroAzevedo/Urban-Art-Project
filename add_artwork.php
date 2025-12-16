<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login_form.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Artwork - Urban Arts</title>
        <link rel="icon" type="image/x-icon" href="/urbanarts/images/favicon.png">


    <link rel="stylesheet" href="/urbanarts/css/styles.css">
    <link rel="stylesheet" href="/urbanarts/css/add_artwork.css">
</head>
<body>

<div class="add-artwork-page">
    <div class="add-artwork-card">

        <h2>Add New Artwork</h2>

        <form method="POST" action="insert_artwork.php">

            <input type="text" name="title" placeholder="Artwork title" required>

            <textarea name="description" placeholder="Artwork description" required></textarea>

            <input type="text" name="location" placeholder="Location (e.g. Galway)" required>

            <input type="url" name="image_url" placeholder="Image URL" required>

            <button type="submit">Upload Artwork</button>

        </form>

    </div>
</div>

</body>
</html>
