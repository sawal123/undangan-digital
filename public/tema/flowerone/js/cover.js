document.addEventListener('DOMContentLoaded', () => {
    const cover = document.getElementById('cover');
    const openCover = document.getElementById('openCover');
    const videoFrame = document.getElementById('videoFrame');
    const toggleButton = document.getElementById('toggleButton');
    let isPlaying = false;

    if (openCover && cover) {
        openCover.addEventListener('click', () => {
            if (videoFrame && !isPlaying) {
                videoFrame.src = 'https://www.youtube.com/embed/VDbVXpJWA-k?autoplay=1';
            }
            cover.classList.add('d-none');
        });
    }

    if (toggleButton && videoFrame) {
        toggleButton.addEventListener('click', () => {
            isPlaying = !isPlaying;
            videoFrame.src = `https://www.youtube.com/embed/VDbVXpJWA-k?autoplay=${isPlaying ? 1 : 0}`;
            toggleButton.innerHTML = `<i class="fa-solid fa-${isPlaying ? 'pause' : 'play'}"></i>`;
        });
    }
});
