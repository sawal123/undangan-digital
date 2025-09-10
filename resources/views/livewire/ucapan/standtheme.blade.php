<div>
    <div class="comment mt-10 pb-10 text-[12px] md:text-base bg-[#D7CEBE] flex flex-col items-center">
        <p class="text-center text-4xl title pt-10 text-[#755f4B]">
            Berikan Ucapan
        </p>

        @if ($success)
            <div class="mt-2 p-3 mx-3 bg-green-500 text-white rounded-lg">Ucapan berhasil dikirim 🎉</div>
        @elseif ($error)
            <div class="mt-2 p-3 mx-3 bg-red-500 text-white rounded-lg">Anda tidak termasuk daftar tamu undangan 🙏</div>
        @endif

        <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow mx-4 mt-10">
            @if ($publicIsActive || (!$publicIsActive && $kode))
                <form wire:submit.prevent="save" class="space-y-2">
                    <div>
                        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
                        <input type="text" wire:model="nama"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Masukkan nama kamu">
                        @error('nama')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="ucapan" class="block mb-2 text-sm font-medium text-gray-900">Ucapan</label>
                        <textarea wire:model="ucapan"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500"
                            placeholder="Berikan ucapan terbaik kamu"></textarea>
                        @error('ucapan')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Konfirmasi
                            Kehadiran</label>
                        <select wire:model="status"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 focus:ring-blue-500 focus:border-blue-500">
                            <option selected disabled>Pilih status kehadiran</option>
                            <option value="Datang Dong">Datang Dong</option>
                            <option value="Ga bisa Datang Nih">Ga bisa Datang Nih</option>
                            <option value="Diusahakan Datang Ya">Diusahakan Datang Ya</option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full flex items-center justify-center gap-2 text-white bg-blue-700 hover:bg-blue-800 rounded-lg text-sm px-5 py-2.5"
                        wire:loading.attr="disabled">

                        {{-- Teks normal --}}
                        <span wire:loading.remove>Kirim Ucapan</span>

                        {{-- Loading --}}
                        <span wire:loading.flex class="items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                </path>
                            </svg>
                            Kirim...
                        </span>
                    </button>

                </form>
            @endif
        </div>
        @if ($publicIsActive)
            {{-- Daftar Ucapan --}}
            <div
                class="w-full max-w-md p-6 bg-white border border-gray-200 rounded-lg shadow-lg mx-4 mt-10 text-xs md:text-sm">
                @foreach ($listUcapan as $item)
                    <div class="bg-gray-50 p-4 rounded-lg mb-4">
                        <div class="flex justify-between font-semibold text-gray-800">
                            {{ $item->tamu->nama }}
                            <span
                                class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">{{ ucwords(str_replace('_', ' ', $item->status)) }}</span>
                        </div>
                        <p class="text-gray-600 mt-1">{{ $item->ucapan }}</p>
                        <p class="card-text" style="color: #9e0050; margin: 0px">
                            <small>
                                {{ $item->created_at->diffForHumans() }}
                                {{-- ({{ $item->created_at->format('l, d M Y') }}) --}}
                            </small>
                        </p>

                        @if ($item->balas)
                            <div class="mt-2 p-3 bg-gray-100 rounded-md">
                                <p class="italic text-blue-700 text-sm">Balasan:</p>
                                <p class="text-gray-700 text-sm">{{ $item->balas }}</p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
