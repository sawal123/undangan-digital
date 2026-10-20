<div>
    @if ($isActive)
        <div class="darkpre-message-panel">
            @if ($viewIsActive)
                <div class="darkpre-message-list">
                    @forelse ($listUcapan as $item)
                        <article class="darkpre-message-card">
                            <div class="flex items-center justify-between gap-3">
                                <h3 class="text-sm font-semibold">{{ $item->tamu->nama }}</h3>
                                <span class="rounded-full border border-orange-200/30 px-2 py-1 text-[10px] text-orange-100">
                                    {{ ucwords(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </div>
                            <p class="mt-1 text-xs text-orange-100/60">{{ $item->created_at->diffForHumans() }}</p>
                            <p class="mt-2 text-sm italic">{{ $item->ucapan }}</p>
                            @if ($item->balas)
                                <p class="mt-2 border-l-2 border-orange-200/50 pl-3 text-xs italic">
                                    Balasan: {{ $item->balas }}
                                </p>
                            @endif
                        </article>
                    @empty
                        <div class="darkpre-message-card text-center text-sm">
                            Belum ada ucapan. Jadilah yang pertama mengirim doa.
                        </div>
                    @endforelse
                </div>
            @endif
        </div>

        @if ($publicIsActive || (!$publicIsActive && $kode))
            <div id="wishes-form" class="darkpre-form-card">
                <h2 class="darkpre-form-title">Kirim Ucapan</h2>
                <p class="darkpre-form-intro">Tinggalkan doa dan ucapan terbaik untuk kedua mempelai.</p>

                @if ($success)
                    <div class="darkpre-form-alert" role="status">{{ $message }}</div>
                @endif
                @if ($error)
                    <div class="darkpre-form-alert darkpre-form-alert--error" role="alert">{{ $message }}</div>
                @endif

                <form wire:submit.prevent="save" class="darkpre-wish-form">
                    @unless ($publicIsActive)
                        @if (session()->has('message'))
                            <div class="darkpre-form-alert" role="status">{{ session('message') }}</div>
                        @endif
                        <input type="hidden" wire:model="kode">
                    @endunless

                    <input type="hidden" wire:model="dataId">

                    <div>
                        <input type="text" wire:model="nama" value="{{ $tamu }}" autocomplete="name"
                            placeholder="Nama Lengkap" class="darkpre-form-input p-3">
                        @error('nama')
                            <div class="darkpre-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <textarea wire:model="ucapan" placeholder="Ucapan & Doa" rows="4"
                            class="darkpre-form-input p-3"></textarea>
                        @error('ucapan')
                            <div class="darkpre-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <select wire:model="status" class="darkpre-form-input p-3">
                            <option value="">Konfirmasi Kehadiran</option>
                            <option value="datang">Datang Dong</option>
                            <option value="tidak_datang">Tidak Bisa Datang Nih</option>
                            <option value="diusahakan">Diusahakan Datang Ya</option>
                        </select>
                        @error('status')
                            <div class="darkpre-form-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="darkpre-submit-button p-3">Kirim Sekarang</button>
                </form>
            </div>
        @endif
    @endif
</div>
