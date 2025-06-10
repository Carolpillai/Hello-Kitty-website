document.addEventListener("DOMContentLoaded", function () {
    const images = ["/images/download.jpg", "/images/𝗛𝗘𝗟𝗟𝗢 𝗞𝗜𝗧𝗧𝗬.jpg", "/Images/slide3.jpg", "/Images/slide4.jpg"];
    let index = 0;
    const sliderImage = document.getElementById("slider-image");

    function changeImage() {
        index = (index + 1) % images.length;
        sliderImage.src = images[index];
    }

    setInterval(changeImage, 3000);
});


document.getElementById("authForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let username = document.getElementById("username").value;
    let password = document.getElementById("password").value;
    let action = document.getElementById("form-title").innerText === "Sign Up" ? "signup" : "login";

    fetch("save_user.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username: username, password: password, action: action }),
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        if (data.status === "success") {
            window.location.href = "index.html"; // Redirect on success
        }
    })
    .catch(error => console.error("Error:", error));
});
