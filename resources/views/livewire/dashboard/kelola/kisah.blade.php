<div>
    <style>
        @media (min-width: 768px) {

            /* Desktop */
            .custom-img-size {
                width: 300px;
            }
        }

        @media (max-width: 767.98px) {

            /* Mobile */
            .custom-img-size {
                width: 100%;
            }
        }
    </style>
    @if (session()->has('message'))
        <div class="alert alert-success mt-2">
            {{ session('message') }}
        </div>
    @endif

    <div class="row my-2">
        <div class="col-lg-12 col-md-12 my-2">
            <div class="card">
                <div class="card-body">
                    @forelse ($kisahCInta as $item)
                        <div class="my-5">
                            <div class="d-lg-flex gap-3">
                                <div class="p-2 border d-flex flex-column rounded text-center" style="width: fit-content;">
                                    <!-- Container upload -->
                                    <div class="image-upload-container position-relative custom-img-size"  style="cursor: pointer;"  wire:click="$dispatch('triggerFileInput', { itemId: {{ $item->id }} })">
                                        <!-- Gambar dengan ID unik -->
                                        <img src="{{ isset($poto[$item->id]) ? $poto[$item->id]->temporaryUrl() : asset('storage/' . ($item->image->image ?? 'default-placeholder.png')) }}"
                                             class="img-fluid rounded custom-img-size imagePreview"
                                             id="imagePreview-{{ $item->id }}" alt="Klik untuk upload foto" >
                                        <!-- Overlay teks di dalam gambar -->
                                        <div class="overlay-text position-absolute top-50 start-50 translate-middle text-white text-center"
                                             style="background: rgba(0, 0, 0, 0.6); padding: 5px; border-radius: 5px; font-size: 1rem;">
                                            <i class="mdi mdi-camera"></i> Klik untuk upload foto
                                        </div>
                                    </div>
                    
                                    <!-- Form untuk mengunggah gambar -->
                                    <form wire:submit.prevent="saveImage({{ $item->id }})" >
                                        <input type="file"  wire:model="poto.{{ $item->id }}" id="fileInput-{{ $item->id }}" style="display: none" accept="image/*" onchange="previewImage(event, {{ $item->id }})" >
                                        <button type="submit" class="btn btn-sm btn-info mt-2">
                                            <i class="mdi mdi-upload"></i> Upload Gambar
                                        </button>
                                    </form>
                                </div>
                                



                                <div class="d-flex align-items-start flex-column">
                                    <div class="">
                                        <h6>{{ $item->title }}</h6>
                                        <small>{{ $item->deskripsi }}</small>

                                    </div>
                                    <div class="mt-auto">
                                        <button class="btn btn-sm btn-light border-info" data-bs-toggle="modal"
                                        data-bs-target="#EditKisah" wire:click='modalEditKisah({{ $item->id }})'>Edit</button>
                                        <button class="btn btn-sm btn-danger" wire:click='delete({{ $item->id }})'>Hapus</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @empty
                        <p>Belum Ada Kisah Cinta Kamu.</p>
                    @endforelse

                </div>
                <hr>
                <button class="btn btn-primary" wire:click='modalAddKisah' data-bs-toggle="modal"
                    data-bs-target="#AddKisah"><i class="mdi mdi-plus-box"></i> Tambah Kisah
                    Cinta</button>
                @include('user.kelola.kisah.addKisah')
            </div>
        </div>
    </div>


</div>
