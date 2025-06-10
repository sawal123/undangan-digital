@if ($data->FiturUcapan->isActive)
    <div class="comment mt-10 pb-10 text-[12px] md:text-base bg-[#D7CEBE] justify-center flex flex-col items-center">

        <p class="text-center text-4xl title pt-10 text-[#755f4B]" data-aos="fade-up" data-aos-duration="1500">
            Berikan Ucapan
        </p>

        <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 mx-4 mt-10"
            data-aos="fade-up" data-aos-duration="1500">
            @if ($data->FiturUcapan->publicIsActive)
                <form class="space-y-2" action="{{ route('savedoa') }}" method="post">
                    @csrf
                    <input type="hidden" name="dataId" value="{{ $data->id }}">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Nama</label>
                        <input type="text" name="nama" value="{{ $tamu }}" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    "
                            placeholder="Masukkan nama kamu" value="{{ $tamu }}" />
                    </div>
                    <div>
                        <label for="ucapan" class="block mb-2 text-sm font-medium text-gray-900 ">Masukan
                            ucapanmu</label>
                        <textarea type="text" name="ucapan" id="ucapan" placeholder="Berikan ucapan terbaik kamu" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                        </textarea>
                    </div>
                    <select name="status" id="countries" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected disabled>Konfirmasi Kehadiran</option>
                        <option value="Datang Dong">Datang Dong</option>
                        <option value="Ga bisa Datang Nih">Ga bisa Datang Nih</option>
                        <option value="Diusahakan Datang Ya">Diusahakan Datang Ya</option>
                    </select>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Kirim
                        Ucapan
                    </button>

                </form>
            @elseif(!$data->FiturUcapan->publicIsActive && $kode)
                <form class="space-y-2" action="{{ route('savedoa') }}" method="post">
                    @csrf
                    <input type="hidden" name="kode" value="{{ $kode }}">
                    <input type="hidden" name="dataId" value="{{ $data->id }}">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 ">Nama</label>
                        <input type="text" name="nama" value="{{ $tamu }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5    "
                            placeholder="Masukkan nama kamu" value="{{ $tamu }}" />
                    </div>
                    <div>
                        <label for="ucapan" class="block mb-2 text-sm font-medium text-gray-900 ">Masukan
                            ucapanmu</label>
                        <textarea type="text" name="ucapan" id="ucapan" placeholder="Berikan ucapan terbaik kamu"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                    </textarea>
                    </div>
                    <select name="status" id="countries"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option selected disabled>Konfirmasi Kehadiran</option>
                        <option value="Datang Dong">Datang Dong</option>
                        <option value="Ga bisa Datang Nih">Ga bisa Datang Nih</option>
                        <option value="Diusahakan Datang Ya">Diusahakan Datang Ya</option>
                    </select>
                    <button type="submit"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Kirim
                        Ucapan
                    </button>

                </form>
            @endif

        </div>

        <div class="w-full max-w-md p-6 bg-white border border-gray-200 rounded-lg shadow-lg mx-4 mt-10 text-xs md:text-sm mb-2"
            data-aos="fade-up" data-aos-duration="1500">
            @foreach ($ucapan as $item)
                <div class="bg-gray-50 p-4 rounded-lg ">
                    <ul class="border-b border-gray-300 pb-2 ">
                        <li class="text-base font-semibold text-[#2d3748]">
                            {{ $item->tamu->nama }}
                            <span
                                class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded-full">{{ $item->status }}</span>
                        </li>
                        <li class="text-sm text-[#4a5568]">{{ $item->ucapan }}</li>
                    </ul>
                    @if ($item->balas)
                        <div class="mt-2 p-4 bg-gray-100 rounded-md">
                            <p class="italic text-[#2b6cb0] text-sm">Balasan:</p>
                            <p class="text-[#4a5568] text-sm">{{ $item->balas }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

    </div>
@endif
