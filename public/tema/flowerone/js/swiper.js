
var swiperThumbs = new Swiper('.mySwiper', {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
    centeredSlides: true,
});

var swiperMain = new Swiper('.mySwiper2', {
    loop: true,
    spaceBetween: 10,
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    autoplay: {
        delay: 2000,
        disableOnInteraction: false,
      },
    thumbs: {
        swiper: swiperThumbs
    },
    centeredSlides: true,
});
