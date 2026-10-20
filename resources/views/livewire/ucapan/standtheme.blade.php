<div>
    @if ($isActive)
        @if ($success)
            <div class="stand-message-card" style="margin-bottom:1rem;color:#316846;">Ucapan berhasil dikirim. Terima kasih atas doa baiknya.</div>
        @endif

        @if ($error)
            <div class="stand-message-card" style="margin-bottom:1rem;color:#9b4545;">Terjadi kesalahan. Silakan coba lagi.</div>
        @endif

        @if ($publicIsActive || (!$publicIsActive && $kode))
            <form wire:submit.prevent="save" class="stand-form">
                <div class="stand-form__field">
                    <label for="standNama">Nama lengkap</label>
                    <input id="standNama" type="text" wire:model="nama" placeholder="Masukkan nama Anda">
                    @error('nama') <span class="stand-form__error">{{ $message }}</span> @enderror
                </div>
                <div class="stand-form__field">
                    <label for="standUcapanText">Ucapan dan doa</label>
                    <textarea id="standUcapanText" wire:model="ucapan" placeholder="Tulis ucapan terbaik Anda"></textarea>
                    @error('ucapan') <span class="stand-form__error">{{ $message }}</span> @enderror
                </div>
                <div class="stand-form__field">
                    <label for="standStatus">Konfirmasi kehadiran</label>
                    <select id="standStatus" wire:model="status">
                        <option value="" disabled>Pilih status kehadiran</option>
                        <option value="Datang Dong">Saya akan hadir</option>
                        <option value="Ga bisa Datang Nih">Maaf, saya tidak bisa hadir</option>
                        <option value="Diusahakan Datang Ya">Masih diusahakan hadir</option>
                    </select>
                    @error('status') <span class="stand-form__error">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="stand-button" wire:loading.attr="disabled">
                    <span wire:loading.remove>Kirim Ucapan</span>
                    <span wire:loading>Kirim...</span>
                </button>
            </form>
        @endif

        @if ($viewIsActive)
            <div class="stand-message-list" tabindex="0" aria-label="Daftar ucapan">
                @foreach ($listUcapan as $item)
                    <article class="stand-message-card">
                        <div class="stand-message-card__top"><strong class="stand-message-card__name">{{ $item->tamu->nama }}</strong><span class="stand-message-card__status">{{ ucwords(str_replace('_', ' ', $item->status)) }}</span></div>
                        <p class="stand-message-card__date">{{ $item->created_at->diffForHumans() }}</p>
                        <p class="stand-message-card__text">{{ $item->ucapan }}</p>
                        @if ($item->balas)<p class="stand-message-card__reply">Balasan: {{ $item->balas }}</p>@endif
                    </article>
                @endforeach
            </div>
        @endif
    @endif
</div>
