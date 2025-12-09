function updateArtworkList() {
    let artist = document.getElementById("artist").value;

    fetch("load_artworks.php?artist=" + artist)
        .then(response => response.text())
        .then(data => {
            document.getElementById("artwork_response").innerHTML = data;
        });
}

function openArtworkModal(id) {
    fetch("load_artwork_modal.php?id=" + id)
        .then(res => res.text())
        .then(html => {
            document.getElementById("artwork_modal_content").innerHTML = html;
            document.getElementById("artwork_modal").style.display = "block";
            document.getElementById("backdrop").style.display = "block";
        });
}

function closeModal() {
    document.getElementById("artwork_modal").style.display = "none";
    document.getElementById("backdrop").style.display = "none";
}
