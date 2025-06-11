<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-990">
    <div class="bg-white rounded-lg w-full sm:w-11/12 md:w-3/4 lg:w-2/3 xl:w-1/2 p-3 shadow-lg relative max-h-screen overflow-auto">
        <div class="bg-[#755f4B] w-full text-white">
            <h4 class="text-base md:text-lg title text-center pt-2">Undangan</h4>
            <p class="text-center text-lg md:text-1xl mb-4">{{ $data->setting->acara ?? 'The Wedding' }}</p>
            <p class="text-center text-5xl mb-4 title">{{ $data->pria->nama_panggilan }} &amp; {{ $data->wanita->nama_panggilan }}</p>
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $data->thumbnailWas->thumbnail) }}" alt="" class="w-[80%] md:w-[466px] h-auto object-cover">
            </div>
        </div>
        <div class="text-center my-0 py-0">
            <h4 class="header-text">Kepada:</h4>
            <p class="main-text">Yth. Bapak/Ibu/Saudara/i</p>
            <p class="main-text" style="font-size: 20px !important;">{{ $tamu }}</p>
        </div>
        <div class="flex justify-center mb-4">
            <p class="text-[11px] italic">*Mohon maaf bila ada kesalahan penulisan nama dan gelar</p>
        </div>
        <div class="flex justify-center">
            <button id="closeModal" class="px-4 py-2 bg-[#755f4B] text-white rounded-lg hover:bg-gray-500">
                Buka Undangan
            </button>
        </div>
    </div>
</div>
