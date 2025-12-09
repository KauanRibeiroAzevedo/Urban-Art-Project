<?php
// register_form.php - Simple form, no JavaScript
?>
<!DOCTYPE html>
<html>
<head>
    <title>Urban Arts - Register</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 400px; margin: 50px auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 30px; }
        .input-group { margin-bottom: 20px; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        button:hover { background: #45a049; }
        .login-link { text-align: center; margin-top: 25px; color: #666; }
        .login-link a { color: #4a90e2; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Account</h2>
        
        <form method="POST" action="create_user.php">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            
            <div class="input-group">
                <input type="email" name="email" placeholder="Email" required>
            </div>
            
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit">Register</button>
        </form>
        
        <div class="login-link">
            <p>Already have an account? <a href="login_form.php">Login here</a></p>
        </div>
    </div>
</body>
</html>