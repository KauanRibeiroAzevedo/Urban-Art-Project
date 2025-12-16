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
    <title>Urban Art Gallery</title>
        <link rel="icon" type="image/x-icon" href="/urbanarts/images/favicon.png">


    <link rel="stylesheet" href="/urbanarts/css/styles.css">
</head>
<body>


<div class="filter-container">
    <div class="results-main">
        <h3 class="results-title">Urban Art Gallery</h3>

        <div class="artwork-results" id="gallery-results">
            <p class="loading">Loading artworks...</p>
        </div>
    </div>
</div>

<script>
function loadGallery() {
    fetch("/urbanarts/load_artwork.php")
        .then(res => res.text())
        .then(html => {
            document.getElementById("gallery-results").innerHTML = html;
        });
}

document.addEventListener("DOMContentLoaded", loadGallery);
</script>

<script src="/urbanarts/js/artworks.js"></script>
</body>
</html>
