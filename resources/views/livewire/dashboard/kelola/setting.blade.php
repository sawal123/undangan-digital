<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="card border border-info my-2">
        <div class="card-body">
            @if (session()->has('title'))
                <div class="alert alert-info mt-2">
                    {{ session('title') }}
                </div>
            @endif
            <form wire:submit='update({{ $dataId }})'>
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Title Undangan <span class="text-danger">*</span></label>
                            <div class="form-icon position-relative">
                                <input id="panggilan" name="panggilan" type="text" wire:model='title'
                                    class="form-control" placeholder="Nama Panggilan :">
                            </div>
                            @error('panggilan')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Your vanity URL</label>
                            <div class="input-group ">
                                <span class="input-group-text" id="basic-addon3">{{ url('/u') }}/</span>
                                <input type="text" class="form-control" id="basic-url" wire:model.live='slug'
                                    aria-describedby="basic-addon3 basic-addon4">
                            </div>
                            <div class="form-text text-danger">{{ $pesan }}</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm" {{ $button ? '' : 'disabled' }}>Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card border border-info my-2">
        @if (session()->has('thumbnailWa'))
            <div class="alert alert-info mt-2 mx-2">
                {{ session('thumbnailWa') }}
            </div>
        @endif
        <div class="card-body d-flex flex-column flex-lg-row gap-3">

            <div class="d-flex flex-column">
                @if ($thumbnail)
                    <img class="img-thumbnail rounded float-start object-fit-cover" style="height: 200px; width: auto"
                        src="{{ $gambar ? $gambar->temporaryUrl() : asset('storage/' . $thumbnail->thumbnail) }}"
                        alt="Thumbnail">
                    <button class="btn btn-sm btn-danger mt-2" wire:click="delThumbnail">Hapus Gambar</button>
                @else
                    <img class="img-thumbnail rounded float-start object-fit-cover" style="height: 200px; width: auto"
                        src="{{ $gambar ? $gambar->temporaryUrl() : 'https://i.pinimg.com/564x/8d/ff/49/8dff49985d0d8afa53751d9ba8907aed.jpg' }}"
                        alt="Default Image">
                    <button class="btn btn-sm btn-danger mt-2" wire:click="delThumbnail" disabled>Hapus Gambar</button>
                @endif
            </div>
            <div class="text-lg-end">
                <p>Gambar ini akan muncul di cover undnagan atau ketika kamu mengirimi pesan melalui whatsapp</p>
                <form wire:submit.prevent='thumbnailWa'>
                    <input type="file" class="form-control" wire:model='gambar'>
                    <button class="btn btn-sm btn-primary mt-2 ">Upload Gambar</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card border border-info my-2">
        <div class="card-body">
            @if (session()->has('teksUndangan'))
                <div class="alert alert-info mt-2">
                    {{ session('teksUndangan') }}
                </div>
            @endif
            <h5>Teks Undangan</h5>
            <form wire:submit='TeksUndangan'>
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Teks Pembukaan</label>
                            <textarea name="" id="" class="form-control" cols="30" rows="2" wire:model='pembuka'></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Teks Acara</label>
                            <textarea name="" id="" class="form-control" cols="30" rows="2" wire:model='acara'></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Teks Penutup</label>
                            <textarea name="" id="" class="form-control" cols="30" rows="2" wire:model='penutup'></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="card border border-info my-2">
        <div class="card-body">
            @if (session()->has('teksWA'))
                <div class="alert alert-info mt-2">
                    {{ session('teksWA') }}
                </div>
            @endif
            <h5>Format Teks WhatsApp</h5>
            <form wire:submit='teksWhatsApp'>
                <div class="row">
                    <div class="col-12 col-lg-5">
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Format (Gunakan variabel dinamis untuk menyebut
                                nama tamu secara otomatis)</label>
                            <textarea name="" id="" class="form-control" cols="30" rows="10" wire:model='pesanWa'></textarea>
                        </div>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="mb-3">
                            <small>
                                Variabel Dinamis
                                Merupakan variabel yang nilainya dapat berubah sesuai dengan fungsi dan data. Variabel
                                yang dapat dipakai sebagai berikut:
                                Variabel Deskripsi
                                <br>
                                <strong>@{{ tamu }}</strong> Menampilkan nama tamu secara otomatis
                                <br>
                                <strong>@{{ link }}</strong> Menampilkan link undangan khusus tamu secara
                                otomatis
                                <br>
                                <strong>@{{ nama_mempelai1 }}</strong> Menampilkan nama mempelai 1
                                <br>
                                <strong>@{{ nama_mempelai2 }}</strong> Menampilkan nama mempelai 2
                            </small>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border border-info my-2">
        <div class="card-body">
            @if (session()->has('messageQoute'))
                <div class="alert alert-info mt-2">
                    {{ session('messageQoute') }}
                </div>
            @endif
            <h5>Qoute</h5>
            <form wire:submit='aksiQoute'>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Title</label>
                            <input type="text" class="form-control" wire:model='tit'>
                        </div>
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Isi Qoute</label>
                            <textarea name="" id="" class="form-control" cols="30" rows="5" wire:model='qoute'
                                placeholder="Isi Qoute"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="basic-url" class="form-label">Subtitle</label>
                            <input type="text" class="form-control" wire:model='subtitle'>
                        </div>
                    </div>


                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card border border-info my-2">
        <div class="card-body">
            @if (session()->has('teksPenutup'))
                <div class="alert alert-info mt-2">
                    {{ session('teksPenutup') }}
                </div>
            @endif
            <h5>Turut Mengundang</h5>
            <form wire:submit='teksPenutup'>
                <div class="row">
                    <div class="col-12">
                        <div class="mb-3">
                            {{-- <label for="basic-url" class="form-label">Isi Disini</label> --}}
                            <textarea name="" id="" class="form-control" cols="30" rows="5" wire:model='turut'
                                placeholder="Deliana (Tante)..."></textarea>
                        </div>
                    </div>


                    <div class="d-flex justify-content-end">
                        <button class="btn btn-primary btn-sm">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>
