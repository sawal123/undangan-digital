// JavaScript
const videoFrame = document.getElementById('videoFrame');
const toggleButton = document.getElementById('audio-toggle');
const coverMobile = document.getElementById('cover-mobile');
const openCoverButton = document.getElementById('open-cover');
const youtubePlayer = document.getElementById('youtube-player');
let isPlaying = false;

// Ambil nilai dari atribut data- pada iframe
const soundUrl = videoFrame.getAttribute('data-sound');
const startTime = videoFrame.getAttribute('data-start') || 0; // Default ke 0 jika tidak ada nilai

// Function to play the YouTube video
function playVideo() {
  videoFrame.src = `${soundUrl}?start=${startTime}&autoplay=1&enablejsapi=1`;
  toggleButton.innerHTML = '<i class="fa-solid fa-pause"></i>';
  isPlaying = true;
}

// Function to pause the YouTube video
function pauseVideo() {
  videoFrame.src = `${soundUrl}?start=${startTime}&enablejsapi=1`;
  toggleButton.innerHTML = '<i class="fa-solid fa-play"></i>';
  isPlaying = false;
}
// Toggle Button for Play/Pause
toggleButton.addEventListener('click', function () {
  if (isPlaying) {
    pauseVideo();
  } else {
    playVideo();
  }
});
// Open Cover Button: Hide cover and play video
openCoverButton.addEventListener('click', function () {
  // Hide the cover
  coverMobile.classList.add('hidden');

  // Play the YouTube video
  playVideo();
});

// Function to check if the element is in the viewport
function isElementInViewport(el) {
  const rect = el.getBoundingClientRect();
  return (
    rect.top >= 0 &&
    rect.left >= 0 &&
    rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
    rect.right <= (window.innerWidth || document.documentElement.clientWidth)
  );
}

// Scroll event listener to play video when visible
window.addEventListener('scroll', function () {
  if (!isPlaying && isElementInViewport(youtubePlayer)) {
    youtubePlayer.classList.remove('hidden'); // Make the video visible
    playVideo();
  }
});
