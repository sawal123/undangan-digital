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
    modal.classList.toggle('invisible');
}



// // kado
// function toggleSection(sectionId) {
//   // Sembunyikan semua bagian

//   document.getElementById('kirimKado').classList.add('hidden');
  
//   // Tampilkan bagian yang dipilih
//   document.getElementById(sectionId).classList.remove('hidden');
// }
