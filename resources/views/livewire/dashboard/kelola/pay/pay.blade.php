<div>
    <div class="row flex-row-reverse">
        <div class="col-md-5 col-lg-4  mt-4">
            <div class="card rounded shadow p-4 border-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="h5 mb-0">Rincian Nominal</span>
                </div>
                @include('livewire.dashboard.kelola.pay.rincian')
                <form wire:submit.prevent='redeem'>
                    <div class="input-group">
                        <input type="text" class="form-control" wire:model='code' placeholder="Promo code">
                        <button t class="btn btn-secondary">Redeem</button>
                    </div>
                    @if (session()->has('message'))
                        <div class="form-text" id="basic-addon4">{{ session('message') }}</div>
                    @endif
                </form>
                <button class="w-100 btn btn-primary mt-3" wire:click='checkOut'>Continue to checkout</button>
            </div>
        </div><!--end col-->

        <div class="col-md-7 col-lg-8 mt-4">
            <div class="card rounded shadow p-4 border-0">
                <h4 class="mb-3">Informasi Pembelian</h4>

                @include('livewire.dashboard.kelola.pay.pembeli')
                <style>
                    .rad:hover {
                        background-color: rgb(243, 243, 243);
                        border: 1px black solid !important
                    }
                </style>
                <h4 class="mb-3 mt-4 pt-4 border-top">Payment</h4>
                @include('livewire.dashboard.kelola.pay.gateway')
                
            </div>
        </div><!--end col-->
    </div><!--end row-->

</div>
