const button = document.getElementById('scrollButton');
let scrolling = false; // Status scroll
let animationFrameId = null; // ID animasi untuk membatalkan scroll
const iconActive = ["bg-blue-500", "rounded-lg", "text-white", "hover:text-white"];
const buttonCover = document.getElementById('openCover');
const cover = document.getElementById('cover');
const content = document.getElementById('content');
// openCover
buttonCover.addEventListener('click', () => {
  cover.classList.remove('visible');
  cover.classList.add('invisible');
  content.classList.remove('invisible');
  startScroll();
});

// play / stop scroll
button.addEventListener('click', () => {
  if (scrolling) {
    stopScroll();
  } else {
    startScroll();
  }
});


// play Scroll
function startScroll() {
  scrolling = true;
  button.classList.add(...iconActive);

  const startY = window.scrollY;
  const endY = document.body.scrollHeight - window.innerHeight;
  const duration = 200000; 
  const distance = endY + startY;
  const step = distance / (duration / 16.67); // Jarak per frame (16.67 ms = ~60 FPS)

  const scrollStep = () => {
    if (!scrolling) return; // Berhenti jika scrolling dihentikan

    const currentY = window.scrollY;

    if ((step > 0 && currentY < endY) || (step < 0 && currentY > endY)) {
      window.scrollTo(0, currentY + step); // Geser sesuai step
      animationFrameId = requestAnimationFrame(scrollStep);
    } else {
      //  mencapai posisi akhir dan reset status
      window.scrollTo(0, endY);
      stopScroll();
    }
  };

  animationFrameId = requestAnimationFrame(scrollStep);
}

// Fungsi untuk menghentikan scroll
function stopScroll() {
  cancelAnimationFrame(animationFrameId);
  scrolling = false;
  button.classList.remove(...iconActive);
}

// animasi scroll manual
window.addEventListener('wheel', stopScroll, { passive: true});
window.addEventListener('touchmove', stopScroll, { passive: true });
