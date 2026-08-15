<div class="space-y-6 max-w-3xl">
    <!-- Header Section -->
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-2xl bg-rose-50 dark:bg-rose-900/30 flex items-center justify-center text-rose-600 dark:text-rose-400">
                    <i data-lucide="video" class="w-7 h-7"></i>
                </div>
                <div>
                    <h3 class="text-xl font-black text-slate-800 dark:text-white">Live Streaming</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Bagikan link siaran langsung acara pernikahan
                        Anda.</p>
                </div>
            </div>

            <div
                class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-800">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Aktifkan:</span>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" wire:click="updateFiturStreaming({{ $fiturStreaming ? 'false' : 'true' }})"
                        class="sr-only peer" {{ $fiturStreaming ? 'checked' : '' }}>
                    <div
                        class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-rose-600">
                    </div>
                </label>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 text-sm text-emerald-800 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center gap-3"
            role="alert">
            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-500"></i>
            {{ session('message') }}
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-900 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="space-y-6">
            <div>
                <label
                    class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Link
                    Streaming (YouTube, Zoom, dll.)</label>
                <div class="relative">
                    <i data-lucide="link" class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400"></i>
                    <input type="text" wire:model.defer="link" placeholder="https://youtube.com/live/..."
                        class="w-full pl-12 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl text-sm focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                </div>
                <p class="mt-2 text-[10px] text-slate-400">Pastikan link dapat diakses secara publik atau oleh tamu yang
                    memiliki link tersebut.</p>
            </div>

            <div class="flex justify-end">
                <button wire:click="save" wire:loading.attr="disabled" wire:target="save"
                    class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200 dark:shadow-none flex items-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                    <i wire:loading.remove wire:target="save" data-lucide="save" class="w-4 h-4"></i>
                    <i wire:loading wire:target="save" data-lucide="loader-2" class="w-4 h-4 animate-spin"></i>
                    <span wire:loading.remove wire:target="save">Simpan Link</span>
                    <span wire:loading.flex wire:target="save" class="hidden">Menyimpan...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div
        class="bg-amber-50 dark:bg-amber-900/20 p-6 rounded-3xl border border-amber-100 dark:border-amber-800 flex gap-4">
        <div
            class="w-10 h-10 rounded-xl bg-amber-100 dark:bg-amber-800 flex items-center justify-center text-amber-600 dark:text-amber-400 flex-shrink-0">
            <i data-lucide="info" class="w-6 h-6"></i>
        </div>
        <div class="space-y-1">
            <h5 class="text-sm font-bold text-amber-800 dark:text-amber-300">Tips Streaming</h5>
            <p class="text-xs text-amber-700 dark:text-amber-400 leading-relaxed">
                Anda dapat menggunakan YouTube Live, Zoom, atau Google Meet. Jika menggunakan YouTube, pastikan Anda
                telah mengaktifkan fitur Live Streaming 24 jam sebelum hari-H.
            </p>
        </div>
    </div>
</div>
