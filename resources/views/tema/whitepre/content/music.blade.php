<!-- Toggle Button -->
<button id="musicToggle" type="button"
    class=" fixed lg:absolute rounded-full w-10 h-10 top-10 right-2 bg-slate-400 z-50 flex items-center justify-center text-xl shadow-lg hover:bg-slate-600 transition duration-300">
    <span id="audio-status" class="text-white">
        <i class="fa-solid fa-play"></i>
    </span>
</button>

@include('tema.partials.music', ['data' => $data])
