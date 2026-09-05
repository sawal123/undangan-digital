const closeModal = document.getElementById("closeModal");
const modal = document.getElementById("modal");

closeModal.addEventListener("click", () => {
    window.musicPlayer?.play();
    modal.classList.add("invisible");
});

modal.addEventListener("click", (event) => {
    if (event.target === modal) {
        modal.classList.add("invisible");
    }
});
