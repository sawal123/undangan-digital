@if ($data->sound->isActive)
    <!-- Sticky Button -->
    <div class="fixed bottom-4 right-0 z-50">
        <button id="bukaModal"
            class="bg-blue-600 text-white px-4 py-2 rounded-s-full shadow-lg hover:bg-blue-700 focus:outline-none">
            Music
        </button>
    </div>
@endif

<!-- Modal -->
<div id="mod" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <iframe id="videoFrame" width="100%" height="315" src=""
            data-video-url="@if ($data->sound->isActive){{ $data->sound->sound }}@endif"
            data-video-start="@if ($data->sound->isActive){{ $data->sound->start }}@endif"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        <button id="tutupModal"
            class="bg-red-600 mt-2 text-white px-4 py-2 rounded-lg hover:bg-red-700 focus:outline-none">
            Close
        </button>
    </div>
</div>
{{-- @endif --}}
