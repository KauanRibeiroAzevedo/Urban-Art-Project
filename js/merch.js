/* =========================
   LOAD MERCH (AJAX)
========================= */
function updateMerchList() {
  const formData = new FormData(document.getElementById("merch_form"));

  fetch("merchshow.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) return response.text();
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      document.getElementById("merch_response").innerHTML = data;
    })
    .catch((error) => console.error("Error:", error));
}

/* =========================
   ADD TO CART
========================= */
function addToCart(id) {
  const formData = new FormData();
  formData.append("id", id);

  fetch("cartcount.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) return response.text();
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      document.getElementById("cart_response").innerHTML = data;
      updateCart();
    })
    .catch((error) => console.error("Error:", error));
}

/* =========================
   CHANGE CART QUANTITY
========================= */
function changeCartValue(id, value) {
  const formData = new FormData();
  formData.append("id", id);
  formData.append("value", value);

  fetch("new_cart_item.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) return response.text();
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      document.getElementById("cart_response").innerHTML = data;
      updateCart();
    })
    .catch((error) => console.error("Error:", error));
}

/* =========================
   UPDATE CART MODAL
========================= */
function updateCart() {
  fetch("updateCart.php", {
    method: "POST",
  })
    .then((response) => {
      if (response.ok) return response.text();
      throw new Error("Network response was not ok.");
    })
    .then((data) => {
      document.getElementById("basket_modal").innerHTML = data;
    })
    .catch((error) => console.error("Error:", error));
}

/* Load cart on page load */
updateCart();
function openCart() {
  fetch("updateCart.php")
    .then(res => res.text())
    .then(html => {
      document.getElementById("cart_items").innerHTML = html;
      document.getElementById("cart_modal").style.display = "flex";
    });
}

function closeCart() {
  document.getElementById("cart_modal").style.display = "none";
}

function removeFromCart(id) {
  const formData = new FormData();
  formData.append("id", id);

  fetch("updateCart.php", {
    method: "POST",
    body: formData
  }).then(() => {
    openCart();
    updateCart();
  });
}
