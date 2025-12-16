<?php
session_start();
require_once "cart_functions.php";

/* TEMP PRODUCT LIST (Step 2) */
$products = [
  [
    "id" => 1,
    "name" => "Urban Hoodie",
    "description" => "Black streetwear hoodie",
    "price" => 49.99,
    "image" => "images/hoodie.jpg"
  ],
  [
    "id" => 2,
    "name" => "Street T-Shirt",
    "description" => "Oversized urban tee",
    "price" => 24.99,
    "image" => "images/tshirt.jpg"
  ],
  [
    "id" => 3,
    "name" => "Snapback Cap",
    "description" => "Classic urban cap",
    "price" => 19.99,
    "image" => "images/cap.jpg"
  ]
];

if (empty($products)) {
  echo "<p>No products available.</p>";
  exit;
}

foreach ($products as $p) {
  ?>
  <div class="product-card">
    
    <img 
      src="<?= htmlspecialchars($p['image']) ?>" 
      alt="<?= htmlspecialchars($p['name']) ?>"
    >

    <h3><?= htmlspecialchars($p['name']) ?></h3>

    <p class="description">
      <?= htmlspecialchars($p['description']) ?>
    </p>

    <p class="price">
      €<?= number_format($p['price'], 2) ?>
    </p>

    <button onclick="addToCart(<?= (int)$p['id'] ?>)">
      Add to Cart
    </button>

  </div>
  <?php
}
