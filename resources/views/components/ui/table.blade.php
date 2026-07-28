@props([
    'headers' => [],
    'title' => null,
    'subtitle' => null,
    'count' => null,
    'loadingTarget' => null,
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden relative']) }}>
    @if($loadingTarget)
        <div
            wire:loading.flex
            wire:target="{{ $loadingTarget }}"
            class="absolute inset-0 z-20 items-center justify-center bg-white/70 dark:bg-slate-900/70 backdrop-blur-[1px] transition-all"
        >
            <div class="flex items-center gap-2.5 px-4 py-2.5 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-200 font-medium text-sm">
                <x-loading-spinner class="w-5 h-5 text-indigo-600 dark:text-indigo-400" text="Memuat data..." />
            </div>
        </div>
    @endif

    @if($title || $count)
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-200 dark:border-slate-700">
            <div>
                @if($title)
                    <h3 class="text-base font-semibold text-slate-800 dark:text-white">{{ $title }}</h3>
                @endif
                @if($subtitle)
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">{{ $subtitle }}</p>
                @endif
            </div>
            @if($count !== null)
                <span class="text-xs text-slate-400 dark:text-slate-500 bg-slate-100 dark:bg-slate-700 px-2.5 py-1 rounded-full">
                    {{ $count }} data
                </span>
            @endif
        </div>
    @endif

    <div
        class="overflow-x-auto"
        @if($loadingTarget)
            wire:loading.class="opacity-50 pointer-events-none"
            wire:target="{{ $loadingTarget }}"
        @endif
    >
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-700/50 text-left">
                    @foreach($headers as $header)
                        <th class="px-5 py-3 text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider whitespace-nowrap">
                            {{ $header }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if(isset($pagination))
        <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
            {{ $pagination }}
        </div>
    @endif
</div>
