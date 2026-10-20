<div>
    @if ($isActive)
        <div class="whitepre-message-panel mb-8">
            @if ($viewIsActive)
                <div class="whitepre-message-list font-poppins">
                    @forelse ($listUcapan as $item)
                        <article class="whitepre-message-card">
                            <h3 class="text-sm font-semibold">{{ $item->tamu->nama }}</h3>
                            <p class="mt-1 text-xs text-pink-900/60">
                                {{ date('l', strtotime($item->created_at)) }},
                                {{ date('d m Y', strtotime($item->created_at)) }}
                            </p>
                            <p class="mt-2 text-sm italic">{{ $item->ucapan }}</p>
                            @if ($item->balas)
                                <p class="mt-2 border-l-2 border-pink-300 pl-3 text-xs italic">
                                    Balasan: {{ $item->balas }}
                                </p>
                            @endif
                        </article>
                    @empty
                        <div class="whitepre-message-card text-center text-sm text-pink-900/65">
                            Belum ada ucapan. Jadilah yang pertama mengirim doa.
                        </div>
                    @endforelse
                </div>
            @endif
        </div>

        <div id="wishes-form" class="whitepre-form-card">
            <h2 class="whitepre-form-title">Kirim Ucapan</h2>
            <p class="whitepre-form-intro">Tinggalkan doa dan ucapan terbaik untuk kedua mempelai.</p>

            <div class="whitepre-form-decoration" aria-hidden="true">
                <img src="{{ asset('tema/whitepre/src/img/bunga bawah.png') }}" alt="">
            </div>

            @if ($success)
                <div class="whitepre-form-alert" role="status">{{ $message }}</div>
            @endif
            @if ($error)
                <div class="whitepre-form-alert whitepre-form-alert--error" role="alert">{{ $message }}</div>
            @endif

            @if ($publicIsActive || (!$publicIsActive && $kode))
                <form wire:submit.prevent="save" class="whitepre-wish-form font-poppins">
                    <div class="whitepre-form-field">
                        <input type="text" wire:model="nama" autocomplete="name" placeholder="Nama Lengkap"
                            class="whitepre-form-input p-3" />
                        @error('nama')
                            <div class="whitepre-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="whitepre-form-field">
                        <textarea wire:model="ucapan" placeholder="Ucapan & Doa" rows="4"
                            class="whitepre-form-input p-3"></textarea>
                        @error('ucapan')
                            <div class="whitepre-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="whitepre-form-field">
                        <select wire:model="status" class="whitepre-form-input p-3">
                            <option value="">Konfirmasi Kehadiran</option>
                            <option value="Datang Dong">Datang Dong</option>
                            <option value="Tidak Bisa Datang Nih">Tidak Bisa Datang Nih</option>
                            <option value="Diusahakan Datang Ya">Diusahakan Datang Ya</option>
                        </select>
                        @error('status')
                            <div class="whitepre-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="whitepre-submit-button w-full p-3">
                        Kirim Sekarang
                    </button>
                </form>
            @endif
        </div>
    @endif
</div>
