<div id="cover" class="z-50 bg-white flex inset-0 justify-center items-center min-w-screen min-h-screen fixed ">
    <!-- Background Image -->
    <img src="{{ asset('storage/'. $thumbnailWa->thumbnail) }}"
        class="absolute w-full md:w-1/3 h-full object-cover object-center z-0" alt="" />
    <div class="absolute inset-0 bg-black opacity-75 mx-auto w-full md:w-1/3"></div>
    <!-- Content Container -->
    <div class="relative z-10 w-full sm:w-1/3 flex flex-col justify-center items-center space-y-8 text-center">
        <!-- Title Section -->
        <div class="text-white font-italiana">
            <p class="text-sm uppercase tracking-wide font-semibold">Happy Wedding</p>
            <h1 class="text-3xl font-bold">
                {{ $data->wanita->nama_panggilan }} &
                {{ $data->pria->nama_panggilan }}
            </h1>
        </div>

        <!-- Image Section -->
        <div class="p-2 bg-white shadow-md rounded-lg">
            <img src="{{ asset('storage/'. $thumbnailWa->thumbnail) }}"
                class="w-[175px] h-[300px] object-cover rounded-lg" alt="Wedding Illustration" />
        </div>

        <!-- Invitation Section -->
        <div class="p-4 text-center text-white ">
            <p class="text-sm">Kepada</p>
            <h2 class="text-lg font-bold font-italiana">{{$tamu}}</h2>
            <p class="text-sm mt-2 font-reemkufi">Tanpa Mengurangi Rasa Hormat, Kami Mengundang Bapak/Ibu/Saudara/i
                untuk
                Hadir di
                Acara Kami.</p>
        </div>
        <button type="button" id="openCover"
            class="w-[150px] py-2 px-4 bg-gradient-to-r from-black to-gray-500 text-white rounded-lg shadow-md hover:from-slate-800 hover:to-gray-600 hover:shadow-lg font-semibold text-xs ring-1 ring-white ">
            <i class="fa-regular fa-paper-plane mr-1"></i>Buka Sampul
        </button>
    </div>
</div>
