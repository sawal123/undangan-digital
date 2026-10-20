@if ($data->FiturUcapan?->isActive)
    <div class="darksweet-attendance">
        <div class="darksweet-section__header" data-aos="fade-up">
            <p class="darksweet-eyebrow">Doa dan harapan</p>
            <h2 class="darksweet-section__title">Kirim Ucapan</h2>
            <p class="darksweet-section__subtitle">Tinggalkan pesan terbaik untuk kedua mempelai.</p>
        </div>
        <livewire:ucapan.ucapan :data="$data" :tamu="$tamu" :kode="$kode" />
    </div>
@endif
