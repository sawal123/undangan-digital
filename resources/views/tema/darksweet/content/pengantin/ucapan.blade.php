<!-- Kehadiran -->
@if ($data->FiturUcapan->isActive)
    <div class="w-full pt-5 bg-zinc-800 h-auto" id="absen">
        <hr class="my-3" data-aos="fade-up" data-aos-duration="3000">
        <h1 class="text-white text-center text-3xl font-bold" data-aos="fade-up" data-aos-duration="3000">
            Kehadiran
        </h1>
        @if (session()->has('message'))
            <div class="mt-2 p-3 mx-3 bg-blue-100 border border-blue-400 text-white rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        @if ($data->FiturUcapan->publicIsActive)
            <form data-aos="fade-up" data-aos-duration="1000" action="{{ route('savedoa') }}" method="post"
                class="mt-5 p-5 space-y-4">
                @csrf

                <input type="hidden" name="dataId" value="{{ $data->id }}">
                <input type="hidden" name="kode" value="{{ $kode }}">

                <!-- Input Nama -->
                <div class="space-y-2">
                    <label for="nama" class="block text-white font-medium text-sm">Nama</label>
                    <input type="text" id="nama" name="nama"
                        class="w-full p-3 bg-zinc-800 text-white border border-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                        placeholder="Nama Anda" value="{{ $tamu }}">
                    @error('nama')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Ucapan -->
                <div class="space-y-2">
                    <label for="ucapan" class="block text-white font-medium text-sm">Ucapan</label>
                    <textarea id="ucapan" name="ucapan" rows="5"
                        class="w-full p-3 bg-zinc-800 text-white border border-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                        placeholder="Tulis Ucapan dan Doa" required></textarea>
                    @error('ucapan')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilihan Kehadiran -->
                <div class="space-y-2">
                    <label for="status" class="block text-white font-medium text-sm">Konfirmasi Kehadiran</label>
                    <select id="status" name="status"
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
        @elseif(!$data->FiturUcapan->publicIsActive && $kode)
            <form data-aos="fade-up" data-aos-duration="1000" action="{{ route('savedoa') }}" method="post"
                class="space-y-4">
                @csrf
                @if (session()->has('message'))
                    <div class="bg-blue-500 text-white p-3 rounded-md text-center">
                        {{ session('message') }}
                    </div>
                @endif

                <input type="hidden" name="dataId" value="{{ $data->id }}">
                <input type="hidden" name="kode" value="{{ $kode }}">

                <!-- Input Nama -->
                <div class="space-y-2">
                    <label for="nama" class="block text-white font-medium text-sm">Nama</label>
                    <input type="text" id="nama" name="nama"
                        class="w-full p-3 bg-zinc-800 text-white border border-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                        placeholder="Nama Anda" value="{{ $tamu }}">
                    @error('nama')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Input Ucapan -->
                <div class="space-y-2">
                    <label for="ucapan" class="block text-white font-medium text-sm">Ucapan</label>
                    <textarea id="ucapan" name="ucapan" rows="5"
                        class="w-full p-3 bg-zinc-800 text-white border border-white rounded-md focus:outline-none focus:ring-2 focus:ring-white"
                        placeholder="Tulis Ucapan dan Doa"></textarea>
                    @error('ucapan')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilihan Kehadiran -->
                <div class="space-y-2">
                    <label for="status" class="block text-white font-medium text-sm">Konfirmasi Kehadiran</label>
                    <select id="status" name="status"
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

    </div>

    <div class="w-full px-3 bg-zinc-800 pt-5 pb-10">
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
        @if ($data->FiturUcapan->viewIsActive)
            <div class="max-h-64 overflow-y-auto bg-gray-100 p-3 rounded-lg" tabindex="0">
                @foreach ($ucapan as $item)
                    <div class="mb-3 p-4 bg-white shadow-md rounded-lg" data-aos="fade-up" data-aos-duration="1000">
                        <div class="flex items-center gap-2">
                            <strong class="text-gray-800">{{ $item->tamu->nama }}</strong>
                            <span class="px-2 py-1 text-sm text-white  rounded"
                                style="background: gray">{{ $item->status }}</span>
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
    <!-- Kehadiran -->

@endif
<div class="w-full h-[750px] flex flex-col justify-center items-center bg-cover bg-center bg-local relative"
    id="bottom" style="background-image: url('{{ asset('storage/' . $thumbnailWa->thumbnail) }}');">
    <div class="absolute bg-black opacity-50 inset-0 w-full h-full z-0"></div>
    <div class="flex flex-col justify-center items-center p-2 bg-white shadow-md z-10">
        <div class="aspect-[5/7] w-44 h-auto">
            <img src="{{ asset('storage/' . $thumbnailWa->thumbnail) }}" alt=""
                class="object-cover w-full h-full">
        </div>
    </div>
    <div class="w-full mx-auto mt-5 z-10">
        <h1 class="text-white text-center text-3xl font-bold font-italiana" data-aos="fade-down"
            data-aos-duration="3000">{{ $data->wanita->nama_panggilan }} &
            {{ $data->pria->nama_panggilan }}
        </h1>
    </div>
    <div class="w-full mx-auto mt-5 z-10">
        <p class="text-white text-center text-lg font-semibold font-italiana" data-aos="fade-up"
            data-aos-duration="3000">Terima
            Kasih</p>
    </div>
    <div class="absolute w-full bottom-0 h-48 bg-gradient-to-t from-black to-transparent"></div>
</div>
