// Get references to the elements
const index = document.getElementById('index');
const cover = document.getElementById('cover');
const openCover = document.getElementById('openCover');
const videoFrame = document.getElementById('videoFrame');
const toggleButton = document.getElementById('toggleButton');
let isPlaying = false;


openCover.addEventListener('click', function () {

    if (!isPlaying) {
        videoFrame.src = "https://www.youtube.com/embed/VDbVXpJWA-k?si=HTH9oH1X5uoS-SUu&amp;autoplay=1";
    }
    setTimeout(function () {
        // Hide the cover with fade-out effect
        cover.classList.remove('d-block');
        cover.classList.add('d-none', 'fade-out');
    }, 500);
}); 


// Button Modal YT
toggleButton.addEventListener('click', function () {
    if (!isPlaying) {
        videoFrame.src = "https://www.youtube.com/embed/VDbVXpJWA-k?si=HTH9oH1X5uoS-SUu&amp;autoplay=1";
        toggleButton.innerHTML = '<i class="fa-solid fa-pause"></i>'; 
    } else {
        videoFrame.src = "https://www.youtube.com/embed/VDbVXpJWA-k?si=HTH9oH1X5uoS-SUu";
        toggleButton.innerHTML = '<i class="fa-solid fa-play"></i>'; 
    }
    
    isPlaying = !isPlaying;
});