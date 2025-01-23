@if ($data->FiturUcapan->isActive)
    <div class="comment mt-10 pb-10 text-[12px] md:text-base bg-[#D7CEBE] justify-center flex flex-col items-center">

        <h2 class="text-center text-xl md:text-2xl pt-10 text-[#755f4B]" data-aos="fade-up" data-aos-duration="1500">
            BERIKAN
            UCAPAN
        </h2>

        <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 mx-4 mt-10"
            data-aos="fade-up" data-aos-duration="1500">
            @if ($data->FiturUcapan->publicIsActive)
                <form class="space-y-2" action="{{ route('savedoa') }}" method="post">
                    @csrf
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

        <div class="w-full max-w-md p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 mx-4 mt-10 text-[12px] md:text-base mb-5"
            data-aos="fade-up" data-aos-duration="1500">
            @foreach ($ucapan as $item)
                <ul class="border-b border-black">
                    <li class="font-semibold">{{ $item->tamu->nama }}</li>
                    <li class="mb-2">{{ $item->ucapan }}</li>
                    @if ($item->balas)
                        <ol>
                            <li class="italic">Balasan :
                                {{ $item->balas }}</li>
                        </ol>
                    @endif
                </ul>
            @endforeach

        </div>
    </div>
@endif
