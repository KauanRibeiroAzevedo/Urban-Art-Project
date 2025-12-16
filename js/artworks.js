/* =========================
   LOAD ARTWORKS (FETCH)
========================= */

function loadArtworks() {
  const artistSelect = document.getElementById("artist");
  const formData = new FormData();

  if (artistSelect && artistSelect.value !== "") {
    formData.append("artist", artistSelect.value);
  }

  fetch("load_artworks.php", {
    method: "POST",
    body: formData
  })
    .then(response => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.text();
    })
    .then(html => {
      document.querySelector(".artwork-results").innerHTML = html;
    })
    .catch(error => {
      console.error("Error loading artworks:", error);
      document.querySelector(".artwork-results").innerHTML =
        "<p class='error'>Failed to load artworks.</p>";
    });
}

/* =========================
   AUTO LOAD ON PAGE LOAD
========================= */
document.addEventListener("DOMContentLoaded", loadArtworks);
