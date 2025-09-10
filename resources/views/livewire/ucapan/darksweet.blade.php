<div>
    <div class="w-full pt-5 bg-zinc-800 h-auto" id="absen">
        <hr class="my-3" data-aos="fade-up" data-aos-duration="3000">
        <h1 class="text-white text-center text-3xl mb-3 font-bold" data-aos="fade-up" data-aos-duration="3000">
            Kehadiran
        </h1>

        @if ($success)
            <div class="mt-2 p-3 mx-3 bg-green-500 border border-green-700 text-white rounded-lg">
                Ucapan berhasil dikirim 🎉
            </div>
        @endif

        @if ($error)
            <div class="mt-2 p-3 mx-3 bg-red-500 border border-red-700 text-white rounded-lg">
                Terjadi kesalahan, coba lagi 🙏
            </div>
        @endif

        @if ($publicIsActive)
            <form wire:submit.prevent="save" class="mt-5 p-5 space-y-4">
                <!-- Input Nama -->
                <div class="space-y-2">
                    <label for="nama" class="block text-white font-medium text-sm">Nama</label>
                    <input type="text" id="nama" wire:model="nama"
                        class="w-full p-3 bg-zinc-800 text-white border border-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                        placeholder="Nama Anda">
                    @error('nama')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Ucapan -->
                <div class="space-y-2">
                    <label for="ucapan" class="block text-white font-medium text-sm">Ucapan</label>
                    <textarea id="ucapan" wire:model="ucapan" rows="5"
                        class="w-full p-3 bg-zinc-800 text-white border border-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                        placeholder="Tulis Ucapan dan Doa"></textarea>
                    @error('ucapan')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilihan Kehadiran -->
                <div class="space-y-2">
                    <label for="status" class="block text-white font-medium text-sm">Konfirmasi Kehadiran</label>
                    <select id="status" wire:model="status"
                        class="w-full p-3 bg-zinc-800 text-white border border-white rounded-md focus:outline-none focus:ring-2 focus:ring-white">
                        <option selected disabled>Pilih status kehadiran</option>
                        <option value="Datang Dong">Datang Dong</option>
                        <option value="Ga bisa Datang Nih">Ga bisa Datang Nih</option>
                        <option value="Diusahakan Datang Ya">Diusahakan Datang Ya</option>
                    </select>
                    @error('status')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-white text-zinc-800 font-bold py-2 px-4 rounded-md hover:bg-gray-200 transition">
                    Kirim Ucapan
                </button>
            </form>
        @endif
        <style>
            .overflow-y-auto {
                max-height: 300px;
                overflow-y: auto;
                -ms-overflow-style: none;
                /* IE & Edge */
                scrollbar-width: none;
                /* Firefox */
            }
        </style>
        <!-- List Ucapan -->
        <div class="w-full px-3 bg-zinc-800 pt-5 pb-10">
            @if ($viewIsActive)
                <div class="max-h-64 overflow-y-auto bg-gray-100 p-3 rounded-lg" tabindex="0">
                    @foreach ($listUcapan as $item)
                        <div class="mb-3 p-4 bg-white shadow-md rounded-lg">
                            <div class="flex items-center gap-2">
                                <strong class="text-gray-800">{{ $item->tamu->nama }}</strong>
                                <span class="px-2 py-1 text-sm text-white rounded" style="background: gray">
                                    {{ ucwords(str_replace('_', ' ', $item->status)) }}
                                </span>
                            </div>
                            <p class="text-pink-700 text-sm mt-1">
                                <small>{{ date('l', strtotime($item->created_at)) }},
                                    {{ date('d m Y', strtotime($item->created_at)) }}</small>
                            </p>
                            <p class="text-gray-700 mt-2">{{ $item->ucapan }}</p>
                            @if ($item->balas)
                                <hr class="my-2">
                                <p class="bg-gray-200 p-2 rounded border text-gray-800">Balasan: {{ $item->balas }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</div>
