<div class="w-full bg-neutral-950 text-orange-200 font-poppins section overflow-x-hidden">
    @if ($data->kisah->isNotEmpty())
        <h2 class="text-center text-[50px] font-corinthia z-50  font-light mb-6 py-8 ">Story</h2>
    @endif
    <div class="swiper_2 swiperStory mt-8 ">
        <div class="swiper-wrapper gap-3 font-semibold ">
            @foreach ($data->kisah as $item)
                <div class="swiper-slide flex flex-col  text-sm space-y-5"><img
                        src="{{ asset('storage/' . $item->image->image) }}"" alt=""
                        class="object-cover object-center aspect-square  w-[300px] shadow-md cursor-pointer rounded-full"
                        onclick="openModalImg(this)">
                    <div class="font-semibold text-[15px]">{{ $item->title }} <br> <span
                            class="font-normal text-[12px]"> {{ $item->deskripsi }}</span> </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
