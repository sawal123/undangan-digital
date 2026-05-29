@extends('layouts.auth')

@section('content')
    <section class="bg-home bg-circle-gradiant d-flex align-items-center">
        <div class="bg-overlay bg-overlay-white"></div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card form-signin p-4 rounded shadow">
                        <form action="{{ route('dashboard.data.store') }}" method="POST">
                            @csrf
                            {{-- <a href="index.html"><img src="assets/images/logo-icon.png"
                                    class="avatar avatar-small mb-4 d-block mx-auto" alt=""></a> --}}
                            <h5 class="mb-3 text-center">Pilih Jenis Undangan Yang Kamu Inginkan</h5>

                            <div class="form-floating mb-2">
                                <select class="form-select" id="event_type_id" name="event_type_id">
                                    @foreach ($eventTypes as $eventType)
                                        <option value="{{ $eventType->id }}"
                                            @selected(old('event_type_id') == $eventType->id || (!old('event_type_id') && $eventType->key === 'wedding'))>
                                            {{ $eventType->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="event_type_id">Jenis Undangan</label>
                                @error('event_type_id')
                                    <div class="text-danger mt-1" style="font-size: 12px">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating mb-2">
                                <input type="text" class="form-control" id="title" name="title"
                                    placeholder="Harry & Nia" value="{{ old('title') }}">
                                <label for="title">Nama Yang Ingin Ditampilkan</label>
                                <span class="" style="font-size: 12px">Contoh : <strong>Hendra & Heni</strong></span>
                                @error('title')
                                    <div class="text-danger mt-1" style="font-size: 12px">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="basic-url" class="form-label">Your vanity URL</label>
                                <div class="input-group ">
                                    <span class="input-group-text" id="basic-addon3">{{ url('/') }}/u/</span>
                                    <input type="text" class="form-control" id="basic-url" name="slug"
                                        aria-describedby="basic-addon3 basic-addon4" placeholder="harrydannia"
                                        value="{{ old('slug') }}">
                                </div>
                                <div id="nameValidationMessage" class="form-text"></div>
                                @error('slug')
                                    <div class="text-danger mt-1" style="font-size: 12px">{{ $message }}</div>
                                @enderror


                            </div>

                            <button class="btn btn-primary w-100 my-3" type="submit" id="next" disabled>
                                <span class="default-label">Lanjutkan!</span>
                                <span class="loading-label d-none">Memproses...</span>
                            </button>
                        </form>
                        <form action="{{ route('dashboard.logout') }}" method="POST" class="">
                            @csrf
                            <button class="btn btn-danger w-100" type="submit">Log Out</button>
                        </form>
                        <p class="mb-0 text-muted mt-3 text-center">© 2024 Era Digital.</p>
                    </div>
                </div>
            </div>
        </div> <!--end container-->
    </section><!--end section-->
    <script nonce="{{ $nonce ?? '' }}">
        document.querySelector('form[action="{{ route('dashboard.data.store') }}"]')?.addEventListener('submit', function () {
            const button = this.querySelector('#next');
            if (!button) return;
            button.disabled = true;
            button.querySelector('.default-label')?.classList.add('d-none');
            button.querySelector('.loading-label')?.classList.remove('d-none');
        });
    </script>
@endsection
