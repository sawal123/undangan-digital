<div>
    @if (session()->has('message'))
        <div class="alert bg-soft-primary fw-medium">
            <i class="mdi mdi-check-circle"></i> {{ session('message') }}
        </div>
    @endif
    @include('livewire.admin.harga.harga')
    @include('livewire.admin.harga.promo')
    <hr>
    <h6><strong>Transaksi</strong></h6>
    <style>
        .responsive-input {
            width: 100%;
            /* Full width by default */
            max-width: none;
            /* Remove default max-width */
        }

        @media (min-width: 992px) {

            /* For devices larger than 992px (Desktop) */
            .responsive-input {
                max-width: 300px;
                /* Restrict width on desktop */
                width: 100%;
                /* Maintain responsive layout */
            }
        }
    </style>
    @include('livewire.admin.harga.transaksi')
</div>
</div>
