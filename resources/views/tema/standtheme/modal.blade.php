<div id="modal" class="fixed inset-0 bg-black  bg-opacity-50 flex justify-center items-center z-[999]">
    <div class="bg-[#755f4B]  w-full h-full  shadow-lg overflow-auto relative">
        <div class=" w-full text-white p-4 ">
            <p class="text-center text-lg md:text-xl mb-2">{{ $data->setting->acara }}</p>
            <p class="text-center text-5xl mb-4 title">{{ $data->pria->nama_panggilan }} &amp;
                {{ $data->wanita->nama_panggilan }}</p>
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $data->thumbnailWas->thumbnail) }}" alt=""
                    class="rounded-lg w-[50%] md:w-[300px] object-cover">
            </div>
            <div class="bg-white p-4 rounded-lg shadow-md text-black max-w-md mx-auto">
                <div class="text-center my-0 py-0">
                    <h4 class="header-text">Kepada:</h4>
                    <p class="main-text">Yth. Bapak/Ibu/Saudara/i</p>
                    <p class="main-text text-[20px]">{{ $tamu }}</p>
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

    </div>
</div>
