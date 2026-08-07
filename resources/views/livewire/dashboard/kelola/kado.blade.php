<div class="space-y-6" x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
        <div>
            <h3 class="text-xl font-black text-slate-800 dark:text-white">Kirim Kado & Angpao</h3>
            <p class="text-sm text-slate-500 dark:text-slate-400">Mudahkan tamu untuk mengirimkan kado atau angpao digital secara aman.</p>
        </div>
        
        <div class="flex items-center gap-4 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Aktifkan Fitur:</span>
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" wire:click="switch('{{ $dataId }}', {{ $fitur && $fitur->isActive ? 'false' : 'true' }})" class="sr-only peer" {{ $fitur && $fitur->isActive ? 'checked' : '' }}>
                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600"></div>
            </label>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3" role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form Section -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm sticky top-24">
                <h4 class="font-bold text-slate-800 dark:text-white mb-6 flex items-center gap-2">
                    <i data-lucide="plus-circle" class="w-5 h-5 text-indigo-500"></i>
                    Tambah Metode Bayar
                </h4>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Pilih Bank / E-Wallet</label>
                        <select wire:model.defer="giftId" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                            <option value="">-- Pilih --</option>
                            @foreach($giftPay as $pay)
                                <option value="{{ $pay->id }}">{{ $pay->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Atas Nama (A/N)</label>
                        <input type="text" wire:model.defer="namaPay" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Nomor Rekening / HP</label>
                        <input type="text" wire:model.defer="nomorPay" placeholder="0812xxxx atau 1234xxxx" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Upload QRIS (Opsional)</label>
                        <input type="file" wire:model="qris" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                        @if ($qris)
                            <div class="mt-2 w-20 h-20 rounded-lg overflow-hidden border">
                                <img src="{{ $qris->temporaryUrl() }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                    </div>
                    <button wire:click="save" wire:loading.attr="disabled" wire:target="save" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                        <i wire:loading.remove wire:target="save" data-lucide="save" class="w-4 h-4"></i>
                        <i wire:loading wire:target="save" data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                        <span wire:loading.remove wire:target="save">Simpan Metode</span>
                        <span wire:loading.flex wire:target="save" class="hidden">Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- List Section -->
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($kado as $item)
                <div class="bg-white dark:bg-slate-900 p-5 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm relative group overflow-hidden">
                    <div class="absolute top-0 right-0 p-3 flex gap-2">
                        <button x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-1.5 bg-rose-50 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 rounded-lg hover:bg-rose-100 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-900 flex items-center justify-center border border-slate-100 dark:border-slate-800">
                            <i data-lucide="credit-card" class="w-6 h-6 text-slate-400"></i>
                        </div>
                        <div class="min-w-0 pr-8">
                            <h5 class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $item->giftPay->nama ?? 'Bank' }}</h5>
                            <p class="text-lg font-black text-slate-800 dark:text-white mt-1">{{ $item->nomorPay }}</p>
                            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 truncate">A/N: {{ $item->namaPay }}</p>
                        </div>
                    </div>

                    @if($item->qris)
                        <div class="mt-4 pt-4 border-t border-slate-50 dark:border-slate-700 flex items-center justify-between">
                            <span class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-1 rounded-md uppercase">QRIS Tersedia</span>
                            <button wire:click="barcodePreview({{ $item->id }})" class="text-[10px] font-bold text-indigo-600 hover:underline">Lihat QRIS</button>
                        </div>
                    @endif
                </div>
            @empty
                <div class="col-span-full py-20 flex flex-col items-center justify-center text-slate-500 dark:text-slate-400 bg-white dark:bg-slate-900 rounded-3xl border-2 border-dashed border-slate-200 dark:border-slate-800">
                    <i data-lucide="gift" class="w-12 h-12 mb-4 opacity-20"></i>
                    <p class="font-medium">Belum ada metode pembayaran kado.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- QRIS Preview Modal -->
    <x-ui.modal name="preview-modal" title="QRIS Preview" icon="scan-line">
        <div class="p-4 flex justify-center bg-white rounded-xl mb-6">
            @if($barcode)
                <img src="{{ asset('storage/'.$barcode) }}" class="w-full max-w-[200px] aspect-square object-contain">
            @else
                <div class="w-[200px] h-[200px] bg-slate-100 flex items-center justify-center text-slate-400 rounded-xl">
                    <i data-lucide="image" class="w-10 h-10"></i>
                </div>
            @endif
        </div>
        <div class="flex justify-end">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'preview-modal' })">Tutup</x-ui.button>
        </div>
    </x-ui.modal>

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus" icon="alert-triangle">
        <p class="text-sm text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">Batal</x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none" x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">Ya, Hapus</x-ui.button>
        </div>
    </x-ui.modal>
</div>

 
 < s c r i p t > 
         d o c u m e n t . a d d E v e n t L i s t e n e r ( ' l i v e w i r e : u p d a t e d ' ,   ( )   = >   { 
                 i f   ( t y p e o f   l u c i d e   ! = =   ' u n d e f i n e d ' )   { 
                         l u c i d e . c r e a t e I c o n s ( ) ; 
                 } 
         } ) ; 
 < / s c r i p t >  
 