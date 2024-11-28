<x-modal id="AddPoto" title="Tambah Poto" wire="save" textButton="Simpan" other="wire:ignore.self">
    <div class="modal-body">

        <label class="form-label">Gambar <span class="text-danger">*</span></label>
        <div class="form-icon position-relative">
            <input id="poto" wire:model.defer="poto" type="file" class="form-control">
            <p class="text-danger fs-6" style="font-size: 0.7rem!important">Photo Maks 1Mb</p>
        </div>
        <!-- Preview Gambar -->
        <div class="mt-3">
            <!-- Elemen Loading -->
            <div wire:loading wire:target="poto">
                <div style="display: inline">
                    <svg xmlns="http://www.w3.org/500/svg" viewBox="0 0 200 200">
                        <radialGradient id="a10" cx=".66" fx=".66" cy=".3125" fy=".3125" gradientTransform="scale(1.5)">
                            <stop offset="0" stop-color="#000000"></stop>
                            <stop offset=".3" stop-color="#000000" stop-opacity=".9"></stop>
                            <stop offset=".6" stop-color="#000000" stop-opacity=".6"></stop>
                            <stop offset=".8" stop-color="#000000" stop-opacity=".3"></stop>
                            <stop offset="1" stop-color="#000000" stop-opacity="0"></stop>
                        </radialGradient>
                        <circle transform-origin="center" fill="none" stroke="url(#a10)" stroke-width="15"
                            stroke-linecap="round" stroke-dasharray="200 1000" stroke-dashoffset="0" cx="100" cy="100" r="70">
                            <animateTransform type="rotate" attributeName="transform" calcMode="spline" dur="2"
                                values="360;0" keyTimes="0;1" keySplines="0 0 1 1" repeatCount="indefinite">
                            </animateTransform>
                        </circle>
                        <circle transform-origin="center" fill="none" opacity=".2" stroke="#000000" stroke-width="5"
                            stroke-linecap="round" cx="100" cy="100" r="70"></circle>
                    </svg>
                    <p class="ms-2">Loading...</p>
                </div>
            </div>
            
            <!-- Gambar Preview -->
            @if ($poto)
                <p>Photo Preview:</p>
                <img src="{{ $poto->temporaryUrl() }}" class="img-thumbnail" width="150" id="preview-image">
            @endif
        </div>
    </div>

</x-modal>
