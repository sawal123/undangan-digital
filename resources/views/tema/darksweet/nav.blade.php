<nav
    class="fixed bottom-2 mb-1 md:mb-3 z-30 w-full md:w-2/4 lg:w-1/3 mx-auto max-h-[40px] flex justify-center inset-x-0">
    <div
        class="py-2 px-4 w-full h-full flex justify-evenly mx-6 space-x-6 items-center rounded-full bg-white shadow-2xl ring-1 ring-black backdrop-blur-lg bg-opacity-50">
        <!-- Icon 1 -->
        <a href="#home"
            class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200 scroll-smooth text-opacity-100">
            <i class="fa-solid fa-house text-lg md:text-2xl "></i>
        </a>
        <!-- Icon 2 -->
        <a href="#pengantin" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
            <i class="fa-solid fa-user-group text-lg md:text-2xl"></i>
        </a>
        <a href="#hitunghari" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
            <i class="fa-solid fa-calendar text-lg md:text-2xl"></i>
        </a>
        <a href="#savethedate" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
            <i class="fa-solid fa-calendar-check text-lg md:text-2xl"></i>
        </a>
        <a href="#story" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
            <i class="fa-solid fa-history text-lg md:text-2xl"></i>
        </a>
        <a href="#gallery" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
            <i class="fa-solid fa-images text-lg md:text-2xl"></i>
        </a>
        <a href="#hadiah" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
            <i class="fa-solid fa-gift text-lg md:text-2xl"></i>
        </a>
        <a href="#absen" class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
            <i class="fa-solid fa-comment text-lg md:text-2xl"></i>
        </a>

        
        <button type="button" id="toggleButton"
            class="flex items-center text-gray-600 hover:text-sky-600 transition duration-200">
            <i class="fa-solid fa-music text-lg md:text-2xl"></i>
        </button>

    </div>
</nav>

<!-- Youtube -->
<div class="hidden fixed z-0 bottom-0">
    <iframe id="videoFrame" width="0" height="0" src="@if($data->sound->isActive ){{ $data->sound->sound }}?start={{ $data->sound->start }}@endif&enablejsapi=1"
        frameborder="0" allow="autoplay; encrypted-media" allowfullscreen>
    </iframe>
</div>
