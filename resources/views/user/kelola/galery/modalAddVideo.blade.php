<x-modal id="AddVideo" title="Tambah Video" wire="save" textButton="Simpan">
    <div class="modal-body">
        <x-form-input type="url" label="Galery Video" danger="*" wire="video" place="https://www.youtube.com/watch?v=galery" error="video"
            message="$message" />
    </div>
</x-modal>
