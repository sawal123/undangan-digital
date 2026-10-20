
document.addEventListener('DOMContentLoaded', () => {
    const mainElement = document.querySelector('.mySwiper2');
    const thumbsElement = document.querySelector('.mySwiper');
    if (!mainElement || !thumbsElement || typeof Swiper === 'undefined') return;

    const swiperThumbs = new Swiper(thumbsElement, {
        spaceBetween: 10,
        slidesPerView: 3,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: { 576: { slidesPerView: 4 } },
    });

    new Swiper(mainElement, {
        loop: true,
        spaceBetween: 10,
        navigation: {
            nextEl: mainElement.querySelector('.swiper-button-next'),
            prevEl: mainElement.querySelector('.swiper-button-prev'),
        },
        autoplay: { delay: 3500, disableOnInteraction: false },
        thumbs: { swiper: swiperThumbs },
    });
});
