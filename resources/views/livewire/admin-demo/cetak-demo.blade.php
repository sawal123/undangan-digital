<div x-data="{ deleteId: null, deleteMethod: 'delete' }"
    @set-delete.window="deleteId = $event.detail.id; deleteMethod = $event.detail.method || 'delete'">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Undangan Cetak</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Kelola stok dan harga undangan fisik/cetak.</p>
        </div>
        <div class="flex gap-2">
            <x-ui.button variant="secondary" icon="tag"
                x-on:click="$dispatch('open-modal', { name: 'category-modal' })">
                Kategori
            </x-ui.button>
            <x-ui.button variant="primary" icon="plus" wire:click="resetInput" loadingTarget="resetInput"
                loadingText="Memuat...">
                Tambah Produk
            </x-ui.button>
        </div>
    </div>

    @if (session()->has('message'))
        <div
            class="mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400 rounded-xl border border-emerald-200 dark:border-emerald-700">
            {{ session('message') }}
        </div>
    @endif

    <x-ui.card padding="p-4" class="mb-6">
        <div class="flex flex-wrap gap-4 items-center justify-between">
            <div class="relative max-w-md w-full">
                <x-ui.input wire:model.live="search" placeholder="Cari nama produk atau jenis..." icon="search" />
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500">Tampilkan:</span>
                <select wire:model.live="perPage"
                    class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm">
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </div>
        </div>
    </x-ui.card>

    <x-ui.table :headers="['Produk', 'Jenis', 'Stok', 'Terjual', 'Harga Jual', 'Harga Modal', 'Ukuran OPP', 'Aksi']" title="Daftar Produk Cetak" :count="$undangan->total()"
        loadingTarget="search,perPage,gotoPage,nextPage,previousPage">
        @foreach ($undangan as $item)
            <tr class="table-row-hover transition-colors">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        @php $imgs = is_array($item->gambar) ? $item->gambar : (json_decode($item->gambar, true) ?: []); @endphp
                        @if (!empty($imgs))
                            <img src="{{ Storage::url($imgs[0]) }}" class="w-12 h-12 rounded-lg object-cover shadow-sm"
                                alt="{{ $item->nama }}">
                        @else
                            <div
                                class="w-12 h-12 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                                <i data-lucide="image" class="w-6 h-6 text-slate-400"></i>
                            </div>
                        @endif
                        <div>
                            <p class="font-bold text-slate-800 dark:text-white">{{ $item->nama }}</p>
                            <p class="text-xs text-slate-500 line-clamp-1">
                                {{ \Illuminate\Support\Str::limit(html_entity_decode(strip_tags($item->deskripsi ?? ''), ENT_QUOTES | ENT_HTML5, 'UTF-8'), 80) }}
                            </p>
                        </div>
                    </div>
                </td>
                <td class="px-5 py-3.5">
                    <span
                        class="px-2 py-1 bg-indigo-50 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-400 rounded-md text-xs font-medium">
                        {{ $item->jenis }}
                    </span>
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-sm">
                    {{ $item->stok }} pcs
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-sm text-center">
                    {{ $item->terjual ?? 0 }}
                </td>
                <td class="px-5 py-3.5">
                    <p class="text-sm font-bold text-slate-800 dark:text-white">Rp
                        {{ number_format($item->harga, 0, ',', '.') }}</p>
                    @if ($item->promo)
                        <p class="text-[10px] text-rose-500 line-through">Rp
                            {{ number_format($item->promo, 0, ',', '.') }}</p>
                    @endif
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-sm">
                    Rp {{ number_format($item->harga_modal ?? 0, 0, ',', '.') }}
                </td>
                <td class="px-5 py-3.5 text-slate-600 dark:text-slate-400 text-sm">
                    {{ $item->ukuran_opp ?? '-' }}
                </td>
                <td class="px-5 py-3.5 text-center">
                    <div class="flex items-center justify-center gap-1">
                        <button wire:click="edit({{ $item->id }})" wire:loading.attr="disabled"
                            wire:target="edit({{ $item->id }})"
                            class="p-1.5 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 transition-colors disabled:opacity-50">
                            <span wire:loading.remove wire:target="edit({{ $item->id }})">
                                <i data-lucide="pencil" class="w-4 h-4"></i>
                            </span>
                            <span wire:loading wire:target="edit({{ $item->id }})">
                                <x-loading-spinner class="w-4 h-4" />
                            </span>
                        </button>
                        <button
                            x-on:click="$dispatch('set-delete', { id: {{ $item->id }}, method: 'delete' }); $dispatch('open-modal', { name: 'delete-modal' })"
                            class="p-1.5 rounded-lg hover:bg-rose-50 dark:hover:bg-rose-900/30 text-rose-600 dark:text-rose-400 transition-colors">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach

        <x-slot name="pagination">
            {{ $undangan->links('vendor.livewire.tailwind') }}
        </x-slot>
    </x-ui.table>

    <!-- Modal Produk -->
    <x-ui.modal name="cetak-modal" :title="$isEdit ? 'Edit Produk' : 'Tambah Produk'" icon="package">
        <form wire:submit="{{ $isEdit ? 'update' : 'store' }}" class="space-y-4">
            <x-ui.input label="Nama Produk" wire:model="nama" placeholder="Contoh: Softcover Kraft" />

            <div class="grid grid-cols-2 gap-4">
                <div class="w-full">
                    <label
                        class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Jenis</label>
                    <select wire:model="jenis"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        <option value="">Pilih Jenis</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->jenis }}">{{ $cat->jenis }}</option>
                        @endforeach
                    </select>
                    @error('jenis')
                        <span class="text-xs text-rose-500 mt-1">{{ $message }}</span>
                    @enderror
                </div>
                <x-ui.input label="Stok" wire:model="stok" type="number" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-ui.input label="Harga Jual" wire:model="harga" type="number" placeholder="1500" />
                <x-ui.input label="Harga Modal" wire:model="harga_modal" type="number" placeholder="1000" />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <x-ui.input label="Ukuran OPP" wire:model="ukuran_opp" placeholder="Contoh: 13 x 20 cm" />
                <x-ui.input label="Harga Promo (Opsional)" wire:model="promo" type="number" />
            </div>

            <div class="w-full">
                <label
                    class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Deskripsi</label>
                <div wire:ignore wire:key="cetak-deskripsi-editor" class="cetak-description-editor"
                    x-data="cetakDeskripsiEditor()" x-init="init()">
                    <textarea x-ref="textarea" rows="3"></textarea>
                </div>
                @error('deskripsi')
                    <span class="text-xs text-rose-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="w-full">
                <label
                    class="block text-xs font-semibold text-slate-600 dark:text-slate-400 mb-1.5 uppercase tracking-wider">Upload
                    Gambar</label>
                <input type="file" wire:model="thumbnails" multiple
                    class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <div wire:loading wire:target="thumbnails" class="text-xs text-indigo-500 mt-1">Uploading...</div>
            </div>

            <div class="flex justify-end gap-2 mt-6">
                <x-ui.button variant="secondary" type="button"
                    x-on:click="$dispatch('close-modal', { name: 'cetak-modal' })">Batal</x-ui.button>
                <x-ui.button variant="primary" type="submit" :loadingTarget="$isEdit ? 'update' : 'store'"
                    :loadingText="$isEdit ? 'Memperbarui...' : 'Menyimpan...'">{{ $isEdit ? 'Update' : 'Simpan' }}</x-ui.button>
            </div>
        </form>
    </x-ui.modal>

    <!-- Modal Kategori -->
    <x-ui.modal name="category-modal" title="Kelola Kategori" icon="tag">
        <form wire:submit="createCategory" class="flex gap-2 mb-4">
            <x-ui.input wire:model="jenisUndangan" placeholder="Nama kategori baru..." class="flex-1" />
            <x-ui.button variant="primary" type="submit" loadingTarget="createCategory"
                loadingText="Menyimpan...">Tambah</x-ui.button>
        </form>

        <div class="mt-4 border-t border-slate-100 dark:border-slate-700 pt-4">
            <h4 class="text-sm font-semibold text-slate-700 dark:text-slate-300 mb-3">Daftar Kategori:</h4>
            <div class="flex flex-wrap gap-2">
                @foreach ($categories as $cat)
                    <span
                        class="inline-flex items-center gap-1 px-3 py-1 bg-slate-100 dark:bg-slate-800 rounded-full text-xs text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                        {{ $cat->jenis }}
                    </span>
                @endforeach
            </div>
        </div>
    </x-ui.modal>

    <!-- Global Delete Confirmation Modal -->
    <x-ui.modal name="delete-modal" title="Konfirmasi Hapus" icon="alert-triangle">
        <p class="text-sm text-slate-600 dark:text-slate-400">Apakah Anda yakin ingin menghapus data ini? Tindakan ini
            tidak dapat dibatalkan.</p>
        <div class="flex justify-end gap-2 mt-6">
            <x-ui.button variant="secondary"
                x-on:click="$dispatch('close-modal', { name: 'delete-modal' })">Batal</x-ui.button>
            <x-ui.button variant="primary" class="bg-rose-600 hover:bg-rose-700 text-white border-none"
                loadingTarget="delete" loadingText="Menghapus..."
                x-on:click="$wire.call(deleteMethod, deleteId); $dispatch('close-modal', { name: 'delete-modal' })">Ya,
                Hapus</x-ui.button>
        </div>
    </x-ui.modal>

    <script>
        function cetakDeskripsiEditor() {
            return {
                editor: null,
                init() {
                    const self = this;
                    const textarea = this.$refs.textarea;

                    const loadScript = (callback) => {
                        if (window.ClassicEditor) {
                            callback();
                            return;
                        }
                        let script = document.getElementById('ckeditor-cdn-script');
                        if (!script) {
                            script = document.createElement('script');
                            script.id = 'ckeditor-cdn-script';
                            script.src = 'https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js';
                            document.head.appendChild(script);
                        }
                        if (window.ClassicEditor) {
                            callback();
                        } else {
                            script.addEventListener('load', callback, {
                                once: true
                            });
                        }
                    };

                    const createEditor = () => {
                        if (self.editor) {
                            // Already exists, just sync content from Livewire
                            const desc = @this.get('deskripsi');
                            self.editor.setData(desc || '');
                            return;
                        }

                        loadScript(() => {
                            // Guard against double-init
                            if (self.editor || textarea._ckeditorInstance || textarea._ckeditorInitializing) {
                                if (textarea._ckeditorInstance) {
                                    self.editor = textarea._ckeditorInstance;
                                    self.editor.setData(@this.get('deskripsi') || '');
                                }
                                return;
                            }

                            textarea._ckeditorInitializing = true;
                            ClassicEditor.create(textarea).then((editor) => {
                                self.editor = editor;
                                textarea._ckeditorInstance = editor;
                                textarea._ckeditorInitializing = false;

                                editor.model.document.on('change:data', () => {
                                    @this.set('deskripsi', editor.getData());
                                });

                                const desc = @this.get('deskripsi');
                                editor.setData(desc || '');
                            }).catch((error) => {
                                textarea._ckeditorInitializing = false;
                                console.error('CKEditor error:', error);
                            });
                        });
                    };

                    const destroyEditor = () => {
                        if (self.editor) {
                            try {
                                self.editor.destroy();
                            } catch (e) {
                                // Editor might already be destroyed
                            }
                            self.editor = null;
                            if (textarea) {
                                textarea._ckeditorInstance = null;
                                textarea._ckeditorInitializing = false;
                            }
                        }
                    };

                    // Create editor when modal opens
                    window.addEventListener('open-modal', (e) => {
                        if (e.detail?.name === 'cetak-modal') {
                            createEditor();
                        }
                    });

                    // Destroy editor when modal closes
                    window.addEventListener('close-modal', (e) => {
                        if (e.detail?.name === 'cetak-modal') {
                            destroyEditor();
                        }
                    });
                },
            };
        }
    </script>

    <style>
        .dark .cetak-description-editor .ck.ck-toolbar,
        .dark .cetak-description-editor .ck.ck-editor__main>.ck-editor__editable {
            background: #0f172a;
            border-color: #475569;
            color: #e2e8f0;
        }

        .dark .cetak-description-editor .ck.ck-toolbar .ck-button,
        .dark .cetak-description-editor .ck.ck-toolbar .ck-button .ck-button__label,
        .dark .cetak-description-editor .ck.ck-toolbar .ck-icon,
        .dark .cetak-description-editor .ck.ck-editor__main>.ck-editor__editable {
            color: #e2e8f0;
        }

        .dark .cetak-description-editor .ck.ck-toolbar .ck-button:hover,
        .dark .cetak-description-editor .ck.ck-toolbar .ck-button.ck-on {
            background: #334155;
        }

        .dark .cetak-description-editor .ck.ck-toolbar,
        .dark .cetak-description-editor .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: #334155;
        }
    </style>
</div>
