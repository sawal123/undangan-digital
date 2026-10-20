document.addEventListener('DOMContentLoaded', () => {
    const cover = document.getElementById('cover');
    const openCover = document.getElementById('openCover');

    if (!cover || !openCover) return;

    openCover.addEventListener('click', () => {
        window.musicPlayer?.play();
        cover.classList.add('d-none');
    });
});
