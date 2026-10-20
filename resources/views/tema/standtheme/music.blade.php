@if ($data->sound?->isActive)
    <button id="bukaModal" type="button" class="stand-button" style="position: fixed; right: .75rem; bottom: 5rem; z-index: 45;"> <i class="fa-solid fa-music"></i><span>Musik</span></button>

    <div id="mod" class="stand-music-modal is-hidden" role="dialog" aria-modal="true" aria-label="Kontrol musik">
        <div class="stand-music-modal__panel">
            <h2>Musik Undangan</h2>
            <button id="musicToggle" type="button" class="stand-button"><i class="fa-solid fa-play"></i>Putar / Jeda</button>
            <button id="tutupModal" type="button" class="stand-button stand-button--outline" style="margin-left: .4rem;">Tutup</button>
        </div>
    </div>
@endif

@include('tema.partials.music', ['data' => $data])
