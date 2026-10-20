@php $standMapEvent = $data->acara?->first(); @endphp
@if ($standMapEvent?->maps)
    <section id="standMap" class="stand-section stand-section--soft">
        <div class="stand-section__header" data-aos="fade-up"><p class="stand-eyebrow">Temukan lokasi acara</p><h2 class="stand-section__title">Peta Lokasi</h2><p class="stand-section__subtitle">Gunakan peta berikut untuk menemukan tempat acara kami.</p></div>
        <div class="stand-map" data-aos="fade-up"><iframe src="{{ $standMapEvent->maps }}" title="Peta lokasi acara" loading="lazy" allowfullscreen></iframe></div>
    </section>
@endif
