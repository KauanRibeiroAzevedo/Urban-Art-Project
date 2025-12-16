<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Urban Arts</title>
    <link rel="stylesheet" href="/urbanarts/css/login.css">
    <link rel="icon" type="image/x-icon" href="/urbanarts/images/favicon.png">

</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Login to Urban Arts</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">Invalid username or password</div>
        <?php endif; ?>

        <?php if (isset($_GET['registered'])): ?>
            <div class="success">Account created successfully. Please log in.</div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>

        <!-- ✅ NO HARDCODING -->
        <div class="register-link">
            <p>
                Don’t have an account?
                <a href="<?= URL_REGISTER ?>">Register here</a>
            </p>
        </div>

    </div>
</div>

</body>
</html>
