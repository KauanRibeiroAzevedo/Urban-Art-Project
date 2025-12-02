<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/x-icon" href="images/articon.png">
</head>

<?php
include 'db_connect.php';

// Fetch distinct users (artists)
$sql = "SELECT DISTINCT user_id, username FROM Users ORDER BY username";
$usersResult = $conn->query($sql);
?>

<body>

<center>
    <img src="images/banner.png" width="100%">
    <p></p>
</center>

<!-- Modal + backdrop -->
<div id="backdrop"></div>

<div id="artwork_modal" class="box3">
    <button class="close-btn" onclick="closeModal()">×</button>
    <div id="artwork_modal_content"></div>
</div>

<div class="div-border table-layout">
    <table id="shoppingtable">
        <tr class="shoptr">

            <!-- Filter panel -->
            <td id="form-cell">

                <form id="artwork_form">
                    <select name="artist" id="artist" onchange="updateArtworkList()">
                        <option value="" disabled selected>Select an Artist</option>
                        <option value="">All</option>
                        <?php while ($row = $usersResult->fetch_assoc()) {
                            echo "<option value='" . $row["user_id"] . "'>" . $row["username"] . "</option>";
                        } ?>
                    </select>
                </form>

            </td>

            <!-- Response/results panel -->
            <td id="response-cell">
                <div id="artwork_response" class="div-border"></div>
            </td>

        </tr>
    </table>
</div>

</body>

<script src="js/artworks.js"></script>

</html>