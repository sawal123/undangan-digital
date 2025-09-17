 <div class="card-body d-flex flex-column flex-lg-row gap-3">

     <div class="d-flex flex-column">
         @if ($thumbnail)
             <img class="img-thumbnail rounded float-start object-fit-cover" style="height: 200px; width: auto"
                 src="{{ $gambar ? $gambar->temporaryUrl() : asset('storage/' . $thumbnail->thumbnail) }}"
                 alt="Thumbnail">
             <button class="btn btn-sm btn-danger mt-2" wire:click="delThumbnail">Hapus Gambar</button>
         @else
             <img class="img-thumbnail rounded float-start object-fit-cover" style="height: 200px; width: auto"
                 src="{{ $gambar ? $gambar->temporaryUrl() : 'https://i.pinimg.com/564x/8d/ff/49/8dff49985d0d8afa53751d9ba8907aed.jpg' }}"
                 alt="Default Image">
             <button class="btn btn-sm btn-danger mt-2" wire:click="delThumbnail" disabled>Hapus Gambar</button>
         @endif
     </div>
     <div class="text-lg-end">
         <p>Gambar ini akan muncul di cover undangan atau ketika kamu mengirimi pesan melalui whatsapp</p>
         <form wire:submit.prevent='thumbnailWa'>
             <input type="file" class="form-control" wire:model='gambar'>
             <button class="btn btn-sm btn-primary mt-2 ">Upload Gambar</button>
         </form>
     </div>
 </div>
