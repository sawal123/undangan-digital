 // Ensure smooth modal toggle behavior
 function toggleModal() {
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
    modalImage.src = ''; // Reset sumber gambar untuk menghindari caching
  }