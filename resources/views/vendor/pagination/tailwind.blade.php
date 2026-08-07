@if ($paginator->hasPages())
    <div
        class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-8 pt-6 border-t border-slate-200 dark:border-slate-800">
        {{-- Mobile: Text Info --}}
        <div class="text-xs font-medium text-slate-600 dark:text-slate-400 text-center sm:text-left">
            Menampilkan <span class="font-bold text-slate-800 dark:text-slate-200">{{ $paginator->firstItem() }}</span>
            hingga <span class="font-bold text-slate-800 dark:text-slate-200">{{ $paginator->lastItem() }}</span>
            dari <span class="font-bold text-slate-800 dark:text-slate-200">{{ $paginator->total() }}</span> hasil
        </div>

        {{-- Pagination Links --}}
        <div class="flex items-center gap-2 flex-wrap justify-center">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button disabled
                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-slate-400 dark:text-slate-600 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg cursor-not-allowed opacity-60">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span class="hidden sm:inline">Sebelumnya</span>
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="flex items-center gap-1">
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span
                            class="inline-flex items-center justify-center px-2 py-2 text-sm font-medium text-slate-600 dark:text-slate-400">
                            {{ $element }}
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <button
                                    class="inline-flex items-center justify-center w-9 h-9 text-sm font-bold text-white bg-indigo-600 border border-indigo-600 rounded-lg cursor-default transition-colors">
                                    {{ $page }}
                                </button>
                            @else
                                <a href="{{ $url }}"
                                    class="inline-flex items-center justify-center w-9 h-9 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-200 dark:hover:border-indigo-800 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="hidden sm:inline">Selanjutnya</span>
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            @else
                <button disabled
                    class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-slate-400 dark:text-slate-600 bg-slate-100 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg cursor-not-allowed opacity-60">
                    <span class="hidden sm:inline">Selanjutnya</span>
                    <svg class="w-4 h-4 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            @endif
        </div>
    </div>
@endif
