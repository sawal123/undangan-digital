@if ($data->sound->isActive)
    <div class="position-fixed d-flex flex-column z-3"
        style="right: -35px; top: 400px; gap: 70px; z-index: 1; height: 100px; ">
        <button type="button" class="btn text-white" data-bs-toggle="modal" data-bs-target="#musicModal" id="link"
            style="transform: rotate(90deg); background-color: #9e0050;"><i class="fa-solid fa-music"></i>
            Music
        </button>
    </div>
@endif



<!-- Modal untuk Music -->
<div class="modal fade" id="musicModal" tabindex="-1" aria-labelledby="musicModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="musicModalLabel">Music</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <iframe id="videoFrame" width="100%" height="315"
                    src=""
                    data-video-url="@if($data->sound->isActive ){{ $data->sound->sound }}@endif" data-video-start="@if($data->sound->isActive ){{ $data->sound->start }}@endif"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                <!-- Toggle Play/Pause button -->
                <div class="mt-3 text-center d-flex justify-content-center">
                    <button id="toggleButton" class="btn custom-toggle-btn rounded-circle">
                        <i class="fa-solid fa-pause"></i>
                    </button>
                </div>
            </div>

            <div class="modal-footer">
                <a href="{{$data->sound->sound}}" class="btn btn-danger px-5"><i class="fa-brands fa-youtube mx-1"></i>Subscribe
                    Youtube</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal untuk QR Code -->
{{-- <div class="modal fade" id="qrcodeModal" tabindex="-1" aria-labelledby="qrcodeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content rounded-3 shadow-lg">
                <div class="modal-header text-white">
                    <h1 class="modal-title fs-5" id="qrcodeModalLabel">QR Code Check-In</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="w-100 py-3 border border-info rounded-3 text-success text-center">
                        <p class="fs-6"><strong>Kamu Sudah Check In</strong></p>
                        <button type="button" class="btn btn-success text-white h-25"
                            style="">
                            <small>Tampilkan QR Check-In</small>
                        </button>
                    </div>

                    <div class="w-100 text-center my-4">
                        <p class="fs-5">Gunakan QR untuk Check-In</p>
                        <img src="img/qr-1.jpg" alt="QR Code" class="img-fluid rounded ">
                    </div>

                    <div class="w-100 text-center">
                        <h5 class="text-primary">Melisa</h5>
                        <p class="text-muted">ID: 2345234</p>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        style="background-color: #9e0050;">Tutup</button>
                </div>
            </div>
        </div>
    </div> --}}
