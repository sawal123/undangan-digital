<div>
    <!-- Page Title -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Dashboard Demo</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Selamat datang kembali. Berikut ringkasan aktivitas hari ini (Versi Livewire).</p>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-ui.card icon="users" title="24,521" iconColor="indigo">
            <div class="flex items-center justify-between mt-auto">
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Pengguna</p>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-full">+12.5%</span>
            </div>
        </x-ui.card>

        <x-ui.card icon="dollar-sign" title="Rp 142,5M" iconColor="emerald">
            <div class="flex items-center justify-between mt-auto">
                <p class="text-sm text-slate-500 dark:text-slate-400">Total Pendapatan</p>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-full">+8.2%</span>
            </div>
        </x-ui.card>

        <x-ui.card icon="shopping-cart" title="1,842" iconColor="amber">
            <div class="flex items-center justify-between mt-auto">
                <p class="text-sm text-slate-500 dark:text-slate-400">Pesanan Aktif</p>
                <span class="text-xs font-medium text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-900/30 px-2 py-1 rounded-full">-3.1%</span>
            </div>
        </x-ui.card>

        <x-ui.card icon="trending-up" title="3.24%" iconColor="rose">
            <div class="flex items-center justify-between mt-auto">
                <p class="text-sm text-slate-500 dark:text-slate-400">Tingkat Konversi</p>
                <span class="text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/30 px-2 py-1 rounded-full">+5.7%</span>
            </div>
        </x-ui.card>
    </div>

    <!-- Filter Bar -->
    <x-ui.card padding="p-4" class="mb-6">
        <div class="flex flex-wrap items-end gap-3">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase">Pencarian</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input wire:model.live="search" type="text" placeholder="Cari nama atau email..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 placeholder-slate-400 dark:placeholder-slate-500 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200">
                </div>
            </div>
            <x-ui.button variant="secondary" icon="rotate-ccw" wire:click="$set('search', '')">
                Reset
            </x-ui.button>
            <x-ui.button variant="primary" icon="plus" x-on:click="$dispatch('open-modal', { name: 'add-user' })">
                Tambah Data
            </x-ui.button>
        </div>
    </x-ui.card>

    <!-- Table Section -->
    <x-ui.table 
        :headers="['#', 'Nama', 'Email', 'Role', 'Status', 'Tanggal', 'Aksi']"
        title="Daftar Pengguna"
        subtitle="Data ini di-handle oleh Livewire component"
        :count="$totalCount"
    >
        @foreach($users as $index => $user)
            <tr class="table-row-hover transition-colors">
                <td class="px-5 py-3.5 text-slate-500 dark:text-slate-400 font-medium text-xs">{{ $index + 1 }}</td>
                <td class="px-5 py-3.5 font-medium text-slate-800 dark:text-slate-200 whitespace-nowrap">{{ $user['name'] }}</td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 whitespace-nowrap">{{ $user['email'] }}</td>
                <td class="px-5 py-3.5">
                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium {{ $user['role'] === 'Admin' ? 'bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400' : 'bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400' }}">
                        {{ $user['role'] }}
                    </span>
                </td>
                <td class="px-5 py-3.5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border {{ $user['status'] === 'Aktif' ? 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 border-emerald-200 dark:border-emerald-700' : 'bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400 border-rose-200 dark:border-rose-700' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $user['status'] === 'Aktif' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                        {{ $user['status'] }}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 whitespace-nowrap text-xs">{{ $user['date'] }}</td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center justify-center gap-1">
                        <button class="p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 transition-colors">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </button>
                        <button class="p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition-colors" x-on:click="$dispatch('open-modal', { name: 'delete-user' })">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
        
        @if(empty($users))
            <tr>
                <td colspan="7" class="text-center py-12">
                    <div class="w-16 h-16 bg-slate-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="search-x" class="w-7 h-7 text-slate-400"></i>
                    </div>
                    <p class="text-slate-600 dark:text-slate-300 font-medium">Tidak ada data ditemukan</p>
                </td>
            </tr>
        @endif

        <x-slot name="pagination">
            <div class="flex items-center justify-between">
                <p class="text-xs text-slate-500 dark:text-slate-400">Menampilkan 1-5 dari {{ $totalCount }} data</p>
                <!-- Simplified pagination for demo -->
                <div class="flex gap-1">
                    <x-ui.button variant="secondary" size="sm" icon="chevron-left" disabled></x-ui.button>
                    <x-ui.button variant="primary" size="sm">1</x-ui.button>
                    <x-ui.button variant="secondary" size="sm" icon="chevron-right" disabled></x-ui.button>
                </div>
            </div>
        </x-slot>
    </x-ui.table>

    <!-- Modals -->
    <x-ui.modal name="add-user" title="Tambah Pengguna Baru" icon="user-plus">
        <form class="space-y-4">
            <x-ui.input label="Nama Lengkap" placeholder="Masukkan nama..." />
            <x-ui.input label="Alamat Email" type="email" placeholder="email@example.com" />
            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'add-user' })">Batal</x-ui.button>
                <x-ui.button variant="primary">Simpan Data</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <x-ui.modal name="delete-user" title="Konfirmasi Hapus" icon="alert-triangle">
        <p>Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'delete-user' })">Batal</x-ui.button>
            <x-ui.button variant="danger">Ya, Hapus</x-ui.button>
        </div>
    </x-ui.modal>
</div>
