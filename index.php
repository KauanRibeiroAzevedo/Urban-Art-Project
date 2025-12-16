<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login_form.php');
    exit();
}

require_once 'db_connect.php';
$username = $_SESSION['username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Urban Arts - Home</title>

    <link rel="stylesheet" href="/urbanarts/css/styles.css">
    <link rel="icon" type="image/x-icon" href="/urbanarts/images/favicon.png">
</head>
<body>

<!-- ===== HERO / WELCOME SECTION ===== -->
<div class="hero">
    <h1>Welcome to Urban Arts Mapping</h1>

    <p class="hero-hello">
        Hello, <strong><?= htmlspecialchars($username) ?></strong>!
    </p>

    <p class="hero-subtitle">
        Explore street art, vote on favorites, and connect with artists.
    </p>

    <div class="hero-buttons">
        <a href="gallery.php" class="hero-btn primary">Browse Artworks</a>
        <a href="add_artwork.php" class="hero-btn outline">Add New Artwork</a>
        <a href="shop.php" class="hero-btn outline">Shop</a>
    </div>
</div>

<!-- ===== FILTER + RESULTS ===== -->
<div class="filter-container">
    <div class="filter-grid">

        <!-- ===== SIDEBAR ===== -->
        <div class="filter-sidebar">
            <h3 class="filter-title">Filter Artworks by Artist</h3>

            <form class="filter-form" onsubmit="return false;">
                <select id="artist" class="artist-select">
                    <option value="">All Artists</option>
                    <?php
                    $stmt = $conn->prepare("SELECT user_id, username FROM Users ORDER BY username");
                    $stmt->execute();
                    $res = $stmt->get_result();

                    while ($row = $res->fetch_assoc()) {
                        echo '<option value="' . $row['user_id'] . '">'
                           . htmlspecialchars($row['username'])
                           . '</option>';
                    }
                    ?>
                </select>

                <button type="button" class="filter-button" onclick="loadArtworks()">
                    Search
                </button>
            </form>

            <!-- ===== STATS ===== -->
            <div class="stats-box">
                <h4 class="stats-title">Quick Stats</h4>

                <?php
                $stats = $conn->query("
                    SELECT
                        (SELECT COUNT(*) FROM Artworks) AS artworks,
                        (SELECT COUNT(*) FROM Users) AS users,
                        (SELECT COUNT(*) FROM Artwork_Votes) AS votes
                ")->fetch_assoc();
                ?>

                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-label">Artworks</span>
                        <span class="stat-value"><?= $stats['artworks'] ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Artists</span>
                        <span class="stat-value"><?= $stats['users'] ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Votes</span>
                        <span class="stat-value"><?= $stats['votes'] ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== RESULTS ===== -->
        <div class="results-main">
            <h3 class="results-title">Artworks Gallery</h3>
            <div class="artwork-results">
                <p class="loading">Loading artworks...</p>
            </div>
        </div>

    </div>
</div>

<script src="/urbanarts/js/artworks.js"></script>
</body>
</html>

<?php $conn->close(); ?>
