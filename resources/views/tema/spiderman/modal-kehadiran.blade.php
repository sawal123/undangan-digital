@php
    $fiturUcapan = $data->FiturUcapan;
    $ucapanIsActive = $fiturUcapan?->isActive ?? true;
    $ucapanPublicIsActive = $fiturUcapan?->publicIsActive ?? true;
    $ucapanViewIsActive = $fiturUcapan?->viewIsActive ?? true;
@endphp

@if ($ucapanIsActive)
    <div id="ModalRspv"
        class="{{ $errors->any() || session()->has('message') || session()->has('error') ? '' : 'invisible' }} fixed inset-0 flex items-center justify-center font-poppins overflow-hidden"
        style="z-index: 9999; padding: 16px; background-color: rgba(0, 0, 0, 0.76);">
        <div class="relative w-full max-w-[390px] max-h-[88dvh] overflow-hidden rounded-2xl border-4 text-white shadow-2xl"
            style="padding: 8px; border-color: #ff2d3f; background: linear-gradient(180deg, #7f0713 0%, #b51020 46%, #5b020b 100%); box-shadow: 0 24px 60px rgba(0, 0, 0, 0.65);">
            <div class="relative z-10 flex max-h-[88dvh] flex-col">
                <div class="px-5 pt-6 pb-4 text-center">
                    <h2 class="font-audiowide text-[23px] leading-tight text-[#FFC300] drop-shadow-[0_2px_0_rgba(0,0,0,0.65)]">Ucapan & Kehadiran</h2>
                    <p class="mt-2 text-[12px] normal-case text-white/90">Kirim doa terbaik untuk acara ini.</p>
                </div>

                <div class="flex-1 overflow-y-auto px-5 pb-5">
                    @if (session()->has('message'))
                        <div class="mb-4 rounded-xl border border-emerald-400 bg-emerald-500/20 px-3 py-2 text-[12px] text-emerald-100">
                            {{ session('message') }}
                        </div>
                    @endif

                    @if (session()->has('error'))
                        <div class="mb-4 rounded-xl border border-red-400 bg-red-500/20 px-3 py-2 text-[12px] text-red-100">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($ucapanViewIsActive)
                        <div class="mb-5">
                            <h3 class="mb-3 font-audiowide text-[16px] text-white">Daftar Ucapan</h3>
                            <div class="max-h-[170px] space-y-3 overflow-y-auto pr-1">
                                @forelse ($ucapan as $item)
                                    <div class="rounded-xl border-2 border-[#ffdd63] bg-[#FFC300] p-3 text-black shadow-md shadow-black/30">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <h4 class="text-[12px] font-bold">{{ $item->tamu?->nama ?? 'Tamu' }}</h4>
                                                <p class="text-[10px] opacity-70">{{ $item->created_at?->format('d/m/Y H:i') }}</p>
                                            </div>
                                            <span class="shrink-0 rounded-full bg-black px-2 py-1 text-[9px] font-bold text-[#FFC300]">
                                                {{ $item->status }}
                                            </span>
                                        </div>
                                        <p class="mt-2 text-[11px] italic normal-case">"{{ $item->ucapan }}"</p>
                                        @if ($item->balas)
                                            <p class="mt-2 rounded-lg bg-black/10 p-2 text-[10px] normal-case">
                                                Balasan: {{ $item->balas }}
                                            </p>
                                        @endif
                                    </div>
                                @empty
                                    <div class="rounded-xl border border-white/20 bg-white/10 p-4 text-center text-[12px] normal-case text-white/80">
                                        Belum ada ucapan. Jadilah yang pertama.
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    @endif

                    @if ($ucapanPublicIsActive || $kode)
                        <form id="spidermanWishForm" action="{{ route('savedoa') }}" method="post" class="space-y-3">
                            @csrf
                            <input type="hidden" name="dataId" value="{{ $data->id }}">
                            @if ($kode)
                                <input type="hidden" name="kode" value="{{ $kode }}">
                                <input type="hidden" name="nama" value="{{ $tamu }}">
                                <div class="rounded-xl border border-white/25 bg-black/25 px-4 py-3">
                                    <p class="text-[10px] uppercase tracking-widest text-white/60">Nama Tamu</p>
                                    <p class="text-[13px] font-bold">{{ $tamu }}</p>
                                </div>
                            @else
                                <input type="text" name="nama" value="{{ old('nama') }}" placeholder="Nama Lengkap"
                                    class="w-full rounded-xl border-2 border-[#ff7580] bg-[#FFC300] px-4 py-3 text-[13px] text-black placeholder-black/60 outline-none focus:border-white focus:ring-2 focus:ring-white" required>
                                @error('nama')
                                    <div class="text-[11px] text-red-200">{{ $message }}</div>
                                @enderror
                            @endif

                            <select name="status"
                                class="w-full rounded-xl border-2 border-[#ff7580] bg-[#FFC300] px-4 py-3 text-[13px] font-semibold text-black outline-none focus:border-white focus:ring-2 focus:ring-white" required>
                                <option value="">Konfirmasi Kehadiran</option>
                                <option value="Hadir" @selected(old('status') === 'Hadir')>Hadir</option>
                                <option value="Tidak Hadir" @selected(old('status') === 'Tidak Hadir')>Tidak Hadir</option>
                                <option value="Akan Hadir" @selected(old('status') === 'Akan Hadir')>Akan Hadir</option>
                            </select>
                            @error('status')
                                <div class="text-[11px] text-red-200">{{ $message }}</div>
                            @enderror

                            <textarea name="ucapan" placeholder="Tulis ucapan dan doa..." rows="4"
                                class="w-full resize-none rounded-xl border-2 border-[#ff7580] bg-[#FFC300] px-4 py-3 text-[13px] normal-case text-black placeholder-black/60 outline-none focus:border-white focus:ring-2 focus:ring-white" required>{{ old('ucapan') }}</textarea>
                            @error('ucapan')
                                <div class="text-[11px] text-red-200">{{ $message }}</div>
                            @enderror

                            <button type="submit"
                                class="mt-2 flex w-full items-center justify-center rounded-full border-2 border-white bg-[#FFC300] px-5 text-[14px] font-extrabold text-black shadow-lg transition hover:bg-yellow-300 focus:outline-none focus:ring-2 focus:ring-white disabled:cursor-not-allowed disabled:opacity-70"
                                style="padding-top: 14px; padding-bottom: 14px; box-shadow: 0 10px 24px rgba(0, 0, 0, 0.38);">
                                <span class="submit-label">Kirim Ucapan</span>
                                <span class="loading-label hidden">Mengirim...</span>
                            </button>
                        </form>
                    @else
                        <div class="rounded-xl border border-white/20 bg-white/10 p-4 text-center text-[12px] normal-case text-white/80">
                            Form ucapan hanya tersedia untuk tamu yang menerima tautan undangan.
                        </div>
                    @endif
                </div>

                <div class="border-t border-white/15 px-5 py-4"
                    style="background-color: rgba(0, 0, 0, 0.28);">
                    <button type="button"
                        class="w-full rounded-full px-4 text-[13px] font-bold transition"
                        style="display: block; padding-top: 12px; padding-bottom: 12px; background-color: #ffffff; color: #9f0714; border: 2px solid #FFC300; box-shadow: 0 8px 18px rgba(0, 0, 0, 0.32);"
                        onclick="toggleModalRspv()">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endif
