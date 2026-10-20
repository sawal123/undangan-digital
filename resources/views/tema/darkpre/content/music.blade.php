<!-- Toggle Button -->
<button id="musicToggle" type="button" aria-label="Putar atau jeda musik"
    class="darkpre-float-control darkpre-float-control--music fixed lg:absolute top-10 right-2 z-50 flex h-10 w-10 items-center justify-center rounded-full text-xl lg:right-5">
    <span id="audio-status" class="text-white">
        <i class="fa-solid fa-play"></i>
    </span>
</button>

@include('tema.partials.music', ['data' => $data])
