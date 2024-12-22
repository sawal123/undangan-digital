// Get references to the elements
const cover = document.getElementById('cover');
const openCover = document.getElementById('openCover');
const videoFrame = document.getElementById('videoFrame');
const toggleButton = document.getElementById('toggleButton');
let isPlaying = false;

// Get video URL and start time from data attributes
const videoUrl = videoFrame.getAttribute('data-video-url');
const videoStart = videoFrame.getAttribute('data-video-start');

// Open Cover Button Action
openCover.addEventListener('click', function () {
    if (!isPlaying) {
        videoFrame.src = `${videoUrl}?start=${videoStart}&autoplay=1`;
    }

    setTimeout(function () {
        // Hide the cover with fade-out effect
        cover.classList.remove('d-block');
        cover.classList.add('d-none', 'fade-out');
    }, 500);
});

// Button Modal YT Toggle Play/Pause
toggleButton.addEventListener('click', function () {
    if (!isPlaying) {
        videoFrame.src = `${videoUrl}?start=${videoStart}&autoplay=1`;
        toggleButton.innerHTML = '<i class="fa-solid fa-pause"></i>';
    } else {
        videoFrame.src = `${videoUrl}?start=${videoStart}`;
        toggleButton.innerHTML = '<i class="fa-solid fa-play"></i>';
    }

    isPlaying = !isPlaying;
});
