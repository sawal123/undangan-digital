function showSection(sectionId, clickedButton = null) {
  // Sembunyikan semua elemen dengan kelas .min-h-screen
  const sections = document.querySelectorAll('.min-h-screen');
  sections.forEach((section) => {
    section.classList.add('hidden', 'transition-all', 'duration-2000' ); // Sembunyikan elemen
  });

  // Tampilkan elemen yang dipilih berdasarkan ID
  const activeSection = document.getElementById(sectionId);
  if (activeSection) {
    activeSection.classList.remove('hidden', 'transition-all', 'duration-2000' ); // Tampilkan elemen
  }

  // Reset tombol aktif
  const buttons = document.querySelectorAll('.nav-link');
  buttons.forEach((button) => {
    button.classList.remove('bg-red-700', 'text-white'); // Hapus gaya aktif
  });

  // Tambahkan gaya aktif ke tombol yang diklik (jika ada)
  if (clickedButton) {
    clickedButton.classList.add('bg-red-700', 'text-white');
  }

  // Sembunyikan semua span text di navbar
  const spans = document.querySelectorAll('.nav-link span');
  spans.forEach((span) => {
    span.classList.add('hidden');
  });

  // Tampilkan teks span pada tombol yang diklik
  if (clickedButton) {
    const span = clickedButton.querySelector('span');
    if (span) {
      span.classList.remove('hidden');
    }
  }


    // Refresh AOS untuk memastikan animasi berjalan
  AOS.refresh();
}

// Inisialisasi AOS saat halaman dimuat
AOS.init();

// Menampilkan bagian pertama secara default
 document.addEventListener('DOMContentLoaded', () => {
  const openCoverButton = document.getElementById('open-cover');
  const openingSection = document.querySelector('.nav-link.opening');

  openCoverButton.addEventListener('click', () => {
    if (openingSection) {
      showSection('opening', openingSection);
    }
  });
});

// function showSection(sectionId, clickedButton = null) {
//   // Sembunyikan semua elemen dengan kelas .min-h-screen
//   const sections = document.querySelectorAll('.min-h-screen');
//   sections.forEach((section) => {
//     section.classList.add('opacity-0', 'absolute', );
//     section.classList.remove('opacity-100', 'relative');
//   });

//   // Tampilkan elemen yang dipilih berdasarkan ID
//   const activeSection = document.getElementById(sectionId);
//   if (activeSection) {
//     activeSection.classList.remove('opacity-0', 'absolute');
//     activeSection.classList.add('opacity-100', 'relative');
//   }

//   // Reset tombol aktif
//   const buttons = document.querySelectorAll('.nav-link');
//   buttons.forEach((button) => {
//     button.classList.remove('bg-red-700', 'text-white'); // Hapus gaya aktif
//   });

//   // Tambahkan gaya aktif ke tombol yang diklik (jika ada)
//   if (clickedButton) {
//     clickedButton.classList.add('bg-red-700', 'text-white');
//   }

//   // Sembunyikan semua span text di navbar
//   const spans = document.querySelectorAll('.nav-link span');
//   spans.forEach((span) => {
//     span.classList.add('hidden');
//   });

//   // Tampilkan teks span pada tombol yang diklik
//   if (clickedButton) {
//     const span = clickedButton.querySelector('span');
//     if (span) {
//       span.classList.remove('hidden');
//     }
//   }

//   // Refresh AOS untuk memastikan animasi berjalan
//   AOS.refresh();
// }

// // Inisialisasi AOS saat halaman dimuat
// AOS.init();

// // Menampilkan bagian pertama secara default
// // document.addEventListener('DOMContentLoaded', () => {
// //   const firstButton = document.querySelector('.nav-link.opening');
// //   if (firstButton) {
// //     showSection('opening', firstButton);
// //   }
// // });

//  document.addEventListener('DOMContentLoaded', () => {
//   const openCoverButton = document.getElementById('open-cover');
//   const openingSection = document.querySelector('.nav-link.opening');

//   openCoverButton.addEventListener('click', () => {
//     if (openingSection) {
//       showSection('opening', openingSection);
//     }
//   });
// });

