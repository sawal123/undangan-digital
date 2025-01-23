// MOdal qr
const openModal = document.getElementById('openModalQr');
 const closeModal = document.getElementById('closeModal');
 const modal = document.getElementById('modal');

 openModal.addEventListener('click', () => {
   modal.classList.remove('invisible');
 });

 closeModal.addEventListener('click', () => {
   modal.classList.add('invisible'); 
 });

 modal.addEventListener('click', (event) => {
   if (event.target === modal) {
     modal.classList.add('invisible');
   }
 });



//  image Modal
function openModalImg(img){
  const modalImg = document.getElementById('imageModal');
  const modalImage = document.getElementById('modalImage');
    modalImage.src = img.src;
    modalImg.classList.remove('invisible'); 
   
  }   
  
  
    function closeModalImg() {
      const modalImg = document.getElementById('imageModal');
      modalImg.classList.add('invisible'); 
     
    }
