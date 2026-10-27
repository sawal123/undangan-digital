<div class="darksweet-couple-grid">
    @php
        $isWanitaFirst = $isWanitaFirst ?? $data->is_wanita_first;
        $couples = $isWanitaFirst
            ? [
                [
                    'person' => $data->wanita,
                    'default' => 'tema/darksweet/img/smiley-newlyweds-posing-together-outdoors.jpg',
                ],
                [
                    'person' => $data->pria,
                    'default' => 'tema/darksweet/img/young-bride-groom-outdoor-photoshoot.jpg',
                ],
            ]
            : [
                [
                    'person' => $data->pria,
                    'default' => 'tema/darksweet/img/young-bride-groom-outdoor-photoshoot.jpg',
                ],
                [
                    'person' => $data->wanita,
                    'default' => 'tema/darksweet/img/smiley-newlyweds-posing-together-outdoors.jpg',
                ],
            ];
    @endphp

    @foreach ($couples as $couple)
        @php
            $person = $couple['person'];
            $personImage = !empty($person?->image)
                ? asset('storage/' . ltrim($person->image, '/'))
                : asset($couple['default']);
        @endphp
        <article class="darksweet-person-card" data-aos="fade-up">
            <div class="darksweet-person-card__image">
                <img src="{{ $personImage }}" alt="{{ $person?->nama_lengkap ?? '' }}" loading="lazy">
            </div>
            <div class="darksweet-person-card__body">
                <h3 class="darksweet-person-card__name">{{ $person?->nama_lengkap ?? '' }}</h3>
                <p class="darksweet-person-card__description">{{ $person?->deskripsi ?? '' }}</p>
            </div>
        </article>
    @endforeach
</div>

