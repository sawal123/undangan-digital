<div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Kolom Kiri: Rincian & Checkout --}}
        <div class="lg:col-span-1 lg:order-2">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Rincian Pembayaran</h3>

                @include('livewire.dashboard.kelola.pay.rincian')

                {{-- Promo Code --}}
                <form wire:submit.prevent="redeem" class="mt-4">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">Kode Promo</label>
                    <div class="flex gap-2">
                        <input type="text" wire:model="code" placeholder="Masukkan kode..."
                            class="flex-1 px-3 py-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                        <button type="submit" wire:loading.attr="disabled" wire:target="redeem"
                            class="px-4 py-2 bg-slate-600 hover:bg-slate-700 text-white text-sm font-medium rounded-lg transition-colors disabled:opacity-50">
                            <span wire:loading.remove wire:target="redeem">Redeem</span>
                            <span wire:loading wire:target="redeem">
                                <svg class="animate-spin w-4 h-4 inline" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4" />
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                                </svg>
                            </span>
                        </button>
                    </div>
                    @if (session()->has('message'))
                        <p class="text-xs text-rose-500 mt-1.5">{{ session('message') }}</p>
                    @endif
                </form>

                {{-- Checkout Error --}}
                @error('paymentGatewayId')
                    <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
                @enderror
                @error('nama')
                    <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
                @enderror
                @error('email')
                    <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
                @enderror
                @error('wa')
                    <p class="text-xs text-rose-500 mt-2">{{ $message }}</p>
                @enderror

                {{-- Checkout Button --}}
                <button wire:click="checkOut" wire:loading.attr="disabled" wire:target="checkOut"
                    class="w-full mt-4 px-4 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-colors disabled:opacity-50 flex items-center justify-center gap-2">
                    <i data-lucide="credit-card" class="w-5 h-5" wire:loading.remove wire:target="checkOut"></i>
                    <svg wire:loading wire:target="checkOut" class="animate-spin w-5 h-5" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                    </svg>
                    <span wire:loading.remove wire:target="checkOut">Lanjutkan Pembayaran</span>
                    <span wire:loading wire:target="checkOut">Memproses...</span>
                </button>
            </div>
        </div>

        {{-- Kolom Kanan: Form & Metode Pembayaran --}}
        <div class="lg:col-span-2 lg:order-1 space-y-6">
            {{-- Informasi Pembeli --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">Informasi Pembeli</h3>
                @include('livewire.dashboard.kelola.pay.pembeli')
            </div>

            {{-- Metode Pembayaran --}}
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">
                    <i data-lucide="zap" class="w-5 h-5 inline-block text-amber-500"></i>
                    Pembayaran Otomatis
                </h3>
                @include('livewire.dashboard.kelola.pay.gateway')

                <hr class="my-6 border-slate-200 dark:border-slate-700">

                <h3 class="text-lg font-semibold text-slate-800 dark:text-white mb-4">
                    <i data-lucide="banknote" class="w-5 h-5 inline-block text-emerald-500"></i>
                    Pembayaran Manual
                </h3>
                @include('livewire.dashboard.kelola.pay.gatewayManual')
            </div>
        </div>
    </div>
</div>
