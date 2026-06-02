<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 px-4 py-6 backdrop-blur-sm"
    role="dialog" aria-modal="true" aria-labelledby="cetak-modal-title"
    wire:keydown.escape.window="closeModal">
    <div class="absolute inset-0" wire:click="closeModal"></div>

    <div class="relative max-h-[92vh] w-full max-w-5xl overflow-hidden rounded-2xl border border-rose-100 bg-white shadow-2xl">
        <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 md:px-6">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.18em] text-rose-500">Detail Undangan</p>
                <h2 id="cetak-modal-title" class="mt-1 text-xl font-bold text-slate-900">{{ $undang->nama }}</h2>
            </div>
            <button type="button" wire:click="closeModal"
                class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-500 transition hover:border-rose-200 hover:bg-rose-50 hover:text-rose-600"
                aria-label="Tutup modal">
                <i class="fas fa-xmark"></i>
            </button>
        </div>

        <div class="max-h-[calc(92vh-73px)] overflow-y-auto p-5 md:p-6">
            <div class="grid gap-8 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.1fr)]">
                <div>
                    <div class="overflow-hidden rounded-2xl border border-rose-100 bg-[#fff5f0] shadow-sm">
                        <img src="{{ asset('storage/' . $mainImage) }}" alt="Preview {{ $undang->nama }}"
                            class="aspect-[4/3] w-full object-cover">
                    </div>

                    @if (!empty($yes))
                        <div class="mt-4 flex gap-3 overflow-x-auto pb-2">
                            @foreach ($yes as $image)
                                <button type="button" wire:key="thumbnail-{{ $image }}"
                                    wire:click="updateMainImage('{{ $image }}')"
                                    class="shrink-0 overflow-hidden rounded-xl border bg-white p-1 transition {{ $mainImage === $image ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200 hover:border-rose-300' }}">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail {{ $undang->nama }}"
                                        class="h-20 w-20 rounded-lg object-cover">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="flex flex-col">
                    @php
                        $plainDescription = strip_tags($deskripsi ?? '');
                    @endphp

                    <div class="mb-4 inline-flex w-fit items-center gap-2 rounded-full bg-rose-50 px-3 py-1 text-xs font-semibold text-rose-700">
                        <i class="fas fa-tag"></i> {{ $undang->jenis }}
                    </div>

                    <h3 class="font-display text-3xl font-bold leading-tight text-slate-900">{{ $undang->nama }}</h3>

                    <div class="mt-4 flex flex-wrap items-end gap-3">
                        <span class="text-2xl font-bold text-slate-900">
                            Rp{{ number_format($undang->promo > 0 ? $undang->promo : $undang->harga, 0, ',', '.') }}
                        </span>
                        @if ($undang->promo > 0)
                            <del class="text-base text-rose-500">Rp{{ number_format($undang->harga, 0, ',', '.') }}</del>
                        @endif
                    </div>

                    <div class="mt-6 rounded-2xl border border-slate-100 bg-slate-50 p-4">
                        <h4 class="mb-2 font-semibold text-slate-900">Deskripsi</h4>
                        <div class="prose prose-sm max-w-none text-slate-600">
                            @if ($isExpanded)
                                {!! $deskripsi !!}
                            @else
                                {!! \Illuminate\Support\Str::limit($plainDescription, 160) !!}
                            @endif
                        </div>

                        @if (strlen($plainDescription) > 160)
                            @if ($isExpanded)
                                <button type="button" wire:click="toggleDownDescription({{ $undang->id }})"
                                    class="mt-3 text-sm font-semibold text-rose-600 hover:text-rose-700">
                                    Lihat lebih sedikit
                                </button>
                            @else
                                <button type="button" wire:click="toggleDescription({{ $undang->id }})"
                                    class="mt-3 text-sm font-semibold text-rose-600 hover:text-rose-700">
                                    Lihat lebih banyak
                                </button>
                            @endif
                        @endif
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2">
                        <a href="https://wa.me/6282274677715?text=Saya+Pesan+Undangan+{{ rawurlencode($undang->nama) }}"
                            target="_blank" rel="noopener"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-rose-500 px-5 py-3 text-sm font-semibold text-white shadow-md shadow-rose-500/20 transition hover:bg-rose-600">
                            <i class="fab fa-whatsapp"></i> Pesan Sekarang
                        </a>
                        <button type="button" wire:click="closeModal"
                            class="inline-flex items-center justify-center gap-2 rounded-full border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Tutup
                        </button>
                    </div>

                    <div class="mt-5 flex flex-wrap gap-3 text-sm text-slate-500">
                        <span class="inline-flex items-center gap-2"><i class="fas fa-check-circle text-rose-500"></i> Detail jelas</span>
                        <span class="inline-flex items-center gap-2"><i class="fas fa-check-circle text-rose-500"></i> Bisa konsultasi</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
