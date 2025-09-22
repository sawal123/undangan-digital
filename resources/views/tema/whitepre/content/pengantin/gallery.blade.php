@if ($poto)
    <div class=" w-full bg-orange-50 text-pink-800 font-poppins section pt-10">
        <div
            style="background-image: url('{{ asset('tema/whitepre/src/img/bunga_galery.png') }}'); background-size: cover; background-position: center;">
            <h1 class="text-center text-[50px]  z-50  font-semibold ">Moment yang berharga</h1>
            <div class="text-center text-sm mb-10">"Menciptakan kenangan adalah hadiah yang tak ternilai harganya.
                Kenangan akan bertahan seumur hidup; benda-benda hanya dalam waktu singkat."</div>
        </div>
        <div class="flex flex-row w-full gap-4">
            <!-- Kolom 1 -->
            <div class="flex flex-col basis-1/2 gap-4">
                @foreach ($poto as $index => $item)
                    @if ($index % 2 === 0)
                        <!-- Elemen dengan indeks genap -->
                        <div class="w-full">
                            <img src="{{ asset('storage/' . $item) }}" alt="Thumbnail" onclick="openModalImg(this)"
                                class="object-cover object-center w-full shadow-md cursor-pointer">
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Kolom 2 -->
            <div class="flex flex-col basis-1/2 gap-4">
                @foreach ($poto as $index => $item)
                    @if ($index % 2 !== 0)
                        <!-- Elemen dengan indeks ganjil -->
                        <div class="w-full">
                            <img src="{{ asset('storage/' . $item) }}" alt="Thumbnail" onclick="openModalImg(this)"
                                class="object-cover object-center w-full shadow-md cursor-pointer">
                        </div>
                    @endif
                @endforeach
            </div>
        </div>



    </div>

@endif
