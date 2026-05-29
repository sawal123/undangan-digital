<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Riwayat Transaksi</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Monitoring pembayaran dan aktivasi paket undangan.</p>
    </div>

    @if (session('message'))
        <div class="mb-4 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300">
            {{ session('message') }}
        </div>
    @endif

    <x-ui.card padding="p-4" class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div class="relative w-full max-w-md">
                <x-ui.input wire:model.live="search" placeholder="Cari status atau tipe pembayaran..." icon="search" />
            </div>
            <x-ui.button variant="primary" type="button" icon="plus" wire:click="openCreate">
                Tambah Transaksi
            </x-ui.button>
        </div>
    </x-ui.card>

    <x-ui.table 
        :headers="['No. Order', 'Produk', 'Total', 'Metode', 'Status', 'Aksi']"
        title="Daftar Transaksi"
        :count="$transactions->total()"
    >
        @foreach($transactions as $t)
            <tr class="table-row-hover transition-colors">
                <td class="px-5 py-3.5 text-xs font-mono font-bold text-slate-500">
                    #{{ $t->transaction_id ?? $t->id }}
                </td>
                <td class="px-5 py-3.5">
                    <p class="text-sm font-medium text-slate-800 dark:text-white">{{ $t->data->title ?? 'Paket Undangan' }}</p>
                    <p class="text-[10px] text-slate-500">{{ $t->created_at->format('d M Y, H:i') }}</p>
                </td>
                <td class="px-5 py-3.5 text-sm font-bold">
                    Rp {{ number_format($t->gross_amount, 0, ',', '.') }}
                </td>
                <td class="px-5 py-3.5">
                    <span class="text-xs uppercase text-slate-500">{{ $t->payment_type }}</span>
                </td>
                <td class="px-5 py-3.5">
                    @php
                        $statusClasses = [
                            'SUCCESS' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-700',
                            'SETTLEMENT' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-700',
                            'PENDING' => 'bg-amber-50 text-amber-700 border-amber-200 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-700',
                            'CANCEL' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-700',
                            'FAILED' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-900/30 dark:text-rose-400 dark:border-rose-700',
                            'EXPIRED' => 'bg-slate-50 text-slate-700 border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700',
                        ];
                        $class = $statusClasses[$t->payment_status] ?? $statusClasses['EXPIRED'];
                    @endphp
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold border {{ $class }}">
                        {{ $t->payment_status }}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button wire:click="edit({{ $t->id }})" class="p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button x-on:click="$dispatch('set-delete', { id: {{ $t->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach

        <x-slot name="pagination">
            {{ $transactions->links('vendor.livewire.tailwind') }}
        </x-slot>
    </x-ui.table>

    <x-ui.modal name="create-transaksi-modal" title="Tambah Transaksi" icon="plus" maxWidth="lg">
        <form wire:submit="create" class="space-y-4">
            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">User</label>
                <select wire:model.live="createUserId" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="">Pilih user</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                    @endforeach
                </select>
                @error('createUserId')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Produk</label>
                <div class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 text-sm">
                    {{ $selectedData?->title ?? 'Pilih user terlebih dahulu' }}
                </div>
                @error('createDataId')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Total</label>
                <input type="number" min="0" step="1" wire:model="createTotal" placeholder="Contoh: 150000" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                @error('createTotal')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="w-full">
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Metode Pembayaran</label>
                    <select wire:model="createPaymentType" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="cash">Cash / Manual</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="qris">QRIS</option>
                        <option value="gopay">Gopay</option>
                        @foreach ($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->bank }}{{ $method->category ? ' - ' . $method->category : '' }}</option>
                        @endforeach
                    </select>
                    @error('createPaymentType')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="w-full">
                    <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Status Pembayaran</label>
                    <select wire:model="createPaymentStatus" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="PENDING">PENDING</option>
                        <option value="SUCCESS">SUCCESS</option>
                        <option value="CANCEL">CANCEL</option>
                        <option value="FAILED">FAILED</option>
                        <option value="EXPIRED">EXPIRED</option>
                    </select>
                    @error('createPaymentStatus')
                        <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-700 rounded-xl">
                <p class="text-xs text-indigo-700 dark:text-indigo-400 flex gap-2">
                    <i data-lucide="info" class="w-4 h-4 flex-shrink-0"></i>
                    <span>Status <b>SUCCESS</b> akan otomatis mengaktifkan produk dari user yang dipilih.</span>
                </p>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'create-transaksi-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit">Simpan Transaksi</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <x-ui.modal name="transaksi-modal" title="Update Status Transaksi" icon="credit-card">
        <form wire:submit="update" class="space-y-4">
            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Status Pembayaran</label>
                <select wire:model="statusTrans" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="PENDING">PENDING</option>
                    <option value="SUCCESS">SUCCESS</option>
                    <option value="CANCEL">CANCEL</option>
                    <option value="FAILED">FAILED</option>
                    <option value="EXPIRED">EXPIRED</option>
                </select>
            </div>
            <div class="w-full">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Metode Pembayaran</label>
                <select wire:model="typeTrans" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                    <option value="cash">Cash / Manual</option>
                    <option value="bank_transfer">Bank Transfer</option>
                    <option value="qris">QRIS</option>
                    <option value="gopay">Gopay</option>
                </select>
            </div>
            <div class="p-4 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-200 dark:border-indigo-700 rounded-xl">
                <p class="text-xs text-indigo-700 dark:text-indigo-400 flex gap-2">
                    <i data-lucide="info" class="w-4 h-4 flex-shrink-0"></i>
                    <span>Status <b>SUCCESS</b> akan otomatis mengaktifkan undangan terkait.</span>
                </p>
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'transaksi-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit">Update Transaksi</x-ui.button>
            </div>
        </form>
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
