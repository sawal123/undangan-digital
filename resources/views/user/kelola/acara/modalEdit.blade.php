<x-modal id="EditAcara" title="Edit Acara" wire="save" textButton="Simpan">
    <div class="modal-body">
        <x-form-input type="text" label="Nama Acara" danger="*" wire="acara" place="Acara Kamu :" error="acara"
            message="$message" />
        <x-form-input type="text" label="Nama Lokasi/Gedung/Venue" danger="*" wire="vanue"
            place="Kediaman Mempelai Pria" error="vanue" message="$message" />
        <x-form-input type="text" label="Alamat" danger="*" wire="alamat" place="Jl. Kemayoran, Jakarta"
            error="alamat" message="$message" />
        <x-form-input type="date" label="Tanggal Acara" danger="*" wire="date" error="date"
            message="$message" />
        <div class="mb-3 row">
            <div class="col">
                <label class="form-label" for="start">Jam Mulai <span class="text-danger">*</span></label>
                <div class="form-icon position-relative">
                    <input  name="start" wire:model="start" type="time"
                        class="form-control form-control-solid form-control-sm ">
                </div>
                @error('start')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col">
                <label class="form-label" for="end">Jam Selesai <span class="text-danger">*</span></label>
                <div class="form-icon position-relative">
                    <input name="end" wire:model="end" type="time"
                        class="form-control form-control-solid form-control-sm">
                </div>
                @error('end')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="mb-3">
            <select class="form-select" aria-label="Default select example" wire:model='zona'>
                <option selected>Zona Waktu</option>
                <option value="WIB">WIB</option>
                <option value="WITA">WITA</option>
                <option value="WIT">WIT</option>
            </select>
        </div>
        <x-form-input type="url" label="Link Navigasi Map (Opsional)" place="https://www.google.com/maps"
            wire="maps" error="maps" message="$message" />
    </div>
</x-modal-dash>
