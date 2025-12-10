<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login_form.php');
    exit();
}

include 'db_connect.php';

// Get username for display
$username = $_SESSION['username'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Urban Arts - Home</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="images/articon.png">
</head>
<body>
    <!-- Include Navigation Bar -->
    <?php include 'navigation_bar.php'; ?>
    
    <!-- Banner -->
    <div class="banner-container">
        <img src="images/banner.png" alt="Urban Arts Banner" class="banner-image">
    </div>
    
    <!-- Welcome Message -->
    <div class="welcome-section">
        <h1>Welcome to Urban Arts Mapping</h1>
        <p class="welcome-message">Hello, <strong><?php echo htmlspecialchars($username); ?></strong>!</p>
        <p class="welcome-subtitle">Explore street art, vote on favorites, and connect with artists.</p>
        
        <div class="quick-links">
            <a href="artworks.php" class="btn btn-primary">Browse Artworks</a>
            <a href="add_artwork.php" class="btn btn-secondary">Add New Artwork</a>
            <a href="map.php" class="btn btn-tertiary">View Map</a>
        </div>
    </div>
    
    <!-- Artwork Filter System -->
    <div class="filter-container">
        <div class="filter-grid">
            <!-- Filter Panel -->
            <div class="filter-sidebar">
                <?php
                // Fetch distinct users (artists) from database
                $sql = "SELECT DISTINCT user_id, username FROM Users ORDER BY username";
                $usersResult = $conn->query($sql);
                ?>
                
                <h3 class="filter-title">Filter Artworks by Artist</h3>
                <form id="artwork_form" class="filter-form">
                    <select name="artist" id="artist" class="artist-select">
                        <option value="" disabled selected>Select an Artist</option>
                        <option value="">All Artists</option>
                        <?php 
                        if ($usersResult->num_rows > 0) {
                            while ($row = $usersResult->fetch_assoc()) {
                                echo '<option value="' . $row["user_id"] . '">' . htmlspecialchars($row["username"]) . '</option>';
                            }
                        } else {
                            echo '<option value="" disabled>No artists found</option>';
                        }
                        ?>
                    </select>
                    <button type="button" onclick="updateArtworkList()" class="filter-button">
                        Search Artworks
                    </button>
                </form>
                
                <!-- Stats from Database -->
                <div class="stats-box">
                    <h4 class="stats-title">Quick Stats</h4>
                    <?php
                    // Get quick stats from database
                    $stats_sql = "SELECT 
                                    (SELECT COUNT(*) FROM Artworks) as total_artworks,
                                    (SELECT COUNT(*) FROM Users) as total_artists,
                                    (SELECT COUNT(*) FROM Artwork_Votes) as total_votes,
                                    (SELECT COUNT(*) FROM Comments) as total_comments";
                    $stats_result = $conn->query($stats_sql);
                    
                    if ($stats_result && $stats_result->num_rows > 0) {
                        $stats = $stats_result->fetch_assoc();
                        echo '<div class="stats-grid">';
                        echo '<div class="stat-item"><span class="stat-label">Artworks</span><span class="stat-value">' . ($stats['total_artworks'] ?? 0) . '</span></div>';
                        echo '<div class="stat-item"><span class="stat-label">Artists</span><span class="stat-value">' . ($stats['total_artists'] ?? 0) . '</span></div>';
                        echo '<div class="stat-item"><span class="stat-label">Votes</span><span class="stat-value">' . ($stats['total_votes'] ?? 0) . '</span></div>';
                        echo '<div class="stat-item"><span class="stat-label">Comments</span><span class="stat-value">' . ($stats['total_comments'] ?? 0) . '</span></div>';
                        echo '</div>';
                    } else {
                        echo '<p class="no-stats">No statistics available yet.</p>';
                    }
                    ?>
                </div>
            </div>
            
            <!-- Results Panel -->
            <div class="results-main">
                <h3 class="results-title">Artworks Gallery</h3>
                <div id="artwork_response" class="artwork-results">
                    <p class="results-placeholder">Select an artist or click "Search Artworks" to view artworks.</p>
                    <p class="results-subtext">Or use the quick links above to browse all artworks.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Structure -->
    <div id="backdrop" class="modal-backdrop"></div>
    <div id="artwork_modal" class="artwork-modal">
        <button class="modal-close-btn" onclick="closeModal()">×</button>
        <div id="artwork_modal_content" class="modal-content"></div>
    </div>
    
    <!-- JavaScript -->
    <script src="js/artworks.js"></script>
    
    <script>
    // Initialize artwork list on page load
    document.addEventListener('DOMContentLoaded', function() {
        updateArtworkList(); // Load all artworks by default
    });
    
    function updateArtworkList() {
        let artist = document.getElementById("artist").value;
        let resultsDiv = document.getElementById("artwork_response");
        
        // Show loading state
        resultsDiv.innerHTML = '<div class="loading">Loading artworks...</div>';
        
        fetch("load_artworks.php?artist=" + encodeURIComponent(artist))
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(data => {
                resultsDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error loading artworks:', error);
                resultsDiv.innerHTML = '<div class="error-message">Error loading artworks. Please try again.</div>';
            });
    }
    
    function openArtworkModal(id) {
        fetch("load_artwork_modal.php?id=" + encodeURIComponent(id))
            .then(response => {
                if (!response.ok) throw new Error('Network response was not ok');
                return response.text();
            })
            .then(html => {
                document.getElementById("artwork_modal_content").innerHTML = html;
                document.getElementById("artwork_modal").style.display = "block";
                document.getElementById("backdrop").style.display = "block";
            })
            .catch(error => {
                console.error('Error loading modal:', error);
                alert('Error loading artwork details.');
            });
    }
    
    function closeModal() {
        document.getElementById("artwork_modal").style.display = "none";
        document.getElementById("backdrop").style.display = "none";
    }
    
    // Close modal when clicking backdrop
    document.getElementById('backdrop').addEventListener('click', closeModal);
    
    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeModal();
        }
    });
    </script>
    
</body>
</html>

<?php
// Close database connection
if (isset($conn)) {
    $conn->close();
}
?>