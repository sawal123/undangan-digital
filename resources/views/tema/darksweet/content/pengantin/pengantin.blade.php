<div class="darksweet-couple-grid">
    @foreach ([['person' => $data->pria, 'label' => 'Mempelai Pria'], ['person' => $data->wanita, 'label' => 'Mempelai Wanita']] as $couple)
        @php $person = $couple['person']; @endphp
        <article class="darksweet-person-card" data-aos="fade-up">
            <div class="darksweet-person-card__image">
                <img src="{{ asset('storage/' . ($person?->image ?? '')) }}" alt="{{ $couple['label'] }} {{ $person?->nama_lengkap ?? '' }}" loading="lazy">
            </div>
            <div class="darksweet-person-card__body">
                <p class="darksweet-eyebrow">{{ $couple['label'] }}</p>
                <h3 class="darksweet-person-card__name">{{ $person?->nama_lengkap ?? '' }}</h3>
                <p class="darksweet-person-card__description">{{ $person?->deskripsi ?? '' }}</p>
            </div>
        </article>
    @endforeach
</div>
