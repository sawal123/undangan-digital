<div class="space-y-4">
    {{-- Nama --}}
    <div>
        <label for="nama" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
            Nama <span class="text-rose-500">*</span>
        </label>
        <input type="text" id="nama" wire:model="nama"
            class="w-full px-3 py-2 rounded-lg border text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors
                   @error('nama') border-rose-400 bg-rose-50 dark:bg-rose-900/10 @else border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 @enderror
                   text-slate-800 dark:text-slate-200"
            placeholder="Nama lengkap">
        @error('nama')
            <p class="text-xs text-rose-500 mt-1 flex items-center gap-1"><i data-lucide="alert-circle"
                    class="w-3.5 h-3.5"></i> {{ $message }}</p>
        @enderror
    </div>

    {{-- Email --}}
    <div>
        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
            Email <span class="text-rose-500">*</span>
        </label>
        <input type="email" id="email" wire:model="email"
            class="w-full px-3 py-2 rounded-lg border text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors
                   @error('email') border-rose-400 bg-rose-50 dark:bg-rose-900/10 @else border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 @enderror
                   text-slate-800 dark:text-slate-200"
            placeholder="contoh@email.com">
        @error('email')
            <p class="text-xs text-rose-500 mt-1 flex items-center gap-1"><i data-lucide="alert-circle"
                    class="w-3.5 h-3.5"></i> {{ $message }}</p>
        @enderror
    </div>

    {{-- WhatsApp --}}
    <div>
        <label for="wa" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5">
            WhatsApp <span class="text-rose-500">*</span>
        </label>
        <input type="tel" id="wa" wire:model="wa"
            class="w-full px-3 py-2 rounded-lg border text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors
                   @error('wa') border-rose-400 bg-rose-50 dark:bg-rose-900/10 @else border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 @enderror
                   text-slate-800 dark:text-slate-200"
            placeholder="0812xxxxxxxx">
        @error('wa')
            <p class="text-xs text-rose-500 mt-1 flex items-center gap-1"><i data-lucide="alert-circle"
                    class="w-3.5 h-3.5"></i> {{ $message }}</p>
        @enderror
    </div>
</div>
