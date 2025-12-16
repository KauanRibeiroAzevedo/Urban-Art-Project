<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - Urban Arts</title>
    <link rel="stylesheet" href="/urbanarts/css/login.css">
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Create Account</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="error">Registration failed. Please try again.</div>
        <?php endif; ?>

        <?php if (isset($_GET['username_exists'])): ?>
            <div class="error">Username already exists.</div>
        <?php endif; ?>

        <?php if (isset($_GET['email_exists'])): ?>
            <div class="error">Email already exists.</div>
        <?php endif; ?>

        <form method="POST" action="<?= URL_CREATE_USER ?>">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Register</button>
        </form>

        <div class="login-link">
            Already have an account?
            <a href="<?= URL_LOGIN ?>">Login here</a>
        </div>
    </div>
</div>

</body>
</html>
