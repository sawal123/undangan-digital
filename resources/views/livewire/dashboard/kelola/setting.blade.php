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
                                <span class="input-group-text" id="basic-addon3">https://erawedding.com/</span>
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
                                <strong>@{{ guest_name }}</strong> Menampilkan nama tamu secara otomatis
                                <br>
                                <strong>@{{ guest_code }}</strong> Menampilkan kode undangan tamu secara otomatis
                                <br>
                                <strong>@{{ guest_link }}</strong> Menampilkan link undangan khusus tamu secara
                                otomatis
                                <br>
                                <strong>@{{ bride1_name }}</strong> Menampilkan nama mempelai 1
                                <br>
                                <strong>@{{ bride2_name }}</strong> Menampilkan nama mempelai 2
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
