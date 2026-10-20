<div>
    @if ($isActive)
        @if ($success)
            <div class="darksweet-alert darksweet-alert--success">Ucapan berhasil dikirim. Terima kasih atas doa baiknya.</div>
        @endif

        @if ($error)
            <div class="darksweet-alert darksweet-alert--error">Terjadi kesalahan. Silakan coba lagi.</div>
        @endif

        @if ($publicIsActive || (!$publicIsActive && $kode))
            <form wire:submit.prevent="save" class="darksweet-form">
                <div class="darksweet-form__field">
                    <label for="nama">Nama lengkap</label>
                    <input type="text" id="nama" wire:model="nama" placeholder="Masukkan nama Anda">
                    @error('nama') <span class="darksweet-form__error">{{ $message }}</span> @enderror
                </div>

                <div class="darksweet-form__field">
                    <label for="ucapan">Ucapan dan doa</label>
                    <textarea id="ucapan" wire:model="ucapan" placeholder="Tulis ucapan terbaik Anda"></textarea>
                    @error('ucapan') <span class="darksweet-form__error">{{ $message }}</span> @enderror
                </div>

                <div class="darksweet-form__field">
                    <label for="status">Konfirmasi kehadiran</label>
                    <select id="status" wire:model="status">
                        <option value="" disabled>Pilih status kehadiran</option>
                        <option value="Datang Dong">Saya akan hadir</option>
                        <option value="Ga bisa Datang Nih">Maaf, saya tidak bisa hadir</option>
                        <option value="Diusahakan Datang Ya">Masih diusahakan hadir</option>
                    </select>
                    @error('status') <span class="darksweet-form__error">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="darksweet-button">Kirim Ucapan</button>
            </form>
        @endif

        @if ($viewIsActive)
            <div class="darksweet-message-list" tabindex="0" aria-label="Daftar ucapan">
                @foreach ($listUcapan as $item)
                    <article class="darksweet-message-card">
                        <div class="darksweet-message-card__top">
                            <strong class="darksweet-message-card__name">{{ $item->tamu->nama }}</strong>
                            <span class="darksweet-message-card__status">{{ ucwords(str_replace('_', ' ', $item->status)) }}</span>
                        </div>
                        <p class="darksweet-message-card__date">{{ date('d F Y', strtotime($item->created_at)) }}</p>
                        <p class="darksweet-message-card__text">{{ $item->ucapan }}</p>
                        @if ($item->balas)
                            <p class="darksweet-message-card__reply">Balasan: {{ $item->balas }}</p>
                        @endif
                    </article>
                @endforeach
            </div>
        @endif
    @endif
</div>
