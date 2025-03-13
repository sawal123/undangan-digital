<div id="youtube-player" class="hidden invisible z-10 absolute inset-0">
    <iframe id="videoFrame" width="240" height="240"
        src="@if ($data->sound->isActive) {{ $data->sound->sound }}?start={{ $data->sound->start }} @endif&enablejsapi=1"
        data-sound="{{ $data->sound->sound }}" data-start="{{ $data->sound->start }}" title="YouTube video player"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen>
    </iframe>
</div>

<!-- Toggle Button -->
<button id="audio-toggle" type="button"
    class=" fixed lg:absolute rounded-full w-10 h-10 top-10 right-2 bg-slate-400 z-50 flex items-center justify-center text-xl shadow-lg hover:bg-slate-600 transition duration-300">
    <span id="audio-status" class="text-white">
        <i class="fa-solid fa-play"></i>
    </span>
</button>
