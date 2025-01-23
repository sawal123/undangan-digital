// MOdal qr

const closeModal = document.getElementById("closeModal");
const modal = document.getElementById("modal");
const audioElement = document.querySelector("#music audio");
const musicPlayer = document.getElementById("musicPlayer");
var isPlaying = false;
  closeModal.addEventListener("click", () => {
  if (!isPlaying) {
    videoFrame.src =
      "https://www.youtube.com/embed/VDbVXpJWA-k?si=HTH9oH1X5uoS-SUu&amp;autoplay=1";
  }
  modal.classList.add("invisible");
});

// closeModal.addEventListener("click", () => {
//   modal.classList.add("invisible");
//   musicPlayer.play();
// });

modal.addEventListener("click", (event) => {
  if (event.target === modal) {
    modal.classList.add("invisible");
  }
});
