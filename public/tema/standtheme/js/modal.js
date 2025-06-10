const closeModal = document.getElementById("closeModal");
const modal = document.getElementById("modal");
const videoFrame = document.getElementById("videoFrame");
const audioElement = document.querySelector("#music audio");
const musicPlayer = document.getElementById("musicPlayer");
var isPlaying = false;

closeModal.addEventListener("click", () => {
    if (!isPlaying) {
        // Mengambil URL video dan waktu mulai dari data yang disediakan
        const videoUrl = videoFrame.dataset.videoUrl; // URL video
        const videoStart = videoFrame.dataset.videoStart; // Waktu mulai video
        
        // Mengatur src videoFrame dengan parameter start dan autoplay
        videoFrame.src = `${videoUrl}?start=${videoStart}&autoplay=1`;
        isPlaying = true;
    }
    modal.classList.add("invisible");
});

modal.addEventListener("click", (event) => {
    if (event.target === modal) {
        modal.classList.add("invisible");
    }
});
