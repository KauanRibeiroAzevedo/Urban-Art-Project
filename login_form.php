<?php
// login_form.php - Simple HTML form with JS
?>
<!DOCTYPE html>
<html>
<head>
    <title>Urban Arts - Login</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background: #f5f5f5; }
        .container { max-width: 400px; margin: 100px auto; background: white; padding: 40px; border-radius: 10px; box-shadow: 0 0 20px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #333; margin-bottom: 30px; }
        .input-group { margin-bottom: 20px; }
        input { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-size: 16px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; background: #4a90e2; color: white; border: none; border-radius: 5px; font-size: 16px; cursor: pointer; }
        button:hover { background: #357ae8; }
        .message { padding: 12px; margin: 15px 0; border-radius: 5px; text-align: center; display: none; }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .register-link { text-align: center; margin-top: 25px; color: #666; }
        .register-link a { color: #4a90e2; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login to Urban Arts</h2>
        
        <div id="message" class="message"></div>
        
        <div class="input-group">
            <input type="text" id="username" placeholder="Username" required>
        </div>
        
        <div class="input-group">
            <input type="password" id="password" placeholder="Password" required>
        </div>
        
        <button onclick="login()">Login</button>
        
        <div class="register-link">
            <p>Don't have an account? <a href="register_form.php">Register here</a></p>
        </div>
    </div>

    <script>
        function login() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const messageDiv = document.getElementById('message');
            
            // Clear previous message
            messageDiv.style.display = 'none';
            messageDiv.className = 'message';
            
            // Basic validation
            if (!username || !password) {
                showMessage('Please fill in all fields', 'error');
                return;
            }
            
            // Send login request
            fetch('login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    // Redirect to home page after successful login
                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1000);
                } else {
                    showMessage(data.message, 'error');
                }
            })
            .catch(error => {
                showMessage('Login failed. Please try again.', 'error');
                console.error('Error:', error);
            });
        }
        
        function showMessage(text, type) {
            const messageDiv = document.getElementById('message');
            messageDiv.textContent = text;
            messageDiv.className = `message ${type}`;
            messageDiv.style.display = 'block';
        }
        
        // Allow Enter key to submit form
        document.getElementById('password').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                login();
            }
        });
    </script>
</body>
</html>