<div>
    <div class="alert alert-info mt-2 d-flex align-items-center ">
        <i class="mdi mdi-video fs-1"></i>
        <div class="d-flex  justify-content-between align-items-center w-100 form-check form-switch">
            <p class="m-0 fw-bold">Gunakan Fitur Live Streaming</p>
            <input class="form-check-input" type="checkbox" role="switch"
                wire:change="updateFiturStreaming($event.target.checked)" {{ $fiturStreaming ? 'checked' : '' }}>
        </div>
    </div>
    @if (session()->has('message'))
        <div class="alert alert-success mt-2">
            {{ session('message') }}
        </div>
    @endif
    <div class="card mt-2">
        <div class="card-body">
            <form wire:submit.prevent='save'>
                <x-form-input type="url" label="Link Streaming" danger="" wire="link"
                    place="https://www.youtube.com/fdfgd" error="link" message="$message" class="mb-0" />
                <button class="btn btn-primary btn-sm mt-2">Simpan</button>
            </form>
        </div>
    </div>
</div>
