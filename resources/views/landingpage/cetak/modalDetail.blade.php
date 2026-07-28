<div
    class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 p-4 sm:p-6 backdrop-blur-sm"
    role="dialog"
    aria-modal="true"
    aria-labelledby="cetak-modal-title"
    wire:keydown.escape.window="closeModal"
>
    <!-- Click backdrop to close -->
    <div class="absolute inset-0" wire:click="closeModal"></div>

    <div class="relative max-h-[90vh] w-full max-w-4xl overflow-hidden rounded-3xl border border-slate-200/80 bg-white shadow-2xl flex flex-col z-10">
        <!-- Header -->
        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-4">
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700 border border-rose-200/60">
                    <i class="fas fa-tag text-[10px] text-rose-500"></i> {{ $undang->jenis }}
                </span>
                <h2 id="cetak-modal-title" class="text-lg sm:text-xl font-bold text-slate-900 line-clamp-1">
                    {{ $undang->nama }}
                </h2>
            </div>
            <button
                type="button"
                wire:click="closeModal"
                class="flex h-9 w-9 items-center justify-center rounded-full text-slate-400 transition hover:bg-slate-100 hover:text-slate-600 focus:outline-none"
                aria-label="Tutup modal"
            >
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <!-- Scrollable Body -->
        <div class="overflow-y-auto p-6">
            <div class="grid gap-8 md:grid-cols-2 items-start">
                <!-- Gallery Section -->
                <div>
                    <div class="overflow-hidden rounded-2xl border border-slate-200/80 bg-stone-50/80 p-3 shadow-inner">
                        <img
                            src="{{ $mainImage }}"
                            alt="Preview {{ $undang->nama }}"
                            class="aspect-[4/3] w-full object-contain transition duration-300"
                            onerror="this.onerror=null; this.src='{{ asset('images/default-invitation.png') }}';"
                        >
                    </div>

                    @if (!empty($yes) && count($yes) > 1)
                        <div class="mt-4 flex gap-2.5 overflow-x-auto pb-1">
                            @foreach ($yes as $image)
                                <button
                                    type="button"
                                    wire:key="thumbnail-{{ $undang->id }}-{{ $loop->index }}"
                                    wire:click="updateMainImage('{{ $image }}')"
                                    class="shrink-0 overflow-hidden rounded-xl border bg-stone-50 p-1 transition {{ $mainImage === $image ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200/80 hover:border-rose-300' }}"
                                >
                                    <img
                                        src="{{ $image }}"
                                        alt="Thumbnail {{ $undang->nama }}"
                                        class="h-14 w-14 rounded-lg object-contain"
                                        onerror="this.onerror=null; this.src='{{ asset('images/default-invitation.png') }}';"
                                    >
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Detail Section -->
                <div class="flex flex-col h-full justify-between">
                    <div>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900">
                            {{ $undang->nama }}
                        </h3>

                        <div class="mt-3 flex flex-wrap items-baseline gap-2.5">
                            <span class="text-2xl font-extrabold text-slate-900">
                                Rp{{ number_format($undang->promo > 0 ? $undang->promo : $undang->harga, 0, ',', '.') }}
                            </span>
                            @if ($undang->promo > 0)
                                <del class="text-sm font-semibold text-rose-500 line-through">
                                    Rp{{ number_format($undang->harga, 0, ',', '.') }}
                                </del>
                            @endif
                        </div>

                        <!-- Description Box -->
                        @php
                            $plainDescription = trim(strip_tags($deskripsi ?? ''));
                        @endphp
                        <div class="mt-6 rounded-2xl border border-slate-200/80 bg-slate-50/60 p-4">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Deskripsi Produk</h4>
                            <div class="text-sm text-slate-600 leading-relaxed">
                                @if ($isExpanded)
                                    {!! $deskripsi !!}
                                @else
                                    {{ \Illuminate\Support\Str::limit($plainDescription, 160) }}
                                @endif
                            </div>

                            @if (\Illuminate\Support\Str::length($plainDescription) > 160)
                                @if ($isExpanded)
                                    <button
                                        type="button"
                                        wire:click="collapseDescription"
                                        class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-700"
                                    >
                                        Lihat lebih sedikit <i class="fas fa-chevron-up text-[10px]"></i>
                                    </button>
                                @else
                                    <button
                                        type="button"
                                        wire:click="expandDescription"
                                        class="mt-3 inline-flex items-center gap-1 text-xs font-semibold text-rose-600 hover:text-rose-700"
                                    >
                                        Lihat lebih banyak <i class="fas fa-chevron-down text-[10px]"></i>
                                    </button>
                                @endif
                            @endif
                        </div>

                        <!-- Highlights -->
                        <div class="mt-5 flex flex-wrap gap-4 text-xs font-medium text-slate-500">
                            <span class="inline-flex items-center gap-1.5"><i class="fas fa-check-circle text-emerald-500"></i> Cetak Presisi</span>
                            <span class="inline-flex items-center gap-1.5"><i class="fas fa-check-circle text-emerald-500"></i> Bebas Konsultasi</span>
                            <span class="inline-flex items-center gap-1.5"><i class="fas fa-check-circle text-emerald-500"></i> Kertas Premium</span>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    @php
                        $rawPhone = preg_replace('/[^0-9]/', '', config('services.contact.whatsapp', '6282274677715'));
                        $waUrl = 'https://wa.me/' . $rawPhone . '?text=' . urlencode('Saya Pesan Undangan ' . $undang->nama);
                    @endphp
                    <div class="mt-8 grid gap-3 sm:grid-cols-2">
                        <a
                            href="{{ $waUrl }}"
                            target="_blank"
                            rel="noopener"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl bg-emerald-600 px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 active:bg-emerald-800"
                        >
                            <i class="fab fa-whatsapp text-base"></i> Pesan via WhatsApp
                        </a>
                        <button
                            type="button"
                            wire:click="closeModal"
                            class="inline-flex h-11 items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                        >
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
