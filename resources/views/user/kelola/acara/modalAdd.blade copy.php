<div class="modal fade" id="AddAcara" tabindex="-1" aria-labelledby="AddAcara-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="AddAcara-title">Tambah Acara</h5>
                <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i
                        class="uil uil-times fs-4 text-dark"></i></button>
            </div>
            <form id="form-data" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <x-form-input label="Nama Acara" danger="*" wire="acara" place="Acara Kamu :" error="acara" message="$message"/>
                    <div class="mb-3">
                        <label class="form-label">Nama Lokasi/Gedung/Venue <span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <input id="vanue" name="vanue" wire:model="vanue" type="text"
                                class="form-control form-control-solid form-control-sm "
                                placeholder="Kediaman Mempelai Pria">
                        </div>
                        @error('vanue')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat <span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <input id="alamat" name="alamat" wire:model="alamat" type="text"
                                class="form-control form-control-solid form-control-sm "
                                placeholder="Jl. Kemayoran, Jakarta">
                        </div>
                        @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Acara <span class="text-danger">*</span></label>
                        <div class="form-icon position-relative">
                            <input id="date" name="date" wire:model="date" type="date"
                                class="form-control form-control-solid form-control-sm "
                                placeholder="Jl. Kemayoran, Jakarta">
                        </div>
                        @error('date')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3 row">
                        <div class="col">
                            <label class="form-label" for="start">Jam Mulai <span class="text-danger">*</span></label>
                            <div class="form-icon position-relative">
                                <input id="start" name="start" wire:model="start" type="time"
                                    class="form-control form-control-solid form-control-sm w-full"
                                    placeholder="Jl. Kemayoran, Jakarta">
                            </div>
                            @error('start')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label class="form-label" for="end">Jam Selesai <span class="text-danger">*</span></label>
                            <div class="form-icon position-relative">
                                <input id="end" name="end" wire:model="end" type="time"
                                    class="form-control form-control-solid form-control-sm"
                                    placeholder="Jl. Kemayoran, Jakarta">
                            </div>
                            @error('end')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3">
                        <select class="form-select" aria-label="Default select example">
                            <option selected><small>Zona Waktu</small></option>
                            <option value="WIB">WIB</option>
                            <option value="WITA">WITA</option>
                            <option value="WIT">WIT</option>
                          </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link Navigasi Map (Opsional) </label>
                        <div class="form-icon position-relative">
                            <input id="maps" name="maps" wire:model="maps" type="url"
                                class="form-control form-control-solid form-control-sm " placeholder="https://www.google.com/maps">
                        </div>
                        @error('maps')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-check-bold"></i> Simpan Acara</button>
                </div>
            </form>
        </div>
    </div>
</div>
