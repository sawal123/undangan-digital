<div class="reveal mt-10 mb-10">
    @if ($video)
        <div class="relative w-auto h-96 mx-4" data-aos="fade-up" data-aos-duration="1500">
            <div class="col-12" style="height: 250px;">
                <iframe src="{{ $video[0] }}" class="absolute top-0 left-0 w-full h-full" frameborder="0"></iframe>
            </div>
        </div>
    @endif
</div>

<div class="bg-stone-500 rounded-lg flex flex-col items-center my-2 justify-center mx-6 relative w-auto py-5 mt-6">
    <p class="text-center text-white" data-aos="fade-up" data-aos-duration="1500">
        Tanpa mengurangi rasa hormat, bagi yang berkenan memberikan tanda kasih, dapat disampaikan melalui rekening/emoney berikut:
    </p>
    <hr class="my-4" />
    
    @foreach ($data->kado as $kado)
    <div class="max-w-sm mx-auto mt-3 bg-white shadow-lg rounded-xl overflow-hidden transform transition duration-500 hover:scale-105" data-aos="fade-up" data-aos-duration="1800">
        <div class="p-6">
            <!-- Nama Pembayaran -->
            <div class="text-center">
                <h3 class="text-2xl font-semibold text-[#755f4B]">{{ $kado->giftPay->nama_pay }}</h3>
                <p class="mt-2 text-lg font-medium text-gray-700">{{ $kado->namaPay }}</p>
            </div>

            <!-- Nomor Rekening -->
            <div class="mt-4 text-center">
                <p class="text-lg text-gray-600">
                    <span class="font-bold text-md">No.Rek/Emoney :</span><br>
                    <span id="nomorRek" class="font-bold text-xl text-blue-600">{{ $kado->nomorPay }}</span>
                </p>
            </div>

            <!-- Tombol Salin -->
            <div class="flex justify-center mt-6">
                <button id="copyButton" onclick="copyToClipboard()" class="p-3 py-2 bg-[#755f4B] text-white rounded-lg hover:bg-[#382a1d] focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Salin Nomor Rekening
                </button>
            </div>
        </div>
    </div>
@endforeach

</div>

<script>
    function copyToClipboard() {
    // Ambil elemen nomor rekening
    const nomorRek = document.getElementById('nomorRek').innerText;

    // Buat textarea sementara untuk menyalin teks
    const textArea = document.createElement('textarea');
    textArea.value = nomorRek;
    document.body.appendChild(textArea);

    // Pilih dan salin teks
    textArea.select();
    document.execCommand('copy');
    
    // Hapus textarea sementara
    document.body.removeChild(textArea);

    // Tampilkan alert atau perubahan status setelah berhasil menyalin
    alert('Nomor rekening berhasil disalin!');
}

</script>

<!-- Daftar Nama -->
<!-- Judul Turut Mengundang -->
@if ($data->teksPenutup->mengundang)
    <div class="mt-8">
        <h3 class="text-center text-xl mb-5 text-[#755f4B]" data-aos="fade-up" data-aos-duration="1500">Turut Mengundang
        </h3>
        <div class="text-center flex flex-col items-center text-sm md:text-lg space-y-2 text-[#755f4B]"
            data-aos="fade-up" data-aos-duration="1500">
            <p>
                {!! nl2br(e($data->teksPenutup->mengundang)) !!}
            </p>
        </div>
    </div>
@endif
