(function () {
    const heroSlider = document.querySelector('.mySwiper');
    if (!heroSlider || typeof Swiper === 'undefined') return;

    const slides = heroSlider.querySelectorAll('.swiper-slide').length;
    new Swiper(heroSlider, {
        effect: 'fade',
        fadeEffect: { crossFade: true },
        allowTouchMove: false,
        loop: slides > 1,
        autoplay: slides > 1 ? { delay: 4200, disableOnInteraction: false } : false,
    });
})();
