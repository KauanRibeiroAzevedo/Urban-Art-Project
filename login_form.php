<?php
// login_form.php
?>
<!DOCTYPE html>
<html>
<head>
    <title>Urban Arts - Login</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 400px; margin: 100px auto; background: white; padding: 30px; border-radius: 5px; }
        h2 { text-align: center; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { background: #333; color: white; border: none; padding: 12px; width: 100%; }
        #message { margin: 10px 0; padding: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Urban Arts Login</h2>
        <form id="loginForm">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <div id="message"></div>
        <p style="text-align: center;">Don't have an account? <a href="register_form.php">Register</a></p>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const messageDiv = document.getElementById('message');
            
            fetch('login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    messageDiv.innerHTML = `<p style="color:green;">${data.message}</p>`;
                    setTimeout(() => {
                        window.location.href = 'home.php';
                    }, 1000);
                } else {
                    messageDiv.innerHTML = `<p style="color:red;">${data.message}</p>`;
                }
            })
            .catch(error => {
                messageDiv.innerHTML = '<p style="color:red;">Login error</p>';
            });
        });
    </script>
</body>
</html>