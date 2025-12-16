<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Not logged in");
}

$user_id = $_SESSION['user_id'];
$artwork_id = $_POST['artwork_id'] ?? null;
$vote_type = $_POST['vote_type'] ?? null;

if (!$artwork_id || !in_array($vote_type, ['up', 'down'])) {
    http_response_code(400);
    exit("Invalid vote");
}

/* Prevent duplicate votes */
$stmt = $conn->prepare("
    SELECT vote_id FROM Artwork_Votes
    WHERE artwork_id = ? AND user_id = ?
");
$stmt->bind_param("ii", $artwork_id, $user_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
    /* Update existing vote */
    $stmt = $conn->prepare("
        UPDATE Artwork_Votes
        SET vote_type = ?, vote_date = NOW()
        WHERE artwork_id = ? AND user_id = ?
    ");
    $stmt->bind_param("sii", $vote_type, $artwork_id, $user_id);
} else {
    /* Insert new vote */
    $stmt = $conn->prepare("
        INSERT INTO Artwork_Votes (artwork_id, user_id, vote_type, vote_date)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->bind_param("iis", $artwork_id, $user_id, $vote_type);
}

$stmt->execute();
$conn->close();

echo "OK";
