<div class="relative min-h-screen hidden" id="gift">
    <!-- Top Section -->
    @include('tema.ultah.top-section')
    <!-- End Top Section -->

    <!-- konten gallery -->
    <div class="w-full flex flex-col items-center justify-center  uppercase z-50">

        <div class="text-center pt-12" data-aos="fade-down" data-aos-duration="2500" data-aos-easing="ease-in-sine">
            <h3 class="leading-none text-[30px] font-extrabold pb-10 font-audiowide">Tanda Kasih</h3>
            <p class="text-[12px] mx-6">Terima kasih telah menambah semangat <br> kegembiraan ulang tahun anak kami
                dengan <br> kehadiran dan hadiah indah Anda</p>
        </div>

        <div class="flex flex-row justify-center items-center pt-4 gap-12" data-aos="fade-up" data-aos-duration="2000"
            data-aos-easing="ease-in-sine">
            <button
                class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px] cashless-btn"
                onclick="toggleModal('cashless-modal')">
                <i class="fa-solid fa-map-location-dot mr-2"></i>Cashless
            </button>
            <button
                class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px] kado-btn"
                onclick="toggleSection('kirimKado')">
                <i class="fa-solid fa-map-location-dot mr-2"></i>Kirim Kado
            </button>
        </div>

        <!-- cashless -->
        <!-- Modal -->
        <div id="cashless-modal"
            class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-[90%] max-w-lg overflow-auto">
                <div class="p-4 flex justify-between items-center border-b">
                    <h2 class="text-lg font-bold text-black">Metode Cashless</h2>
                    <button class="text-gray-500 hover:text-black font-semibold"
                        onclick="toggleModal('cashless-modal')">
                        ✖
                    </button>
                </div>
                <div class="p-4 text-black">
                    <!-- Konten Modal -->
                    @foreach ($data->kado as $index => $kado)
                        <div class="flex flex-row gap-2 items-center mb-4">
                            <div class="px-2 py-1 w-[80px] h-[58px] bg-gray-100 rounded-lg flex items-center">
                                <img src="{{ asset('storage/' . $kado->giftPay->icon) }}" alt="pembayaran"
                                    class="w-full h-full object-center object-contain">
                            </div>
                            <div class="flex flex-col justify-center items-start text-gray-900 text-start">
                                <p class="font-extrabold text-[20px]">{{ $kado->nomorPay }}</p>
                                <button
                                    class="rounded-lg font-semibold w-auto border bg-[#FFC300] py-1 px-2 text-black text-[13px]"
                                    onclick="salinTeks(this)" type="button">
                                    Salin Rekening
                                </button>
                                <p class="font-extrabold text-[15px]">{{ $kado->namaPay }}</p>
                            </div>
                        </div>
                        @if ($kado->qris)
                            <div class="text-left text-gray-700 mb-6 flex flex-col items-center text-sm">
                                <strong>Kasih Hadiah Pakai QRIS</strong>
                                <img src="{{ asset('storage/' . $kado->qris) }}" alt="QRIS" class="w-32 mt-2">
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="p-4 border-t text-right">
                    <button class="rounded-lg bg-gray-300 hover:bg-gray-400 px-4 py-2 text-black font-semibold"
                        onclick="toggleModal('cashless-modal')">
                        Tutup
                    </button>
                </div>
            </div>
        </div>

        <!-- kirim kado -->
        <div class="flex flex-col justify-center items-center pt-5 z-50 hidden" id="kirimKado" data-aos="zoom-in"
            data-aos-duration="2500" data-aos-easing="ease-in-sine">
            <div class="flex flex-col justify-center items-center text-white">
                <p class="font-extrabold text-[20px] text-[#FFC300]">Kirim Kado</p>
                <p class="font-extrabold text-[15px] text-center">
                    Anda dapat mengirim kado ke: <br>
                    Jl Wildan Sari No 11 Banjarmasin Barat 703222
                </p>
            </div>
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

          // Fungsi untuk membuka/menutup modal
function toggleModal(modalId) {
    const modal = document.getElementById(modalId);
    const kirimKado = document.getElementById('kirimKado');

    // Jika modal sedang tersembunyi, tampilkan modal dan sembunyikan kirimKado
    if (modal.classList.contains('hidden')) {
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Sembunyikan kirimKado
        if (kirimKado) {
            kirimKado.classList.add('hidden');
        }
    } else {
        // Jika modal sedang tampil, sembunyikan modal
        modal.classList.add('hidden');
        modal.classList.remove('flex');

        // Tampilkan kembali kirimKado (opsional, jika perlu)
        if (kirimKado) {
            kirimKado.classList.remove('hidden');
        }
    }
}

// Fungsi untuk menampilkan bagian tertentu
function toggleSection(sectionId) {
    // Sembunyikan semua bagian lain
    document.getElementById('kirimKado').classList.add('hidden');

    // Tampilkan bagian yang dipilih
    const section = document.getElementById(sectionId);
    if (section) {
        section.classList.remove('hidden');
    }
}


        </script>

    </div>

    <!-- Bottom Section -->
    @include('tema.ultah.bottom-section')
    <!-- End Bottom Section -->
</div>
