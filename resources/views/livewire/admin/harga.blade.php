<div>
    @if (session()->has('message'))
        <div class="alert bg-soft-primary fw-medium">
            <i class="mdi mdi-check-circle"></i> {{ session('message') }}
        </div>
    @endif
    @include('livewire.admin.harga.harga')
    @include('livewire.admin.harga.promo')
    <hr>
    

</div>
