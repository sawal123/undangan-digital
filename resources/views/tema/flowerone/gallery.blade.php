<div style="--swiper-navigation-color: #fff; --swiper-pagination-color: #fff" class="swiper mySwiper2 p-1">
    <!-- Thumbnail Swiper -->
    <div thumbsSlider="" class="swiper mySwiper" data-aos="fade-up" data-aos-duration="1000">
        <div class="swiper-wrapper">
            @foreach ($poto as $po)
                <div class="swiper-slide">
                    <img src="{{ asset('storage/' . $po) }}" class="object-fit-cover" />
                </div>
            @endforeach
        </div>
        <!-- Navigation Buttons -->
        <div class="swiper-button-next p-2 rounded-circle"></div>
        <div class="swiper-button-prev p-2 rounded-circle"></div>
    </div>
    <!-- Main Image Swiper -->
    <div class="swiper-wrapper" style="height: 300px;" data-aos="fade-up" data-aos-duration="1000">
        @foreach ($poto as $po)
            <div class="swiper-slide">
                <img src="{{ asset('storage/' . $po) }}" class="object-fit-cover" />
            </div>
        @endforeach

    </div>
</div>
