<!-- Toggle Button -->
<button id="musicToggle" type="button"
    aria-label="Putar atau jeda musik"
    class="whitepre-float-control whitepre-float-control--music fixed lg:absolute rounded-full w-10 h-10 top-10 right-2 z-50 flex items-center justify-center text-xl transition duration-300">
    <span id="audio-status" class="text-white">
        <i class="fa-solid fa-play"></i>
    </span>
</button>

@include('tema.partials.music', ['data' => $data])
