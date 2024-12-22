// Mendapatkan elemen dan link berdasarkan ID dan kelas
const home = document.getElementById('home');
const homeLink = document.getElementsByClassName('home');
const detail = document.getElementById('detail');
const detailLink = document.getElementsByClassName('detail');
const gallery = document.getElementById('gallery');
const galleryLink = document.getElementsByClassName('gallery');
const reservation = document.getElementById('reservation');
const reservationLink = document.getElementsByClassName('reservation');
const message = document.getElementById('message');
const messageLink = document.getElementsByClassName('message');

// Fungsi untuk menambahkan class active pada link yang sesuai
function setActive(link) {
  const allLinks = document.getElementsByClassName('nav-link');
  // Menghapus class active dari semua link
  for (let i = 0; i < allLinks.length; i++) {
    allLinks[i].classList.remove('active');
  }
  // Menambahkan class active hanya pada link yang sedang aktif
  for (let i = 0; i < link.length; i++) {
    link[i].classList.add('active');
  }
}

// Fungsi untuk mengecek apakah elemen berada di dalam viewport
function isInViewport(element) {
  const rect = element.getBoundingClientRect();
  return rect.top >= -5 && rect.bottom <= window.innerHeight;
}

// Event handler onscroll untuk window
window.onscroll = function () {
  if (isInViewport(home)) {
    setActive(homeLink);
  } else if (isInViewport(detail)) {
    setActive(detailLink);
  } else if (isInViewport(gallery)) {
    setActive(galleryLink);
  } else if (isInViewport(reservation)) {
    setActive(reservationLink);
  } else if (isInViewport(message)) {
    setActive(messageLink);
  }
};
