<?php
session_start();
require_once 'cart_functions.php';

/* TEMP PRODUCT LIST — MUST MATCH merchshow.php */
$products = [
  1 => [
    "price" => 49.99,
    "image" => "images/hoodie.jpg"
  ],
  2 => [
    "price" => 24.99,
    "image" => "images/tshirt.jpg"
  ],
  3 => [
    "price" => 19.99,
    "image" => "images/cap.jpg"
  ]
];

if (!isset($_POST['id'])) {
    exit;
}

$id = (int)$_POST['id'];

if (!isset($products[$id])) {
    exit;
}

PHPaddToCart(
    $id,
    $products[$id]['price'],
    'Black',
    'M',
    'Plain',
    $id,
    $products[$id]['image']
);

$cart = countItemsAndPrice();

echo "<span>🛒 {$cart['no_of_items']} items</span><br>";
echo "€" . number_format($cart['total_price'], 2);
