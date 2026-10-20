<section id="standUcapan" class="stand-section">
    @if ($data->FiturUcapan?->isActive)
        <div class="stand-message-wrap">
            <div class="stand-section__header" data-aos="fade-up"><p class="stand-eyebrow">Doa dan harapan</p><h2 class="stand-section__title">Kirim Ucapan</h2><p class="stand-section__subtitle">Tinggalkan pesan terbaik untuk kedua mempelai.</p></div>
            <livewire:ucapan.ucapan :data="$data" :tamu="$tamu" :kode="$kode" />
        </div>
    @endif
</section>
