const toggleButton = document.getElementById('toggleButton');
const openCoverButton = document.getElementById('openCover');

if (openCoverButton) {
    openCoverButton.addEventListener('click', () => {
        window.musicPlayer?.play();
    });
}