const coverMobile = document.getElementById("cover-mobile");
const openCoverButton = document.getElementById("open-cover");
const musicIcon = document.querySelector("#musicToggle i");

if (musicIcon) {
    new MutationObserver(() => {
        if (musicIcon.classList.contains("fa-pause")) {
            musicIcon.classList.remove("fa-play");
        } else if (musicIcon.classList.contains("fa-music")) {
            musicIcon.classList.remove("fa-music");
            musicIcon.classList.add("fa-play");
        }
    }).observe(musicIcon, { attributes: true, attributeFilter: ["class"] });

    document.getElementById("musicToggle")?.addEventListener("click", () => {
        if (musicIcon.classList.contains("fa-play")) {
            musicIcon.classList.remove("fa-play");
        }
    }, true);
}

if (openCoverButton) {
    openCoverButton.addEventListener("click", function () {
        coverMobile.classList.add("hidden");
        window.musicPlayer?.play();
    });
}
