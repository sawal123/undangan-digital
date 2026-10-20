@if ($data->FiturUcapan?->isActive)
    <section id="wishes" class="darkpre-section darkpre-wishes-section" aria-label="Ucapan dan doa">
        <h2 class="darkpre-section-heading" data-aos="fade-up">Ucapan &amp; Doa</h2>
        <livewire:ucapan.darkpre :data="$data" :tamu="$tamu" :kode="$kode" />
    </section>
@endif
