
// document.addEventListener("DOMContentLoaded", () => {
//     const navLinks = document.querySelectorAll(".nav-link");
  
//     navLinks.forEach((link) => {
//       link.addEventListener("click", () => {
//         // Reset semua tombol
//         navLinks.forEach((item) => {
//           const span = item.querySelector("span");
//           if (span) span.classList.add("hidden");
//           item.classList.remove("bg-orange-200", "text-black");
//         });
  
//         // Tampilkan teks dan tambahkan gaya pada tombol yang diklik
//         const currentSpan = link.querySelector("span");
//         if (currentSpan) currentSpan.classList.remove("hidden");
//         link.classList.add("bg-orange-200", "text-black", "rounded-full",);
//         link.classList.remove("text-orange-200", )
//       });
//     });
//   });
  
// Mendapatkan elemen dan link berdasarkan ID dan kelas
const home = document.getElementById('couple');
const homeLink = document.getElementsByClassName('couple');
const detail = document.getElementById('date');
const detailLink = document.getElementsByClassName('date');
const gallery = document.getElementById('gallery');
const galleryLink = document.getElementsByClassName('gallery');
const reservation = document.getElementById('location');
const reservationLink = document.getElementsByClassName('location');
const message = document.getElementById('wishes');
const messageLink = document.getElementsByClassName('wishes');

// Fungsi untuk menambahkan class active pada link yang sesuai
function setActive(link) {
  const allLinks = document.getElementsByClassName('nav-link');
  
  // Menghapus class aktif dari semua link
  for (let i = 0; i < allLinks.length; i++) {
    const span = allLinks[i].querySelector("span");
    if (span) span.classList.add("hidden"); // Sembunyikan span
    allLinks[i].classList.remove('bg-pink-800', 'text-orange-50', 'rounded-full'); // Hapus semua kelas aktif
  }

  // Menambahkan class aktif hanya pada link yang sedang aktif
  for (let i = 0; i < link.length; i++) {
    const currentSpan = link[i].querySelector("span");
    if (currentSpan) currentSpan.classList.remove("hidden"); // Tampilkan span
    link[i].classList.add('bg-pink-800', 'text-orange-50', 'rounded-full'); // Tambahkan kelas aktif
    link[i].classList.remove("text-pink-800", )
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
