<div>
    <section class="message-section mt-5 mx-3" id="form-section">
        <h5 class="text-center" data-aos="fade-up" data-aos-duration="1000">Ucapan & Doa</h5>

        {{-- alert sukses/error --}}
        @if ($success)
            <div class="alert alert-success mt-2">{{ $message }}</div>
        @endif
        @if ($error)
            <div class="alert alert-danger mt-2">{{ $message }}</div>
        @endif

        {{-- form --}}
        @if ($publicIsActive || (!$publicIsActive && $kode))
            <form wire:submit.prevent="save">
                <input type="hidden" wire:model="dataId">
                <input type="hidden" wire:model="kode">

                <!-- Input Nama -->
                <div class="input-name mb-4">
                    <input type="text" id="messageInput" class="form-control custom-input-bg" wire:model="nama"
                        placeholder="Nama Anda">
                    @error('nama')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Ucapan -->
                <div class="input-message mb-4">
                    <textarea id="messageInput" class="form-control custom-input-bg" rows="5" wire:model="ucapan"
                        placeholder="Tulis Ucapan dan Doa"></textarea>
                    @error('ucapan')
                        <div class="text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Status -->
                <div class="input-message mb-4">
                    <select id="messageInput" class="form-select custom-input-bg" wire:model="status">
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

        {{-- List Ucapan --}}
        @if ($publicIsActive)
            <style>
                .scrollspy-example {
                    max-height: 250px;
                    overflow-y: auto;
                }
            </style>
            <div data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary p-3 rounded-2" tabindex="0">
                @foreach ($listUcapan as $item)
                    <div class="messages-list">
                        <div class="card message-item mb-3">
                            <div class="card-body">
                                <div class="d-flex gap-2">
                                    <strong>{{ $item->tamu->nama }}</strong>
                                    <h6><span
                                            class="badge text-bg-secondary">{{ ucwords(str_replace('_', ' ', $item->status)) }}</span>
                                    </h6>
                                </div>
                                <p class="card-text" style="color: #9e0050; margin: 0px">
                                    <small>{{ date('l', strtotime($item->created_at)) }},
                                        {{ date('d m Y', strtotime($item->created_at)) }}</small>
                                </p>
                                <p class="card-text">{{ $item->ucapan }}</p>
                                @if ($item->balas)
                                    <hr>
                                    <p class="bg-light p-2 rounded border" style="margin: 0px">
                                        Balasan : {{ $item->balas }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</div>
