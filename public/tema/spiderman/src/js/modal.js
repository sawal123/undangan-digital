 // modal QR
 function toggleModalQr() {
    const modal = document.getElementById('infoModal');
    modal.classList.toggle('invisible');
}


function openModalImg(img) {
    const modalImg = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImageContent');
    modalImage.src = img.src; // Set sumber gambar modal ke sumber gambar yang di-klik
    modalImg.classList.remove('hidden'); // Tampilkan modal
  }

  function closeModalImg() {
    const modalImg = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImageContent');
    modalImg.classList.add('hidden'); // Sembunyikan modal
    modalImage.src = ''; 
  }


// RSPV
  function toggleModalRspv() {
    const modal = document.getElementById('ModalRspv');
    if (!modal) {
      return;
    }

    modal.classList.toggle('invisible');
}

document.addEventListener('DOMContentLoaded', function () {
  const wishForm = document.getElementById('spidermanWishForm');

  if (!wishForm) {
    return;
  }

  wishForm.addEventListener('submit', function () {
    const button = wishForm.querySelector('button[type="submit"]');
    const submitLabel = wishForm.querySelector('.submit-label');
    const loadingLabel = wishForm.querySelector('.loading-label');

    if (!button) {
      return;
    }

    button.disabled = true;
    submitLabel?.classList.add('hidden');
    loadingLabel?.classList.remove('hidden');
  });
});



// // kado
// function toggleSection(sectionId) {
//   // Sembunyikan semua bagian

//   document.getElementById('kirimKado').classList.add('hidden');
  
//   // Tampilkan bagian yang dipilih
//   document.getElementById(sectionId).classList.remove('hidden');
// }
