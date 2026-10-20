@if ($data->FiturUcapan?->isActive)
    <section id="wishes" class="whitepre-section whitepre-wishes-section" aria-label="Ucapan dan doa">
        <h2 class="whitepre-section-heading" data-aos="fade-up">Ucapan &amp; Doa</h2>
        <livewire:ucapan.ucapan :data="$data" :tamu="$tamu" :kode="$kode" />
    </section>
@endif
