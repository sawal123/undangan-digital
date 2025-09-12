<div class="container relative z-30 px-0 mx-auto w-full bg-white pt-10">
    <div class="w-full h-full ">
        <div id="pengantin">
            @include('tema.darksweet.content.pengantin.pengantin')
        </div>

        <!-- Date pick -->
        <div id="hitunghari">
            @include('tema.darksweet.content.pengantin.hitunganhari')
        </div>
        <!-- Date pick -->

        <!-- Save Date Acara -->
        <div id="savethedate">
            @include('tema.darksweet.content.pengantin.acara')
        </div>
        <!-- Save Date Acara -->

        <!-- Pertemuan -->
        <div id="story">
            @include('tema.darksweet.content.pengantin.kisah')
        </div>
        <!-- Pertemuan -->

        <!-- Gallery -->
        @include('tema.darksweet.content.pengantin.gallery')

        <!-- Gallery -->

        <!--  GIFT  -->
        <div class="w-full flex flex-col justify-center items-center pt-5 bg-zinc-800 px-3" id="hadiah">

            @if ($data->kado->isNotEmpty())
                <h1 class="text-white text-center text-3xl font-bold " data-aos="fade-up" data-aos-duration="3000">Titip
                    Hadiah
                </h1>
            @endif


            <!-- CARD -->
            <div class="w-full flex flex-col justify-center items-center mt-5 px-2 gap-3">

                <!-- CARD 1 -->
                @foreach ($data->kado as $index => $kado)
                    <div class="w-full h-44 sm:h-52 md:h-56 bg-gray-50 shadow-lg rounded-2xl relative overflow-hidden bg-local bg-cover bg-center"
                        data-aos="fade-up" data-aos-duration="3000"
                        style="background-image: url('{{ asset('tema/darksweet/img/logo/abstrak.jpg') }}');">

                        <!-- Logo -->
                        <div class="absolute top-4 right-4 flex items-center h-8 w-20">
                            <div class="relative w-full aspect-w-16 aspect-h-9">
                                <img src="{{ asset('storage/' . $kado->giftPay->icon) }}" style="height: 50px"
                                    alt="" class="absolute inset-0 object-cover object-center">
                            </div>
                        </div>

                        <!-- Chip -->
                        <div class="absolute top-10 sm:top-16 left-4 sm:left-3 w-12 sm:w-10">
                            <img src="{{ asset('tema/darksweet/img/logo/pin.png') }}" class="w-full h-full"
                                alt="Chip">
                        </div>

                        <!-- Card Details -->
                        <div class="absolute bottom-6 sm:bottom-10 left-4 sm:left-3 text-gray-800 tracking-wider">
                            <div class="text-xl font-bold tracking-wide text-ellipsis nomor-rekening">
                                {{ $kado->nomorPay }}
                            </div>
                            <div class="text-lg font-semibold text-gray-600">{{ $kado->namaPay }}</div>
                        </div>

                        <!-- Copy Button -->
                        <div class="absolute bottom-8 sm:bottom-6 right-4 sm:right-3">
                            <button onclick="salinTeks(this)"
                                class="px-4 sm:px-3 py-1 bg-gray-300 text-gray-700 text-sm sm:text-xs rounded-lg hover:bg-gray-400">
                                Copy
                            </button>
                        </div>
                    </div>
                    @if ($kado->qris)
                        <!-- Bank Details -->
                        <div class="flex flex-col items-center" data-aos="fade-up" data-aos-duration="1000">
                            <p class="font-semibold text-lg text-gray-800">Kasih Hadiah Pakai QRIS</p>
                            <div class="mb-3 text-center">
                                <img src="{{ asset('storage/' . $kado->qris) }}"
                                    class="w-3/4 sm:w-1/2 max-w-xs rounded-lg shadow-md object-cover" alt="QRIS" />
                            </div>
                        </div>
                    @endif
                @endforeach

                <script>
                    function salinTeks(button) {
                        // Ambil elemen teks dalam kartu yang sesuai dengan tombol yang diklik
                        const nomorRekening = button.closest('.relative').querySelector('.nomor-rekening').textContent;

                        // Salin teks ke clipboard
                        navigator.clipboard.writeText(nomorRekening).then(() => {
                            alert('Nomor rekening berhasil disalin: ' + nomorRekening);
                        }).catch(err => {
                            alert('Gagal menyalin teks: ' + err);
                        });
                    }
                </script>



            </div>
            <!-- CARD -->
        </div>
        <!-- GIFT -->


        <div id="absen">
            @include('tema.darksweet.content.pengantin.ucapan')
        </div>

        <div class="w-full h-[750px] flex flex-col justify-center items-center bg-cover bg-center bg-local relative"
            id="bottom" style="background-image: url('{{ asset('storage/' . $thumbnailWa->thumbnail) }}');">
            <div class="absolute bg-black opacity-50 inset-0 w-full h-full z-0"></div>
            <div class="flex flex-col justify-center items-center p-2 bg-white shadow-md z-10">
                <div class="aspect-[5/7] w-44 h-auto">
                    <img src="{{ asset('storage/' . $thumbnailWa->thumbnail) }}" alt=""
                        class="object-cover w-full h-full">
                </div>
            </div>
            <div class="w-full mx-auto mt-5 z-10">
                <h1 class="text-white text-center text-3xl font-bold " data-aos="fade-down" data-aos-duration="3000">
                    {{ $data->wanita->nama_panggilan }} &
                    {{ $data->pria->nama_panggilan }}
                </h1>
            </div>
            <div class="w-full mx-auto mt-5 z-10">
                <p class="text-white text-center text-lg font-semibold " data-aos="fade-up" data-aos-duration="3000">
                    Terima
                    Kasih</p>
            </div>
            <div class="absolute w-full bottom-0 h-48 bg-gradient-to-t from-black to-transparent"></div>
        </div>
        <div class="w-full h-[500px] bg-black"></div>
    </div>
</div>
