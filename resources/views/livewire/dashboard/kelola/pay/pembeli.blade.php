<div class="mb-3">
    <label for="text" class="form-label">Nama <span class="text-danger">*</span></label>
    <input type="text" class="form-control" wire:model='nama' id="text" placeholder="Hilgers">
    <div class="invalid-feedback">
        Please enter a valid text address for shipping updates.
    </div>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
    <input type="email" class="form-control" wire:model='email' id="email"
        placeholder="you@example.com">
    <div class="invalid-feedback">
        Please enter a valid email address for shipping updates.
    </div>
</div>
<div class="mb-3">
    <label for="number" class="form-label">WhatsApp <span class="text-danger">*</span></label>
    <input type="number" class="form-control" wire:model='wa' id="number"
        placeholder="08327467****">
    <div class="invalid-feedback">
        Please enter a valid number address for shipping updates.
    </div>
</div>