<!DOCTYPE html>
<html>
<head>
    <title>Creating Full Database</title>
</head>
<body>

<?php

// include the connection file
include 'db_info.php';

// Connect without selecting a DB
$conn = new mysqli($servername, $username, $password, NULL, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Drop database if exists
$sql = "DROP DATABASE IF EXISTS $dbname;";
echo ($conn->query($sql) === TRUE) ? "Database dropped successfully<br>" : "Error dropping database: " . $conn->error . "<br>";

// Create database
$sql = "CREATE DATABASE $dbname;";
echo ($conn->query($sql) === TRUE) ? "Database created successfully<br>" : "Error creating database: " . $conn->error . "<br>";

// Reconnect selecting the DB
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

/* =============================
   1. USERS TABLE
   ============================= */
$sql = "CREATE TABLE Users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";
echo ($conn->query($sql) === TRUE) ? "Users table created successfully<br>" : "Error creating Users table: " . $conn->error . "<br>";

/* =============================
   2. MERCH TABLE
   ============================= */
$sql = "CREATE TABLE Merch (
  merch_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  price DECIMAL(8,2) NOT NULL,
  stock_quantity INT NOT NULL,
  description TEXT
) ENGINE=InnoDB;";
echo ($conn->query($sql) === TRUE) ? "Merch table created successfully<br>" : "Error creating Merch table: " . $conn->error . "<br>";

/* =============================
   3. MERCH ORDERS TABLE
   ============================= */
$sql = "CREATE TABLE Merch_Orders (
  merch_order_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  merch_id INT NOT NULL,
  quantity INT NOT NULL,
  total_price DECIMAL(8,2) NOT NULL,
  order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES Users(user_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  FOREIGN KEY (merch_id) REFERENCES Merch(merch_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;";
echo ($conn->query($sql) === TRUE) ? "Merch_Orders table created successfully<br>" : "Error creating Merch_Orders table: " . $conn->error . "<br>";

/* =============================
   4. ARTWORKS TABLE
   ============================= */
$sql = "CREATE TABLE Artworks (
  artwork_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  location VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES Users(user_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;";
echo ($conn->query($sql) === TRUE) ? "Artworks table created successfully<br>" : "Error creating Artworks table: " . $conn->error . "<br>";

/* =============================
   5. COMMENTS TABLE
   ============================= */
$sql = "CREATE TABLE Comments (
  comment_id INT AUTO_INCREMENT PRIMARY KEY,
  artwork_id INT NOT NULL,
  user_id INT NOT NULL,
  comment_text TEXT NOT NULL,
  comment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (artwork_id) REFERENCES Artworks(artwork_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  FOREIGN KEY (user_id) REFERENCES Users(user_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
) ENGINE=InnoDB;";
echo ($conn->query($sql) === TRUE) ? "Comments table created successfully<br>" : "Error creating Comments table: " . $conn->error . "<br>";

/* =============================
   6. ARTWORK VOTES TABLE
   ============================= */
$sql = "CREATE TABLE Artwork_Votes (
  vote_id INT AUTO_INCREMENT PRIMARY KEY,
  artwork_id INT NOT NULL,
  user_id INT NOT NULL,
  vote_type ENUM('up', 'down') NOT NULL,
  vote_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

  FOREIGN KEY (artwork_id) REFERENCES Artworks(artwork_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  FOREIGN KEY (user_id) REFERENCES Users(user_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,

  UNIQUE (artwork_id, user_id)
) ENGINE=InnoDB;";
echo ($conn->query($sql) === TRUE) ? "Artwork_Votes table created successfully<br>" : "Error creating Artwork_Votes table: " . $conn->error . "<br>";

$conn->close();

?>

</body>
</html>
