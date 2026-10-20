const gallerySlider = document.querySelector('.mySwiper');

if (gallerySlider) {
    new Swiper(gallerySlider, {
        effect: 'fade',
        loop: true,
        autoplay: {
            delay: 3200,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.mySwiper .swiper-pagination',
            clickable: true,
        },
    });
}

const storySlider = document.querySelector('.swiperStory');

if (storySlider) {
    new Swiper(storySlider, {
        slidesPerView: 1,
        spaceBetween: 16,
        centeredSlides: false,
        watchOverflow: true,
        pagination: {
            el: '.swiperStory .swiper-pagination',
            clickable: true,
        },
    });
}
