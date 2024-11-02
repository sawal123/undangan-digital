<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="card shadow-sm">
        <div class="card-body">
            <form wire:submit.prevent="save">
                <span>Data Mempelai Pria</span>
                <hr>
                <div class="mb-3">
                    <label class="form-label">Nama Mempelai <span class="text-danger">*</span></label>
                    <div class="form-icon position-relative">
                        <i  class="fea icon-sm icons mdi mdi-account d-flex align-items-center"></i>
                        <input id="name" name="nama" type="text" wire:model="nama" class="form-control ps-5"
                            placeholder="Nama Lengkap :">
                    </div>
                    @error('nama')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Nama Panggilan <span class="text-danger">*</span></label>
                    <div class="form-icon position-relative">
                        <i  class="fea icon-sm icons mdi mdi-account d-flex align-items-center"></i>
                        <input id="panggilan" name="panggilan" wire:model="panggilan" type="text"
                            class="form-control ps-5" placeholder="Nama Panggilan :">
                    </div>
                    @error('panggilan')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                    <div class="form-icon position-relative">
                        <i  class="fea icon-sm icons mdi mdi-comment-text d-flex align-items-center"></i>
                        <input id="deskripsi" name="deskripsi" type="text" wire:model="deskripsi"
                            class="form-control ps-5" placeholder="Putra Bpk Polan & Ibu Paulani">
                    </div>
                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="mb-3 d-flex gap-2">
                    @if ($gambar)
                        @if (is_string($gambar))
                            <!-- Jika $gambar adalah URL yang sudah ada -->
                            <img src="{{ $gambar }}" class="img-thumbnail" width="150" alt="Preview Image">
                        @else
                            <!-- Jika $gambar adalah file baru dari unggahan -->
                            <img src="{{ $gambar->temporaryUrl() }}" class="img-thumbnail" width="150"
                                alt="Preview Image">
                        @endif
                    @endif
                    <div class="">
                        <label class="form-label">Gambar <span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <input id="deskripsi" name="gambar" wire:model="gambar" type="file" class="form-control"
                                onchange="previewImage(event)">
                        </div>

                        @error('gambar')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="mdi mdi-check-circle-outline"></i> Simpan
                </button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('livewire:load', function() {
            Livewire.hook('message.processed', (message, component) => {
                feather
            .replace(); // Inisialisasi ulang feather icons setiap kali Livewire melakukan re-render
            });
        });
    </script>

</div>
