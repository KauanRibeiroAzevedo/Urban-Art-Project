<?php
// navigation_bar.php
session_start();

// Check if user is logged in
$is_logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
$username = $_SESSION['username'] ?? 'Guest';
?>

<nav class="top-nav">
    <!-- Logo / Site Name -->
    <div class="nav-logo">
        <a href="home.php">🎨 Urban Arts Map</a>  <!-- CHANGED: index.php → home.php -->
    </div>
    
    <!-- Navigation Links -->
    <div class="nav-links">
        <a href="home.php">Home</a>  <!-- CHANGED: index.php → home.php -->
        
        <?php if ($is_logged_in): ?>
            <!-- Show these when logged in -->
            <a href="shop.php">Shop</a>
            <a href="profile.php">Profile (<?php echo htmlspecialchars($username); ?>)</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <!-- Show these when NOT logged in -->
            <a href="login_form.php">Login</a>
            <a href="register_form.php">Sign Up</a>
        <?php endif; ?>
    </div>
</nav>