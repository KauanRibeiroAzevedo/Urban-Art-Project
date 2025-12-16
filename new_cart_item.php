<?php
session_start();
require_once 'cart_functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $merchandiseId = $_POST['merchandise_id'];
    $price = (float) $_POST['price'];
    $colour = $_POST['colour'];
    $size = $_POST['size'];
    $pattern = $_POST['pattern'];
    $image = $_POST['image'];

    // Unique item ID (important)
    $itemId = $merchandiseId . '_' . $size . '_' . $colour . '_' . $pattern;

    PHPaddToCart(
        $itemId,
        $price,
        $colour,
        $size,
        $pattern,
        $merchandiseId,
        $image
    );
}

// Go back to shop
header("Location: shop.php");
exit;
