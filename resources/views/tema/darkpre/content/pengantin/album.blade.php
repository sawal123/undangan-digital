<div id="gallery"></div>
<div class=" w-full bg-neutral-950 text-orange-200 font-poppins section" >
    <h2 class="text-center text-[50px] font-corinthia z-50  font-light mb-6 py-8">Gallery Kami</h2>
    <div class="text-center text-sm mb-10">"Pernikahan seperti mozaik yang kita buat dengan <br> pasangan
        kita,
        jutaan momen kecil yang menjadi kisah <br> cinta."</div>
     

    <div class="swiper mySwiper text-black pt-10 ">
       
        <div class="swiper-wrapper ">
            @foreach ($poto as $item)
            <div class="swiper-slide">
                <img src="{{ asset('storage/' . $item) }}" alt="Thumbnail" onclick="openModalImg(this)"
                  class="object-cover object-center w-full h-full shadow-md cursor-pointer">
              </div>
              @endforeach
        </div>
       
    </div>
 
</div>