<style>
    small, h5, span{
        color:#121212;
    }
    
</style>
<x-modal id="AddKado" title="Tambah Metode Kado" wire="save" textButton="Simpan" other="wire:ignore">
    <div class="modal-body">
        <div class="mb-3 ">
            <small class="form-label">Bank / E-wallet <span class="text-danger">*</span></small>
            <select class="js-example-basic-single  w-100" wire:model='giftId' id="giftId" style="width: 100%">
                <option value="1">Choose</option>
                @foreach ($giftPay as $index => $gift)
                    <option value="{{ $gift->id }}">{{ $gift->nama_pay }}</option>
                @endforeach
            </select>
        </div>
        <x-form-input type="text" label="Nama Akun/Rekening" class="mb-1 " danger="*" wire="namaPay"
            place="Calvin" error="balas" message="$message" />
        <x-form-input type="number" label="Nomor Akun/Rekening" class="mb-1 " danger="*" wire="nomorPay"
            place="135266568***" error="balas" message="$message" />
        <x-form-input type="file" label="Qris" class="mb-1 " danger="(Opsional)" wire="qris" place=""
            error="balas" message="$message" />
    </div>
</x-modal>
@if (request()->routeIs('dashboard.undangan.kado'))
    <script src="{{ asset('assetDashboard/libs/select2/dist/js/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // Inisialisasi select2 pada modal saat modal ditampilkan
            $('#AddKado').on('shown.bs.modal', function() {
                var giftId = $('#giftId');
                
                // Cek jika select2 belum diinisialisasi, inisialisasi Select2
                if (!giftId.hasClass('select2-hidden-accessible')) {
                    giftId.select2({
                        dropdownParent: $('#AddKado'), // Set parent ke modal
                        width: '100%'  // Lebar dropdown menyesuaikan modal
                    }).on('change', function() {
                        // Update nilai giftId di Livewire
                        @this.set('giftId', $(this).val());
                    });
                }
            });

            // Hancurkan select2 saat modal ditutup, jika ada instance Select2
            $('#AddKado').on('hidden.bs.modal', function() {
                var giftId = $('#giftId');
                
                // Hanya hancurkan Select2 jika sudah diinisialisasi
                if (giftId.hasClass('select2-hidden-accessible')) {
                    giftId.select2('destroy');
                }
            });
        });
    </script>
@endif

