<x-modal id="EditTamu" title="{{ $title }}" wire="save" textButton="Simpan" other="">
    <div class="modal-body">
        <x-form-input type="hidden" label=""  class="mb-1" danger="" wire="idTamu" error="balas" message="$message" />
        <x-form-input type="text" label="Nama Tamu" class="mb-1 " danger="*" wire="nama"
            place="Calvin dan Patner" error="balas" message="$message" />
        <x-form-input type="number" label="WhatsApp" class="mb-1 " danger="(Opsional)" wire="whatsapp"
            place="08226586****" error="balas" message="$message" />
        <!-- Preview Gambar -->
    </div>
</x-modal>
