const heroSlider = document.querySelector('.mySwiper');

if (heroSlider) {
    new Swiper(heroSlider, {
        spaceBetween: 30,
        effect: 'fade',
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 2000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
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
        breakpoints: {
            768: { slidesPerView: 2, centeredSlides: false },
        },
    });
}
