function loginUser() {
    const formdata = new FormData(document.getElementById("login"));
    
    fetch("login.php", {
        method: "POST",
        body: formdata
    })
    .then((response) => {
        if (response.ok) {
            return response.json();
        }
        throw new Error("Network response was not ok");
    })
    .then((data) => {
        if (data.success) {
            document.getElementById("login_response").innerHTML = data.message;
            document.getElementById("user_name").innerHTML = formdata.get("username");
            closeModal();
        } else {
            document.getElementById("login_response").innerHTML = data.message;
        }
    })
    .catch((error) => {
        console.error("Error:", error);
        document.getElementById("login_response").innerHTML = "Login failed: " + error.message;
    });
}