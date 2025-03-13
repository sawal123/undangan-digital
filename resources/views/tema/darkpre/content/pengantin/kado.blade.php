<button onclick="toggleModal()" type="button"
    class="fixed lg:absolute rounded-full w-14 h-14 top-28 right-2 lg:right-5 bg-teal-400 z-50 flex items-center justify-center text-2xl shadow-lg hover:bg-teal-500 transition duration-300">
    <i class="fa-solid fa-wallet text-white"></i>
</button>

<!-- Modal kado -->
<div id="infoModal"
    class="invisible fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50 font-poppins ">
    <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full text-center">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Kado</h2>
        <p class="text-gray-600 mb-4">Berikut adalah informasi untuk mengirimkan kado atau hadiah secara
            online atau
            melalui pengiriman fisik:</p>
        @foreach ($data->kado as $index => $kado)
            <ul class="text-left text-gray-700 mb-6 flex flex-col items-center text-sm relative ">
                <li class="mb-2 text-center"><img src="{{ asset('storage/' . $kado->giftPay->icon) }}" alt=""
                    class="w-32"></li>
                    <li class="mb-2"><strong>{{ $kado->namaPay }}</strong></li>
                <li class="nomor-rekening">{{ $kado->nomorPay }}</li>
                <li class="my-2">
                    <button onclick="salinTeks(this)" style="border: 1px solid #313131;"
                        class=" sm:px-3 py-1 text-slate-800 text-sm sm:text-xs rounded-lg bg-blue-500 p-2">
                        Copy
                    </button>
                </li>
            </ul>
            <hr class="" style="margin-bottom: 5px">
            @if ($kado->qris)
                <ul class="text-left text-gray-700 mb-6 flex flex-col items-center  text-sm relative ">
                    <li class="mb-2"><strong>Kasih Hadiah Pakai QRIS</strong></li>
                    <li class="mb-2 text-center"><img src="{{ asset('storage/' . $kado->qris) }}" alt=""
                            class="w-32"></li>

                </ul>
            @endif
        @endforeach
        <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300"
            onclick="toggleModal()">Tutup</button>
    </div>

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
