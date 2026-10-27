@php
    $standOpeningPhoto = $thumbnailWa?->thumbnail
        ? asset('storage/' . $thumbnailWa->thumbnail)
        : asset('tema/standtheme/assets/img/3.jpg');
@endphp

<section class="stand-section stand-opening" data-aos="fade-up">
    <img class="stand-opening__ornament" src="{{ asset('tema/standtheme/assets/img/bismillah.png') }}" alt="Bismillah">
    <p class="stand-eyebrow">Dengan penuh rasa syukur</p>
    @if ($isWanitaFirst ?? $data->is_wanita_first)
        @if ($data->wanita?->image)
            <div class="stand-opening__portrait"><img src="{{ asset('storage/' . ltrim($data->wanita->image, '/')) }}" alt="{{ $data->wanita?->nama_lengkap ?? 'Mempelai Wanita' }}" loading="lazy"></div>
        @endif
        <h2 class="stand-opening__names">{{ $data->wanita?->nama_lengkap ?? 'Mempelai Wanita' }}</h2>
        <p class="stand-opening__ampersand">&amp;</p>
        @if ($data->pria?->image)
            <div class="stand-opening__portrait"><img src="{{ asset('storage/' . ltrim($data->pria->image, '/')) }}" alt="{{ $data->pria?->nama_lengkap ?? 'Mempelai Pria' }}" loading="lazy"></div>
        @endif
        <h2 class="stand-opening__names">{{ $data->pria?->nama_lengkap ?? 'Mempelai Pria' }}</h2>
    @else
        @if ($data->pria?->image)
            <div class="stand-opening__portrait"><img src="{{ asset('storage/' . ltrim($data->pria->image, '/')) }}" alt="{{ $data->pria?->nama_lengkap ?? 'Mempelai Pria' }}" loading="lazy"></div>
        @endif
        <h2 class="stand-opening__names">{{ $data->pria?->nama_lengkap ?? 'Mempelai Pria' }}</h2>
        <p class="stand-opening__ampersand">&amp;</p>
        @if ($data->wanita?->image)
            <div class="stand-opening__portrait"><img src="{{ asset('storage/' . ltrim($data->wanita->image, '/')) }}" alt="{{ $data->wanita?->nama_lengkap ?? 'Mempelai Wanita' }}" loading="lazy"></div>
        @endif
        <h2 class="stand-opening__names">{{ $data->wanita?->nama_lengkap ?? 'Mempelai Wanita' }}</h2>
    @endif

    @if (! $data->pria?->image && ! $data->wanita?->image)
        <div class="stand-opening__portrait"><img src="{{ $standOpeningPhoto }}" alt="Foto kedua mempelai" loading="lazy"></div>
    @endif
    <p class="stand-opening__description">{{ $data->teksUndangan?->pembuka ?? 'Dengan memohon rahmat dan ridho Tuhan Yang Maha Esa, kami mengundang Anda untuk hadir di hari bahagia kami.' }}</p>

    @php $standOpeningEvent = $data->acara?->first(); @endphp
    <p class="stand-date" data-aos="fade-up">
        <strong>Save the Date</strong><br>
        {{ $standOpeningEvent?->date ? \Carbon\Carbon::parse($standOpeningEvent->date)->translatedFormat('l, j F Y') : 'Segera hadir' }}
    </p>
    @if ($standOpeningEvent?->date)
        <a class="stand-button" href="https://www.google.com/calendar/render?action=TEMPLATE&text={{ rawurlencode($data->title ?? 'Pernikahan Kami') }}&dates={{ date('Ymd', strtotime($standOpeningEvent->date)) }}T100000Z/{{ date('Ymd', strtotime($standOpeningEvent->date)) }}T120000Z&location={{ rawurlencode($standOpeningEvent->alamat ?? '') }}" target="_blank" rel="noopener" data-aos="fade-up">
            <i class="fa-regular fa-calendar-plus"></i>Tambah ke Kalender
        </a>
    @endif

    @if ($data->qoute?->title || $data->qoute?->qoute)
        <div class="stand-quote" data-aos="fade-up">
            @if ($data->qoute?->title)<strong>{{ $data->qoute->title }}</strong><br>@endif
            {{ $data->qoute?->qoute ?? '' }}
            @if ($data->qoute?->subtitle)<br><span>{{ $data->qoute->subtitle }}</span>@endif
        </div>
    @endif
</section>
