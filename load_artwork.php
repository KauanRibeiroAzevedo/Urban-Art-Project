<?php
session_start();
require_once 'db_connect.php';

$user_id = $_SESSION['user_id'] ?? 0;

$sql = "
SELECT 
    a.artwork_id,
    a.user_id,
    a.title,
    a.description,
    a.image_url,
    u.username,
    COALESCE(SUM(
        CASE 
            WHEN v.vote_type = 'up' THEN 1
            WHEN v.vote_type = 'down' THEN -1
            ELSE 0
        END
    ), 0) AS score
FROM Artworks a
JOIN Users u ON a.user_id = u.user_id
LEFT JOIN Artwork_Votes v ON a.artwork_id = v.artwork_id
GROUP BY a.artwork_id
ORDER BY score DESC
";

$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo "<p class='loading'>No artworks found.</p>";
    exit;
}

while ($row = $result->fetch_assoc()):
?>
    <div class="artwork-card">

        <?php if (!empty($row['image_url'])): ?>
            <img
                src="<?= htmlspecialchars($row['image_url']) ?>"
                alt="Artwork image"
                style="width:100%; max-height:300px; object-fit:cover; border-radius:8px; margin-bottom:15px;"
            >
        <?php endif; ?>

        <h4><?= htmlspecialchars($row['title']) ?></h4>
        <p><?= htmlspecialchars($row['description']) ?></p>

        <p>
            <strong>Artist:</strong>
            <?= htmlspecialchars($row['username']) ?>
        </p>

        <div class="vote-box">
            <button onclick="vote(<?= (int)$row['artwork_id'] ?>, 'up')">👍</button>
            <span class="vote-score"><?= (int)$row['score'] ?></span>
            <button onclick="vote(<?= (int)$row['artwork_id'] ?>, 'down')">👎</button>
        </div>

        <?php if ((int)$row['user_id'] === (int)$user_id): ?>
            <form method="POST" action="delete_artwork.php" style="margin-top:10px;">
                <input type="hidden" name="artwork_id" value="<?= (int)$row['artwork_id'] ?>">
                <button type="submit">🗑 Delete Artwork</button>
            </form>
        <?php endif; ?>

    </div>
<?php endwhile;

$conn->close();
?>
