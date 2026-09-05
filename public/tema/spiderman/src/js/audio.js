const coverMobile = document.getElementById('cover');
const openCoverButton = document.getElementById('open-cover');

openCoverButton.addEventListener('click', function () {
  coverMobile.classList.add('hidden');
  window.musicPlayer?.play();
});
