// Get references to the elements
const cover = document.getElementById('cover');
const openCover = document.getElementById('openCover');

// Open Cover Button Action
openCover.addEventListener('click', function () {
    window.musicPlayer?.play();

    setTimeout(function () {
        // Hide the cover with fade-out effect
        cover.classList.remove('d-block');
        cover.classList.add('d-none', 'fade-out');
    }, 500);
});
