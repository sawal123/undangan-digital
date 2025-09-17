<div>
    {{-- If you look to others for fulfillment, you will never truly be fulfilled. --}}

    <div class="card border border-info my-2">
        <div class="card-body">
            @if (session()->has('title'))
                <div class="alert alert-info mt-2">
                    {{ session('title') }}
                </div>
            @endif
            @include('livewire.dashboard.kelola.setting.title')
        </div>
    </div>
    <div class="card border border-info my-2">
        @if (session()->has('font'))
            <div class="alert alert-info mt-2 mx-2">
                {{ session('font') }}
            </div>
        @endif
        <div class="card-body">
            <form wire:submit='updateFont({{ $dataId }})'>
                @foreach ($fonts as $item)
                    <link href="{{ $item->link }}" rel="stylesheet">
                @endforeach
                <div class="row">
                    <div class="col-12 col-lg-6 mb-3">
                        <div class="mb-3">
                            <div class="mb-3">
                                <label class="form-label">Font Title <span class="text-danger">*</span></label>
                                <div class="form-icon position-relative">
                                    <select class="form-select" wire:model.live='fontTitle'
                                        aria-label="Default select example">
                                        <option value="" selected disabled>Pilih Font</option>
                                        @foreach ($fonts as $item)
                                            <option value="{{ $item->id }}"
                                                style="font-family: '{{ $item->nama }}', sans-serif;">
                                                {{ $item->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Size Font</label>
                                <div class="form-icon position-relative">
                                    <select class="form-select" wire:model.live='sizeTitle'
                                        aria-label="Default select example">
                                        @for ($i = 10; $i < 50; $i++)
                                            <option value="{{ $i }}">
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if ($selectedFont)
                            <span class="mt-4"
                                style="font-family: '{{ $selectedFont->nama }}', sans-serif; font-size: {{ $sizeTitle }}px;">
                                {{ $title }}
                            </span>
                        @else
                            <span class="mt-4">{{ $title }}</span>
                        @endif
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="mb-3">
                            <label class="form-label">Font paragraf <span class="text-danger">*</span></label>
                            <div class="form-icon position-relative">
                                <select class="form-select" wire:model.live='fontPara'
                                    aria-label="Default select example">
                                    <option selected disabled value="">Pilih Font</option>
                                    @foreach ($fonts as $item)
                                        <option value="{{ $item->id }}"
                                            style="font-family: '{{ $item->nama }}', sans-serif;">
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if ($selectedPara)
                            <span class="mt-4"
                                style="font-family: '{{ $selectedPara->nama }}', sans-serif; font-size: 16px;">
                                Style Font ini akan muncul di paragrap
                            </span>
                        @else
                            <span class="mt-4">Style Font ini akan muncul di paragrap</span>
                        @endif
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
        @include('livewire.dashboard.kelola.setting.thumbnail')
    </div>

    <div class="card border border-info my-2">
        <div class="card-body">
            @if (session()->has('teksUndangan'))
                <div class="alert alert-info mt-2">
                    {{ session('teksUndangan') }}
                </div>
            @endif
            <h5>Teks Undangan</h5>
            @include('livewire.dashboard.kelola.setting.teksUndangan')
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
