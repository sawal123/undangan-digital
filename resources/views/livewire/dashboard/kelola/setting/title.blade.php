 <form wire:submit.prevent='titleA({{ $dataId }})' class="mb-3">
     <div class="row">
         <div class="col-12">
             <div class="mb-3">
                 <label for="basic-url" class="form-label">Title Acara</label>
                 <input type="text" class="form-control" wire:model='titleAcara'
                     placeholder="Undangan / Ngunduh Mantu Dll">
             </div>
             <div class="d-flex justify-content-end">
                 <button class="btn btn-primary btn-sm" {{ $button ? '' : 'disabled' }}>Update</button>
             </div>
         </div>
     </div>
 </form>
 <form wire:submit='update({{ $dataId }})'>
     <div class="row">
         <div class="col-12 col-lg-6">
             <div class="mb-3">
                 <label class="form-label">Title Undangan <span class="text-danger">*</span></label>
                 <div class="form-icon position-relative">
                     <input id="panggilan" name="panggilan" type="text" wire:model='title' class="form-control"
                         placeholder="Nama Panggilan :">
                 </div>
                 @error('panggilan')
                     <small class="text-danger">{{ $message }}</small>
                 @enderror
             </div>
         </div>
         <div class="col-12 col-lg-6">
             <div class="mb-3">
                 <label for="basic-url" class="form-label">Your vanity URL</label>
                 <div class="input-group ">
                     <span class="input-group-text" id="basic-addon3">{{ url('/u') }}/</span>
                     <input type="text" class="form-control" id="basic-url" wire:model.live='slug'
                         aria-describedby="basic-addon3 basic-addon4">
                 </div>
                 <div class="form-text text-danger">{{ $pesan }}</div>
             </div>
         </div>
         <div class="d-flex justify-content-end">
             <button class="btn btn-primary btn-sm" {{ $button ? '' : 'disabled' }}>Update</button>
         </div>
     </div>
 </form>
