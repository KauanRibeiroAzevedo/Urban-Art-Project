<?php
session_start();
require_once 'db_connect.php';
require_once 'cart_functions.php';

$cart_info = countItemsAndPrice();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Urban Arts Shop</title>
    <link rel="icon" type="image/x-icon" href="/urbanarts/images/favicon.png">


    
    <link rel="stylesheet" href="css/merch.css">
</head>

<body class="shop-page">

<div class="shop-background">
  <div class="shop-box">

    <!-- CART INFO -->
    <div id="cart_response" class="cart-bar" onclick="openCart()" style="cursor:pointer">
      <span>🛒 <?= $cart_info['no_of_items'] ?> items</span><br>
      €<?= number_format($cart_info['total_price'], 2) ?>
    </div>

    <h1>Urban Arts Shop</h1>

    <form id="merch_form" onsubmit="return false;">
      <button type="button" onclick="updateMerchList()">Load Products</button>
    </form>

    <div id="merch_response"></div>

  </div>
</div>

<div id="basket_modal"></div>

<div id="cart_modal" class="cart-modal">
  <div class="cart-box">
    <span class="close-cart" onclick="closeCart()">✖</span>
    <h2>Your Cart</h2>
    <div id="cart_items"></div>
  </div>
</div>

<div id="backdrop"></div>

<script src="js/merch.js"></script>
</body>
</html>
