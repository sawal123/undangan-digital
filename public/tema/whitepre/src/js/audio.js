const coverMobile = document.getElementById('cover-mobile');
const openCoverButton = document.getElementById('open-cover');

if (openCoverButton) {
  openCoverButton.addEventListener('click', function () {
    coverMobile.classList.add('hidden');
    window.musicPlayer?.play();
  });
}
