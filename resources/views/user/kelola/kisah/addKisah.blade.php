<x-modal id="AddKisah" title="{{ $title }}" wire="save" textButton="Simpan" other="wire:ignore.self">
    <div class="modal-body">
        <x-form-input type="text" label="Judul Kisah Kamu" class="mb-1 " danger="" wire="judul"
        place="Pertemuan Pertama" error="balas" message="$message" />
      <div class="mb-3">
        <div class="form-floating">
            <textarea class="form-control" wire:model='cerita' placeholder="Leave a comment here" id="floatingTextarea"></textarea>
            <label for="floatingTextarea">Ceritakan Disini</label>
          </div>
      </div>
        <!-- Preview Gambar -->
    </div>
    
</x-modal>



<x-modal id="EditKisah" title="{{ $title }}" wire="save" textButton="Simpan" other="wire:ignore.self">
  <div class="modal-body">
      <x-form-input type="text" label="Judul Kisah Kamu" class="mb-1 " danger="" wire="judul"
      place="Pertemuan Pertama" error="balas" message="$message" />
    <div class="mb-3">
      <div class="form-floating">
          <textarea class="form-control" wire:model='cerita' placeholder="Leave a comment here" id="floatingTextarea"></textarea>
          <label for="floatingTextarea">Ceritakan Disini</label>
        </div>
    </div>
      <!-- Preview Gambar -->
  </div>
  
</x-modal>
