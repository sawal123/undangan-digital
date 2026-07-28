<div x-data="{ deleteId: null, deleteMethod: 'delete' }" @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kelola User</h2>
        <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Daftar pengguna beserta hak akses (role) yang terdaftar di sistem.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700 flex items-center gap-2">
            <i data-lucide="check-circle" class="w-5 h-5 flex-shrink-0"></i>
            <span class="text-sm font-medium">{{ session('message') }}</span>
        </div>
    @endif

    <x-ui.card padding="p-4" class="mb-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="relative flex-1 max-w-md">
                <x-ui.input wire:model.live="search" placeholder="Cari nama, email, atau WA..." icon="search" />
            </div>
            <x-ui.button variant="primary" icon="user-plus" wire:click="create" loadingTarget="create" loadingText="Memuat...">
                Tambah User
            </x-ui.button>
        </div>
    </x-ui.card>

    <x-ui.table 
        :headers="['No.', 'Nama', 'Email', 'Role', 'WhatsApp', 'Status', 'Login Terakhir', 'IP', 'Gagal 24j', 'Risk', 'Dibuat', 'Aksi']"
        title="Daftar Pengguna"
        :count="$users->total()"
        loadingTarget="search,gotoPage,nextPage,previousPage"
    >
        @foreach($users as $index => $item)
            <tr class="table-row-hover transition-colors">
                <td class="px-5 py-3.5 text-slate-500 dark:text-slate-400 font-medium text-xs">
                    {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                </td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white text-xs font-bold flex-shrink-0 ring-2 ring-indigo-200 dark:ring-indigo-800/50">
                            {{ strtoupper(substr($item->name, 0, 1)) }}
                        </div>
                        <span class="font-medium text-slate-800 dark:text-slate-200 truncate">{{ $item->name }}</span>
                    </div>
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 whitespace-nowrap text-sm">
                    {{ $item->email }}
                </td>
                <td class="px-5 py-3.5 whitespace-nowrap">
                    @php
                        $roleName = $item->getRoleNames()->first() ?? 'User';
                    @endphp
                    <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                        @if(strtolower($roleName) === 'owner' || strtolower($roleName) === 'admin' || strtolower($roleName) === 'superadmin')
                            bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400
                        @elseif(strtolower($roleName) === 'reseller')
                            bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400
                        @else
                            bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-400
                        @endif
                    ">
                        {{ ucfirst($roleName) }}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-sm">
                    {{ $item->phone ?? '-' }}
                </td>
                <td class="px-5 py-3.5 whitespace-nowrap text-xs">
                    <div class="flex flex-col gap-1">
                        <span class="font-medium {{ $item->hasVerifiedEmail() ? 'text-emerald-600' : 'text-amber-600' }}">
                            {{ $item->hasVerifiedEmail() ? 'Verified' : 'Belum Verified' }}
                        </span>
                        <span class="font-medium {{ $item->suspended_at ? 'text-rose-600' : 'text-slate-500' }}">
                            {{ $item->suspended_at ? 'Suspended' : 'Active' }}
                        </span>
                    </div>
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-xs whitespace-nowrap">
                    {{ $item->last_login_at ? \Illuminate\Support\Carbon::parse($item->last_login_at)->format('d M Y H:i') : '-' }}
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-xs whitespace-nowrap">
                    {{ $item->last_login_ip ?? '-' }}
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-xs text-center">
                    {{ $item->failed_logins_24h_count ?? 0 }}
                </td>
                <td class="px-5 py-3.5 text-xs whitespace-nowrap">
                    <span class="font-medium {{ in_array($item->security_risk_level, ['high', 'critical']) ? 'text-rose-600' : 'text-slate-500' }}">
                        {{ ucfirst($item->security_risk_level ?? 'low') }}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-xs whitespace-nowrap">
                    {{ $item->created_at?->format('d M Y') ?? '-' }}
                </td>
                <td class="px-5 py-3.5 text-center flex-shrink-0">
                    <div class="flex items-center justify-center gap-1">
                        <button wire:click="edit({{ $item->id }})" wire:loading.attr="disabled" wire:target="edit({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 transition-colors disabled:opacity-50" title="Edit User">
                            <span wire:loading.remove wire:target="edit({{ $item->id }})"><i data-lucide="pencil" class="w-4 h-4"></i></span>
                            <span wire:loading wire:target="edit({{ $item->id }})"><x-loading-spinner class="w-4 h-4" /></span>
                        </button>
                        @if($item->suspended_at)
                            <button wire:click="reactivate({{ $item->id }})" wire:loading.attr="disabled" wire:target="reactivate({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-emerald-50 dark:hover:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 transition-colors disabled:opacity-50" title="Aktifkan Akun">
                                <span wire:loading.remove wire:target="reactivate({{ $item->id }})"><i data-lucide="user-check" class="w-4 h-4"></i></span>
                                <span wire:loading wire:target="reactivate({{ $item->id }})"><x-loading-spinner class="w-4 h-4" /></span>
                            </button>
                        @else
                            <button wire:click="suspend({{ $item->id }}, 'admin_review')" wire:loading.attr="disabled" wire:target="suspend({{ $item->id }}, 'admin_review')" class="p-1.5 rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/30 text-amber-600 dark:text-amber-400 transition-colors disabled:opacity-50" title="Suspend Akun">
                                <span wire:loading.remove wire:target="suspend({{ $item->id }}, 'admin_review')"><i data-lucide="user-x" class="w-4 h-4"></i></span>
                                <span wire:loading wire:target="suspend({{ $item->id }}, 'admin_review')"><x-loading-spinner class="w-4 h-4" /></span>
                            </button>
                        @endif
                        <button wire:click="revokeSessions({{ $item->id }}, 'admin_review')" wire:loading.attr="disabled" wire:target="revokeSessions({{ $item->id }}, 'admin_review')" class="p-1.5 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-400 transition-colors disabled:opacity-50" title="Cabut Semua Sesi">
                            <span wire:loading.remove wire:target="revokeSessions({{ $item->id }}, 'admin_review')"><i data-lucide="log-out" class="w-4 h-4"></i></span>
                            <span wire:loading wire:target="revokeSessions({{ $item->id }}, 'admin_review')"><x-loading-spinner class="w-4 h-4" /></span>
                        </button>
                        <button wire:click="resendVerification({{ $item->id }})" wire:loading.attr="disabled" wire:target="resendVerification({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/30 text-blue-600 dark:text-blue-400 transition-colors disabled:opacity-50" title="Kirim Verifikasi">
                            <span wire:loading.remove wire:target="resendVerification({{ $item->id }})"><i data-lucide="mail" class="w-4 h-4"></i></span>
                            <span wire:loading wire:target="resendVerification({{ $item->id }})"><x-loading-spinner class="w-4 h-4" /></span>
                        </button>
                        <button wire:click="forcePasswordReset({{ $item->id }})" wire:loading.attr="disabled" wire:target="forcePasswordReset({{ $item->id }})" class="p-1.5 rounded-lg hover:bg-violet-50 dark:hover:bg-violet-900/30 text-violet-600 dark:text-violet-400 transition-colors disabled:opacity-50" title="Paksa Reset Password">
                            <span wire:loading.remove wire:target="forcePasswordReset({{ $item->id }})"><i data-lucide="key-round" class="w-4 h-4"></i></span>
                            <span wire:loading wire:target="forcePasswordReset({{ $item->id }})"><x-loading-spinner class="w-4 h-4" /></span>
                        </button>
                        <button x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })" class="p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition-colors" title="Hapus User">
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

    <x-ui.modal name="user-modal" title="{{ $isEdit ? 'Update User' : 'Tambah User Baru' }}" icon="{{ $isEdit ? 'user-check' : 'user-plus' }}">
        <form wire:submit="store" class="space-y-4">
            <div>
                <x-ui.input label="Nama Lengkap" wire:model="name" icon="user" placeholder="Masukkan nama lengkap..." />
                @error('name') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-ui.input label="Alamat Email" wire:model="email" type="email" icon="mail" placeholder="email@example.com" />
                @error('email') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-ui.input label="Nomor WhatsApp" wire:model="phone" icon="phone" placeholder="08123456789" />
                @error('phone') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-ui.select label="Role (Hak Akses)" wire:model="role" icon="shield">
                    <option value="">-- Pilih Role --</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                    @endforeach
                </x-ui.select>
                @error('role') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>
            <div>
                <x-ui.input label="Password {{ $isEdit ? '(Opsional)' : '' }}" wire:model="password" type="password" icon="lock" placeholder="{{ $isEdit ? 'Kosongkan jika tidak ingin diubah' : 'Minimal 6 karakter' }}" />
                @error('password') <span class="text-xs text-rose-500 mt-1 block font-medium">{{ $message }}</span> @enderror
            </div>
            
            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button" x-on:click="$dispatch('close-modal', { name: 'user-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" loadingTarget="store" :loadingText="$isEdit ? 'Memperbarui...' : 'Menyimpan...'">{{ $isEdit ? 'Update Data' : 'Simpan User' }}</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus" icon="alert-triangle">
        <p class="text-sm text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin menghapus data pengguna ini? Tindakan ini tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary" x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">Batal</x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none" loadingTarget="delete" loadingText="Menghapus..." x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">Ya, Hapus</x-ui.button>
        </div>
    </x-ui.modal>
</div>
