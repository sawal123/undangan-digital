(function () {
    const heroSlider = document.querySelector('.mySwiper');
    if (!heroSlider || typeof Swiper === 'undefined') return;

    const slides = heroSlider.querySelectorAll('.swiper-slide').length;
    if (slides <= 1) return;

    new Swiper(heroSlider, {
        effect: 'fade',
        fadeEffect: { crossFade: true },
        allowTouchMove: false,
        rewind: true,
        speed: 1000,
        autoplay: {
            delay: 4200,
            disableOnInteraction: false,
        },
    });
})();
