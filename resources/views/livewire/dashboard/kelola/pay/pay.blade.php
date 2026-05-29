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
                        <button class="btn btn-secondary" wire:loading.attr="disabled" wire:target="redeem">
                            <span wire:loading.remove wire:target="redeem">Redeem</span>
                            <span wire:loading wire:target="redeem">Memproses...</span>
                        </button>
                    </div>
                    @if (session()->has('message'))
                        <div class="form-text" id="basic-addon4">{{ session('message') }}</div>
                    @endif
                </form>
                <button class="w-100 btn btn-primary mt-3" wire:click="checkOut" wire:loading.attr="disabled" wire:target="checkOut">
                    <span wire:loading.remove wire:target="checkOut">Continue to checkout</span>
                    <span wire:loading wire:target="checkOut">Memproses...</span>
                </button>
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
                <div class="card rounded shadow p-4 border-0">
                    <h4 class="mb-3 ">Payment Otomatis</h4>
                    @include('livewire.dashboard.kelola.pay.gateway')
                    <hr>
                    <h4 class="mb-3 ">Payment Manual</h4>
                    @include('livewire.dashboard.kelola.pay.gatewayManual')
                </div>
            </div>
        </div><!--end col-->
    </div><!--end row-->

</div>
