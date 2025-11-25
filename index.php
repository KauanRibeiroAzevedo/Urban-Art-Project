<!DOCTYPE html>
<html>
<head>
    <title>Urban Arts Database Setup</title>
</head>
<body>

<?php
include 'db_connect.php';
$conn = new mysqli($servername, $username, $password);

$dbname = "urban_arts_db";

// Drop database if exists
$sql = "DROP DATABASE IF EXISTS $dbname;";
if ($conn->query($sql) === TRUE) {
  echo "Database dropped successfully<br>";
} else {
  echo "Error dropping database: " . $conn->error;
}

// Create database
$sql = "CREATE DATABASE $dbname;";
if ($conn->query($sql) === TRUE) {
  echo "Urban Arts database created successfully<br>";
} else {
  echo "Error creating database: " . $conn->error;
}

$conn->close();

// Reconnect to the new database
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Users/Artists table
$sql = "CREATE TABLE Users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  email VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  bio TEXT,
  profile_picture VARCHAR(255),
  user_type ENUM('artist', 'enthusiast', 'admin') DEFAULT 'enthusiast',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";

if ($conn->query($sql) === TRUE) {
  echo "Users table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

// Art Pieces table
$sql = "CREATE TABLE Art_Pieces (
  art_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  artist_id INT NOT NULL,
  art_type ENUM('graffiti', 'mural', 'sticker', 'stencil', 'installation', 'digital', 'other') DEFAULT 'other',
  location VARCHAR(255),
  latitude DECIMAL(10, 8),
  longitude DECIMAL(10, 8),
  image_url VARCHAR(255),
  created_date DATE,
  status ENUM('active', 'removed', 'restored') DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (artist_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;";

if ($conn->query($sql) === TRUE) {
  echo "Art Pieces table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

// Events table
$sql = "CREATE TABLE Events (
  event_id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  description TEXT,
  organizer_id INT NOT NULL,
  location VARCHAR(255),
  event_date DATETIME,
  image_url VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (organizer_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;";

if ($conn->query($sql) === TRUE) {
  echo "Events table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

// Comments table
$sql = "CREATE TABLE Comments (
  comment_id INT AUTO_INCREMENT PRIMARY KEY,
  art_id INT NOT NULL,
  user_id INT NOT NULL,
  comment_text TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (art_id) REFERENCES Art_Pieces(art_id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE
) ENGINE=InnoDB;";

if ($conn->query($sql) === TRUE) {
  echo "Comments table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

// Likes table
$sql = "CREATE TABLE Likes (
  like_id INT AUTO_INCREMENT PRIMARY KEY,
  art_id INT NOT NULL,
  user_id INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (art_id) REFERENCES Art_Pieces(art_id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES Users(user_id) ON DELETE CASCADE,
  UNIQUE KEY unique_like (art_id, user_id)
) ENGINE=InnoDB;";

if ($conn->query($sql) === TRUE) {
  echo "Likes table created successfully<br>";
} else {
  echo "Error creating table: " . $conn->error;
}

// Insert sample urban art data
$sql = "INSERT INTO Art_Pieces (title, description, artist_id, art_type, location, image_url) VALUES
('City Dreams', 'A vibrant mural depicting urban life and aspirations', 1, 'mural', 'Downtown Arts District', 'city_dreams.jpg'),
('Street Flow', 'Graffiti art showcasing fluid motion and color', 1, 'graffiti', 'Main Street Alley', 'street_flow.jpg'),
('Urban Echoes', 'Stencil work exploring urban soundscapes', 2, 'stencil', 'Central Station', 'urban_echoes.jpg'),
('Concrete Bloom', 'Installation bringing nature to urban spaces', 2, 'installation', 'City Park Wall', 'concrete_bloom.jpg'),
('Digital Rebellion', 'Mixed media digital street art', 1, 'digital', 'Tech Quarter', 'digital_rebellion.jpg'),
('Night Lights', 'Glow-in-the-dark sticker collection', 3, 'sticker', 'Various locations', 'night_lights.jpg'),
('Metro Memories', 'Mural capturing subway culture', 3, 'mural', 'Substation 5', 'metro_memories.jpg'),
('Urban Wildlife', 'Stencils of animals in city environments', 2, 'stencil', 'Riverwalk', 'urban_wildlife.jpg'),
('Color Storm', 'Abstract graffiti explosion', 1, 'graffiti', 'Industrial Zone', 'color_storm.jpg'),
('City Pulse', 'Interactive light installation', 3, 'installation', 'Main Square', 'city_pulse.jpg');";

if ($conn->query($sql) === TRUE) {
  echo "Sample art pieces added successfully<br>";
} else {
  echo "Error inserting art pieces: " . $conn->error;
}

// Insert sample events
$sql = "INSERT INTO Events (title, description, organizer_id, location, event_date) VALUES
('Urban Arts Festival 2024', 'Annual celebration of street art and urban culture', 1, 'City Arts Center', '2024-06-15 10:00:00'),
('Graffiti Workshop', 'Learn spray painting techniques from pros', 2, 'Downtown Warehouse', '2024-05-20 14:00:00'),
('Street Art Tour', 'Guided tour of the best urban art in the city', 3, 'Meeting at Central Plaza', '2024-05-25 11:00:00'),
('Stencil Art Competition', 'Showcase your stencil art skills', 1, 'Community Arts Space', '2024-06-05 16:00:00');";

if ($conn->query($sql) === TRUE) {
  echo "Sample events added successfully<br>";
} else {
  echo "Error inserting events: " . $conn->error;
}

echo "<h3>Urban Arts Database Setup Complete!</h3>";
echo "<p>Your database now includes:</p>";
echo "<ul>";
echo "<li>Users/Artists table</li>";
echo "<li>Art Pieces table</li>";
echo "<li>Events table</li>";
echo "<li>Comments system</li>";
echo "<li>Likes system</li>";
echo "</ul>";

$conn->close();
?>

</body>
</html>