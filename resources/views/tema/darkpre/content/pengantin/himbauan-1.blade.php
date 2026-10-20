<section class="darkpre-section darkpre-guest-section" aria-label="Keterangan undangan">
    <p class="darkpre-section-lead" data-aos="fade-up">
        {{ $data->teksUndangan?->penutup ?? 'Merupakan suatu kehormatan bagi kami apabila Anda berkenan hadir dan memberikan doa terbaik.' }}
    </p>

    @if ($data->teksPenutup?->mengundang)
        <div class="darkpre-guest-list" data-aos="fade-up">
            <strong>Turut Mengundang</strong>
            <div>{!! nl2br(e($data->teksPenutup->mengundang)) !!}</div>
        </div>
    @endif
</section>
