@props(['name', 'title', 'icon' => 'info', 'maxWidth' => 'md'])

<div x-data="{ show: false }" x-on:open-modal.window="if ($event.detail.name === '{{ $name }}') show = true"
    x-on:close-modal.window="if ($event.detail.name === '{{ $name }}') show = false">
    <template x-teleport="body">
        <div x-show="show" x-on:keydown.escape.window="show = false"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all duration-300"
            style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            <!-- Modal Backdrop -->
            <div class="absolute inset-0" x-on:click="show = false"></div>

            <!-- Modal Card -->
            <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl w-full max-w-{{ $maxWidth }} max-h-[85vh] flex flex-col relative z-10 border border-slate-200 dark:border-slate-700 overflow-hidden"
                x-transition:enter="transition ease-out duration-300 transform"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0">
                <!-- Modal Header (sticky) -->
                <div class="px-6 pt-6 pb-3 flex-shrink-0">
                    <button x-on:click="show = false"
                        class="absolute top-4 right-4 p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 transition-colors z-10">
                        <i data-lucide="x" class="w-5 h-5"></i>
                    </button>

                    <h3 class="text-xl font-bold text-slate-800 dark:text-white flex items-center gap-3 pr-10">
                        <div
                            class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center flex-shrink-0">
                            <i data-lucide="{{ $icon }}"
                                class="w-5 h-5 text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        {{ $title }}
                    </h3>
                </div>

                <!-- Modal Body (scrollable) -->
                <div class="px-6 pb-6 overflow-y-auto flex-1 ui-modal-content text-slate-600 dark:text-slate-300">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </template>
</div>
