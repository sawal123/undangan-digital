<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola User</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar pengguna yang terdaftar di sistem.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700">
            {{ session('message') }}
        </div>
    @endif

    <x-ui.card padding="p-4" class="mb-6">
        <div class="relative max-w-md">
            <x-ui.input wire:model.live="search" placeholder="Cari nama, email, atau WA..." icon="search" />
        </div>
    </x-ui.card>

    <x-ui.table 
        :headers="['No.', 'Nama', 'Email', 'WhatsApp', 'Aksi']"
        title="Daftar Pengguna"
        :count="$users->total()"
    >
        @foreach($users as $index => $item)
            <tr class="table-row-hover transition-colors">
                <td class="px-5 py-3.5 text-slate-500 dark:text-slate-400 font-medium text-xs">
                    {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                </td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                            {{ strtoupper(substr($item->name, 0, 1)) }}
                        </div>
                        <span class="font-medium text-slate-800 dark:text-slate-200">{{ $item->name }}</span>
                    </div>
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 whitespace-nowrap">
                    {{ $item->email }}
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400">
                    {{ $item->phone ?? '-' }}
                </td>
                <td class="px-5 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button wire:click="edit({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach

        <x-slot name="pagination">
            {{ $users->links('vendor.livewire.tailwind') }}
        </x-slot>
    </x-ui.table>

    <x-ui.modal name="user-modal" title="Update User" icon="user">
        <form wire:submit="update" class="space-y-4">
            <x-ui.input label="Nama" wire:model="name" />
            <x-ui.input label="Email" wire:model="email" type="email" />
            <x-ui.input label="WhatsApp" wire:model="phone" />
            
            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'user-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit">Update User</x-ui.button>
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
