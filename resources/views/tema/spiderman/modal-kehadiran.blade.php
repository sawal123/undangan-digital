@if ($data->FiturUcapan->isActive)
    <div id="ModalRspv"
        class="invisible fixed inset-0 bg-black bg-opacity-50  flex items-center justify-center z-50 font-poppins overflow-auto ">
        <div class=" max-w-xl w-full text-center my-3 py-4 relative">
            <div class="absolute w-full h-full inset-0 bg-white z-10 brightness-75 rounded-2xl shadow-xl"></div>
            <ul class="text-left  flex flex-col items-center text-sm text-black py-2 z-50">
                <!-- ucapan -->
                <li class="w-full  relative z-50 ">

                    <h2 class="text-center text-[30px] font-semibold pb-5 font-audiowide">Ucapan & Doa</h2>
                    @if ($data->FiturUcapan->viewIsActive)
                        <div
                            class="p-6 h-[250px] rounded-lg shadow-lg space-y-2 overflow-y-auto z-50 relative font-poppins">
                            @foreach ($ucapan as $item)
                                <!-- AT -->
                                <div class=" p-4 rounded-md   h-auto  shadow-md shadow-slate-200 bg-[#FFC300]">
                                    <h3 class="text-[12px] font-semibold">{{ $item->tamu->nama }}</h3>
                                    <p class="text-[10px] ">{{ date('l', strtotime($item->created_at)) }},
                                        {{ date('d m Y', strtotime($item->created_at)) }}</p>
                                    <p class="mt-2 text-[10px] italic">{{ $item->ucapan }}</p>
                                </div>
                                @if ($item->balas)
                                    <div>
                                        <div class="italic">Balasan :
                                            {{ $item->balas }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </li>

                <li class="w-full    p-6 relative  section">
                    <h4 class="text-xl font-semibold mb-4 relative z-50 font-audiowide">Kirim Ucapan</h4>

                    @if (session()->has('message'))
                        <div class="mt-2 p-3 mx-3 bg-blue-100 border border-blue-400 text-white rounded-lg">
                            {{ session('message') }}
                        </div>
                    @endif
                    @if ($data->FiturUcapan->publicIsActive)
                        <form action="{{ route('savedoa') }}" method="post" class="space-y-4 relative z-50">
                            @csrf
                            <input type="hidden" name="dataId" value="{{ $data->id }}">
                            <!-- Input Nama -->
                            <input type="text" name="nama" placeholder="Nama Lengkap"
                                class="w-full text-[12px] p-2 rounded-md bg-[#FFC300]  text-black placeholder-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-800" />
                            @error('nama')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror

                            <!-- Textarea Ucapan -->
                            <textarea name="ucapan" placeholder="Ucapan & Doa" rows="4"
                                class="w-full text-[12px] p-2 rounded-md bg-[#FFC300]  text-black placeholder-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-800"></textarea>
                            @error('ucapan')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                            <!-- Select Konfirmasi Kehadiran -->
                            <select name="konfirmasi"
                                class="w-full text-[12px] p-2 rounded-md bg-[#FFC300]  text-black focus:outline-none focus:ring-2 focus:ring-slate-800">
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
                                class="w-full z-50 rounded-full bg-[#FFC300] text-black font-semibold p-3 hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-slate-800">
                                Kirim Sekarang
                            </button>
                        </form>
                    @else(!$data->FiturUcapan->publicIsActive && $kode)
                        <form action="{{ route('savedoa') }}" method="post" class="space-y-4 relative z-50">
                            @csrf
                            <input type="hidden" name="kode" value="{{ $kode }}">
                            <input type="hidden" name="dataId" value="{{ $data->id }}">
                            <!-- Input Nama -->
                            <input type="text" name="nama" placeholder="Nama Lengkap"
                                class="w-full text-[12px] p-2 rounded-md bg-[#FFC300]  text-black placeholder-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-800" />
                            @error('nama')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror

                            <!-- Textarea Ucapan -->
                            <textarea name="ucapan" placeholder="Ucapan & Doa" rows="4"
                                class="w-full text-[12px] p-2 rounded-md bg-[#FFC300]  text-black placeholder-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-800"></textarea>
                            @error('ucapan')
                                <div class="text-red-500 text-sm">{{ $message }}</div>
                            @enderror
                            <!-- Select Konfirmasi Kehadiran -->
                            <select name="konfirmasi"
                                class="w-full text-[12px] p-2 rounded-md bg-[#FFC300]  text-black focus:outline-none focus:ring-2 focus:ring-slate-800">
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
                                class="w-full z-50 rounded-full bg-[#FFC300] text-black font-semibold p-3 hover:bg-orange-400 focus:outline-none focus:ring-2 focus:ring-slate-800">
                                Kirim Sekarang
                            </button>
                        </form>
                    @endif
                </li>
                <!-- ucapan -->

                <button class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300 z-50"
                    onclick="toggleModalRspv()">Tutup</button>
            </ul>

        </div>
    </div>
@endif
