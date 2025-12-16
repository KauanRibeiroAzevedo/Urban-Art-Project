<?php
session_start();

/* REMOVE ITEM */
if (isset($_POST['id'])) {
    unset($_SESSION['cart'][$_POST['id']]);
}

/* EMPTY CART */
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty.</p>";
    exit;
}

/* SHOW CART ITEMS */
foreach ($_SESSION['cart'] as $id => $item) {
    ?>
    <div class="cart-item">
        <span>
            <?= htmlspecialchars($item['merchandise_id']) ?> × <?= $item['quantity'] ?>
            <br>
            €<?= number_format($item['price'] * $item['quantity'], 2) ?>
        </span>

        <button onclick="removeFromCart('<?= $id ?>')">
            Remove
        </button>
    </div>
    <?php
}
