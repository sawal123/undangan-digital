<button onclick="toggleModal()" type="button" aria-label="Buka informasi kado"
    class="darkpre-float-control darkpre-float-control--gift fixed lg:absolute top-28 right-2 z-50 h-14 w-14 rounded-full text-2xl lg:right-5">
    <i class="fa-solid fa-wallet" aria-hidden="true"></i>
</button>

<div id="infoModal" class="invisible fixed inset-0 flex items-center justify-center font-poppins">
    <div class="w-full max-w-sm rounded-2xl p-6 text-center">
        <h2 class="mb-4 text-lg font-bold text-stone-800">Kado</h2>
        <p class="mb-4 text-sm text-stone-600">
            Berikut adalah informasi untuk mengirimkan kado atau hadiah secara online.
        </p>

        @forelse ($data->kado as $kado)
            <div class="relative mb-6 border-b border-stone-300 pb-5 text-sm text-stone-700 last:border-0">
                @if ($kado->giftPay?->icon)
                    <img src="{{ asset('storage/' . $kado->giftPay->icon) }}" alt="{{ $kado->namaPay }}"
                        class="mx-auto mb-3 h-auto w-32">
                @endif
                <strong class="block">{{ $kado->namaPay }}</strong>
                <span class="nomor-rekening mt-1 block">{{ $kado->nomorPay }}</span>
                <button onclick="salinTeks(this)" type="button"
                    class="mt-3 rounded-lg bg-stone-800 px-3 py-1 text-xs text-white transition hover:bg-stone-700">
                    Salin nomor
                </button>

                @if ($kado->qris)
                    <div class="mt-5 border-t border-stone-200 pt-4">
                        <strong class="mb-2 block">Kasih hadiah dengan QRIS</strong>
                        <img src="{{ asset('storage/' . $kado->qris) }}" alt="QRIS {{ $kado->namaPay }}"
                            class="mx-auto w-40">
                    </div>
                @endif
            </div>
        @empty
            <p class="text-sm text-stone-600">Informasi kado belum tersedia.</p>
        @endforelse

        <button class="rounded-full bg-stone-800 px-5 py-2 text-sm text-white transition hover:bg-stone-700"
            onclick="toggleModal()" type="button">
            Tutup
        </button>
    </div>
</div>

<script>
    function salinTeks(button) {
        const nomorRekening = button.closest('.relative').querySelector('.nomor-rekening')?.textContent.trim();
        if (!nomorRekening || !navigator.clipboard) return;

        navigator.clipboard.writeText(nomorRekening).then(() => {
            button.textContent = 'Tersalin';
            setTimeout(() => button.textContent = 'Salin nomor', 1600);
        });
    }
</script>
