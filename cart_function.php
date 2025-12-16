<?php
// ===============================
// CART FUNCTIONS
// ===============================

function PHPaddToCart($itemId, $price, $colour, $size, $pattern, $merchandiseId, $image) {

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$itemId])) {
        $_SESSION['cart'][$itemId]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$itemId] = [
            'id' => $itemId,
            'price' => $price,
            'quantity' => 1,
            'colour' => $colour,
            'pattern' => $pattern,
            'size' => $size,
            'merchandise_id' => $merchandiseId,
            'image' => $image
        ];
    }
}

function countItemsAndPrice(): array {

    if (!isset($_SESSION['cart'])) {
        return [
            'no_of_items' => 0,
            'total_price' => 0.00
        ];
    }

    $no_of_items = 0;
    $total_price = 0.00;

    foreach ($_SESSION['cart'] as $item) {
        $no_of_items += $item['quantity'];
        $total_price += $item['quantity'] * $item['price'];
    }

    return [
        'no_of_items' => $no_of_items,
        'total_price' => $total_price
    ];
}
