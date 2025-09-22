<div>
    <div class="w-full bg-orange-50 text-pink-800 relative z-50">
        <h1 class="text-center text-[50px] font-semibold pb-6 py-8">Ucapan & Doa</h1>
        <div class="flex justify-center left-0  absolute  z-10">
            <img src="{{ asset('tema/whitepre/src/img/bunga.png') }}" alt="Hiasan Bunga" class="w-20 lg:w-32 ">
        </div>

        @if ($viewIsActive)
            <div class="p-6 h-[300px] rounded-lg shadow-lg space-y-5 overflow-y-auto z-50 relative font-poppins ">
                @foreach ($listUcapan as $item)
                    <ul class="p-4 rounded-md h-auto shadow-md shadow-slate-200 bg-orange-50">
                        <li class="text-[14px] font-semibold">{{ $item->tamu->nama }}</li>
                        <li class="text-[12px] ">
                            {{ date('l', strtotime($item->created_at)) }},
                            {{ date('d m Y', strtotime($item->created_at)) }}
                        </li>
                        <li class="mt-2 text-[12px] italic">{{ $item->ucapan }}</li>
                        @if ($item->balas)
                            <ol>
                                <li class="italic">Balasan : {{ $item->balas }}</li>
                            </ol>
                        @endif
                    </ul>
                @endforeach
            </div>
        @endif
    </div>

    <div class="w-full bg-orange-50 text-pink-800 p-6 shadow-lg relative section" id="wishes">
        <h1 class="text-2xl font-semibold mb-4 relative z-50">Kirim Ucapan</h1>
        <div class="flex justify-center right-0 -rotate-180 absolute  z-10">
            <img src="{{ asset('tema/whitepre/src/img/bunga bawah.png') }}" alt="Hiasan Bunga" class="w-20 lg:w-32 ">
        </div>
        <!-- Tampilkan pesan sukses/error -->
        @if ($success)
            <div class="bg-white-200 text-green-800 p-3 rounded-md text-center mb-3">
                {{ $message }}
            </div>
        @endif
        @if ($error)
            <div class="bg-white-200 text-red-800 p-3 rounded-md text-center mb-3">
                {{ $message }}
            </div>
        @endif
        <div class="flex justify-center right-0 -rotate-180 absolute  z-10">
            <img src="{{ asset('tema/whitepre/src/img/bunga bawah.png') }}" alt="Hiasan Bunga" class="w-20 lg:w-32 ">
        </div>

        <form wire:submit.prevent="save" class="space-y-4 relative z-50">
            <!-- Input Nama -->
            <input type="text" wire:model="nama" placeholder="Nama Lengkap"
                class="w-full p-3 rounded-md bg-slate-300 text-black placeholder-black focus:outline-none focus:ring-2 focus:ring-black" />
            @error('nama')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

            <!-- Textarea Ucapan -->
            <textarea wire:model="ucapan" placeholder="Ucapan & Doa" rows="4"
                class="w-full p-3 rounded-md bg-slate-300 text-black placeholder-black focus:outline-none focus:ring-2 focus:ring-black"></textarea>
            @error('ucapan')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

            <!-- Select Konfirmasi Kehadiran -->
            <select wire:model="status"
                class="w-full p-3 rounded-md bg-slate-300 text-black focus:outline-none focus:ring-2 focus:ring-black">
                <option value="">Konfirmasi Kehadiran</option>
                <option value="Datang Dong">Datang Dong</option>
                <option value="Tidak Bisa Datang Nih">Tidak Bisa Datang Nih</option>
                <option value="Diusahakan Datang Ya">Diusahakan Datang Ya</option>
            </select>
            @error('status')
                <div class="text-red-500 text-sm">{{ $message }}</div>
            @enderror

            <!-- Button Kirim -->
            <button type="submit"
                class="w-full rounded-full bg-orange-200 text-black font-semibold p-3 hover:bg-orange-500 focus:outline-none focus:ring-2 focus:ring-orange-200">
                Kirim Sekarang
            </button>
        </form>
    </div>
</div>


