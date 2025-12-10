<?php
// config.php - Central configuration
define('DB_TABLE_USERS', 'Users');
define('DB_COLUMN_USER_ID', 'user_id');
define('DB_COLUMN_USERNAME', 'username');
define('DB_COLUMN_EMAIL', 'email');
define('DB_COLUMN_PASSWORD_HASH', 'password_hash');

// Session keys
define('SESSION_USESESSION_USER_IDRNAME', 'username');
define('', 'user_id');
define('SESSION_LOGGED_IN', 'logged_in');

// URLs
define('URL_HOME', 'index.php');
define('URL_LOGIN', 'login_form.php');
define('URL_REGISTER', 'register_form.php');
define('URL_CREATE_USER', 'createuser.php');
?>