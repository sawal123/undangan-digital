<style>
    .swiper {
        width: 600px;
        height: 300px;
    }
</style>
@if ($data->kisah->isNotEmpty())
    <div class="w-full bg-orange-50 text-pink-800 font-poppins section overflow-x-hidden"
        style="background-image:url(' {{ asset('tema/whitepre/src/img/pembatas_bunga.png') }}'); background-position: center; background-size: contain; background-repeat: round;">
        <h2 class="text-center text-[50px]  font-great_vibes z-50  font-semibold mb-6 py-8 ">Story</h2>
        <div class="swiper swiperStory mt-8 ">
            <div class="swiper-wrapper gap-2 font-semibold ">
                @foreach ($data->kisah as $item)
                    <div class="swiper-slide flex flex-col text-sm space-y-5  ">
                        <img src="{{ asset('storage/' . $item->image->image) }}" alt=""
                            class="object-cover object-center w-[300px] h-[150px] shadow-md cursor-pointer rounded-full border-2 border-dashed border-pink-800"
                            onclick="openModalImg(this)">
                        <div class="font-semibold text-[15px]">{{ $item->title }} <br> <span
                                class="font-normal text-[12px]"> {{ $item->deskripsi }}</span> </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif


<script>
    var swiper_2 = new Swiper(".swiperStory", {
        slidesPerView: 3,
        spaceBetween: 30,
        centeredSlides: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
    });
</script>
