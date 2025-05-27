document.addEventListener("DOMContentLoaded", function () {
var swiper = new Swiper(".mySwiper", {
  spaceBetween: 30,
  // slidesPerView: 3,
  centeredSlides: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  autoplay: {
    delay: 2000,
    disableOnInteraction: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});
});




  // var swiper_2 = new Swiper(".swiperStory", {
  //   slidesPerView: 3,
  //   spaceBetween: 20,
  //   centeredSlides: true,
  //   pagination: {
  //     el: ".swiper-pagination",
  //     clickable: true,
  //   },
  // });