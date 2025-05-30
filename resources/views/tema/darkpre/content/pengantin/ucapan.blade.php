@if ($data->FiturUcapan->isActive)
    <div class="w-full  bg-neutral-950 text-orange-200 relative z-50 ">
        <h2 class="text-center text-[50px] font-light pb-6 py-8 font-corinthia">Ucapan & Doa</h2>
        <div class="flex justify-center left-0  absolute  z-10">
            <img src="{{ asset('tema/darkpre/src/img/bunga.png') }}" alt="Hiasan Bunga" class="w-20 lg:w-32 ">
        </div>

        <!-- Gambar Hiasan Tengah -->
        <div class="flex justify-center right-0  absolute  z-10">
            <img src="{{ asset('tema/darkpre/src/img/bunga.png') }}" alt="Hiasan Bunga" class="w-20 lg:w-32 ">
        </div>

        @if ($data->FiturUcapan->viewIsActive)
            <div class="p-6 h-[300px] rounded-lg shadow-lg space-y-5 overflow-y-auto z-50 relative font-poppins">
                @foreach ($ucapan as $item)
                    <ul class=" p-4 rounded-md   h-auto  shadow-md shadow-slate-200 bg-neutral-950">
                        <li class="text-[14px] font-semibold">{{ $item->tamu->nama }}</li>
                        <li class="text-[12px] ">{{ date('l', strtotime($item->created_at)) }},
                            {{ date('d m Y', strtotime($item->created_at)) }}</li>
                        <li class="mt-2 text-[12px] italic">{{ $item->ucapan }}</li>
                        @if ($item->balas)
                            <ol>
                                <li class="italic">Balasan :
                                    {{ $item->balas }}</li>
                            </ol>
                        @endif
                    </ul>
                @endforeach

            </div>
        @endif
    </div>

    <div class="w-full bg-neutral-950 text-orange-200 p-6 shadow-lg relative  section" id="wishes">
        <h4 class="text-2xl font-semibold mb-4 relative z-50 font-corinthia">Kirim Ucapan</h4>
        @if (session()->has('message'))
            <div class="mt-2 p-3 mx-3 bg-blue-100 border border-blue-400 text-white rounded-lg">
                {{ session('message') }}
            </div>
        @endif
        <!-- Gambar Hiasan Tengah -->
        <div class="flex justify-center right-14  absolute  z-10">
            <img src="{{ asset('tema/darkpre/src/img/bunga.png') }}" alt="Hiasan Bunga" class="w-20 lg:w-32 ">
        </div>
        @if ($data->FiturUcapan->publicIsActive)
            <form class="space-y-4 relative z-50" action="{{ route('savedoa') }}" method="post">
                @csrf
                <!-- Input Nama -->
                <input type="hidden" name="dataId" value="{{ $data->id }}">
                <input type="text" name="nama" value="{{ $tamu }}" placeholder="Nama Lengkap"
                    class="w-full p-3 rounded-md bg-slate-600 opacity-35 text-orange-200 placeholder-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-200" />
                @error('nama')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <!-- Textarea Ucapan -->
                <textarea name="ucapan" placeholder="Ucapan & Doa" rows="4"
                    class="w-full p-3 rounded-md bg-slate-600 opacity-35 text-orange-200 placeholder-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-200"></textarea>
                @error('ucapan')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
                <!-- Select Konfirmasi Kehadiran -->
                <select name="status"
                    class="w-full p-3 rounded-md bg-slate-600 opacity-35 text-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-200">
                    <option value="">Konfirmasi Kehadiran</option>
                    <option value="datang">Datang Dong</option>
                    <option value="tidak_datang">Tidak Bisa Datang Nih</option>
                    <option value="diusahakan">Diusahakan Datang Ya</option>
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
        @else(!$data->FiturUcapan->publicIsActive && $kode)
            <form class="space-y-4 relative z-50" action="{{ route('savedoa') }}" method="post">
                @csrf
                @if (session()->has('message'))
                    <div class="bg-blue-500 text-white p-3 rounded-md text-center">
                        {{ session('message') }}
                    </div>
                @endif


                <input type="hidden" name="kode" value="{{ $kode }}">
                <input type="hidden" name="dataId" value="{{ $data->id }}">

                <!-- Input Nama -->
                <input type="text" name="nama" value="{{ $tamu }}" placeholder="Nama Lengkap"
                    class="w-full p-3 rounded-md bg-slate-600 opacity-35 text-orange-200 placeholder-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-200" />
                @error('nama')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
                <!-- Textarea Ucapan -->
                <textarea name="ucapan" placeholder="Ucapan & Doa" rows="4"
                    class="w-full p-3 rounded-md bg-slate-600 opacity-35 text-orange-200 placeholder-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-200"></textarea>
                @error('ucapan')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <!-- Select Konfirmasi Kehadiran -->
                <select name="status"
                    class="w-full p-3 rounded-md bg-slate-600 opacity-35 text-orange-200 focus:outline-none focus:ring-2 focus:ring-orange-200">
                    <option value="">Konfirmasi Kehadiran</option>
                    <option value="datang">Datang Dong</option>
                    <option value="tidak_datang">Tidak Bisa Datang Nih</option>
                    <option value="diusahakan">Diusahakan Datang Ya</option>
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
        @endif
    </div>
@endif
