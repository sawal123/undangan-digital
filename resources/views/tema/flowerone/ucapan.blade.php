@if ($data->FiturUcapan->isActive)
    <section class="message-section mt-5 mx-3" id="form-section">
        <h5 class="text-center" data-aos="fade-up" data-aos-duration="1000">Ucapan & Doa</h5>
        @if (session()->has('message'))
            <div class="alert alert-info mt-2">
                {{ session('message') }}
            </div>
        @endif
        @if ($data->FiturUcapan->publicIsActive)
            <form data-aos="fade-up" data-aos-duration="1000" action="{{ route('savedoa') }}" method="post">
                @csrf

                <input type="hidden" name="dataId" value="{{ $data->id }}">
                <input type="hidden" name="kode" value="{{ $kode }}">
                <!-- Input field for messages -->
                <div class="input-name mb-4">
                    <input type="text" id="messageInput" class="form-control custom-input-bg" name="nama"
                        placeholder="Nama Anda" value="{{ $tamu }}">
                    @error('nama')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Input field for messages -->
                <div class="input-message mb-4">
                    <textarea id="messageInput" class="form-control custom-input-bg" rows="5" name="ucapan" required
                        placeholder="Tulis Ucapan dan Doa"></textarea>
                    @error('ucapan')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-message mb-4">
                    <select id="messageInput" class="form-select custom-input-bg" name="status"
                        aria-label="Default select example">
                        <option selected disabled>Konfirmasi Kehadiran</option>
                        <option value="Datang Dong">Datang Dong</option>
                        <option value="Ga bisa Datang Nih">Ga bisa Datang Nih</option>
                        <option value="Diusahakan Datang Ya">Diusahakan Datang Ya</option>
                    </select>
                    @error('status')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn text-white mb-3">Kirim Ucapan</button>
            </form>
        @elseif(!$data->FiturUcapan->publicIsActive && $kode)
            <form data-aos="fade-up" data-aos-duration="1000" action="{{ route('savedoa') }}" method="post">
                @csrf
                @if (session()->has('message'))
                    <div class="alert alert-info mt-2">
                        {{ session('message') }}
                    </div>
                @endif
                <input type="hidden" name="dataId" value="{{ $data->id }}">
                <input type="hidden" name="kode" value="{{ $kode }}">
                <!-- Input field for messages -->
                <div class="input-name mb-4">
                    <input type="text" id="messageInput" class="form-control custom-input-bg" name="nama"
                        placeholder="Nama Anda" value="{{ $tamu }}">
                    @error('nama')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Input field for messages -->
                <div class="input-message mb-4">
                    <textarea id="messageInput" class="form-control custom-input-bg" rows="5" name="ucapan"
                        placeholder="Tulis Ucapan dan Doa"></textarea>
                    @error('ucapan')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input-message mb-4">
                    <select id="messageInput" class="form-select custom-input-bg" name="status"
                        aria-label="Default select example">
                        <option selected disabled>Konfirmasi Kehadiran</option>
                        <option value="Datang Dong">Datang Dong</option>
                        <option value="Ga bisa Datang Nih">Ga bisa Datang Nih</option>
                        <option value="Diusahakan Datang Ya">Diusahakan Datang Ya</option>
                    </select>
                    @error('status')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn text-white mb-3">Kirim Ucapan</button>
            </form>


        @endif
        <!-- Messages List -->
        @if ($data->FiturUcapan->viewIsActive)
            <style>
                .scrollspy-example {
                    max-height: 250px;
                    overflow-y: auto;
                }
            </style>
            <div data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
                @foreach ($ucapan as $item)
                    <div class="messages-list">
                        <div class="card message-item mb-3" data-aos="fade-up" data-aos-duration="1000">
                            <div class="card-body">
                                <div class="d-flex gap-2">
                                    <strong>{{ $item->tamu->nama }}</strong>
                                    <h6><span class="badge text-bg-secondary">{{ $item->status }}</span></h6>
                                </div>
                                <p class="card-text" style="color: #9e0050; margin: 0px">
                                    <small>{{ date('l', strtotime($item->created_at)) }},
                                        {{ date('d m Y', strtotime($item->created_at)) }}</small>
                                </p>
                                <p class="card-text">{{ $item->ucapan }}</p>
                                @if ($item->balas)
                                    <hr>
                                    <p class="bg-light p-2 rounded border" style="margin: 0px">Balasan :
                                        {{ $item->balas }}</p>
                                @endif



                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endif
