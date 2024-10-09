<x-app-layout>
    <div class="row">
        <div class="col-xl mt-4">
            <div id="alert-container"></div>
            <div class="card border-0">
                <div class="d-flex justify-content-between p-4 shadow rounded-top">
                    <h6 class="fw-bold mb-0">Price List</h6>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#priceForm">
                        <i class="mdi mdi-folder-plus-outline"></i>
                        Add Price
                    </button>
                    @include('admin.price.modalPrice')
                </div>

                <div class="table-responsive shadow rounded-bottom data-simplebar " style="height: 545px;">
                    <table class="table table-center bg-white mb-0" id="harga-table">
                        <thead>
                            <tr>
                                <th class="border-bottom p-3">No.</th>
                                <th class="border-bottom p-3" style="min-width: 220px;">Nama Paket</th>
                                <th class="border-bottom p-3" style="min-width: 220px;">Price</th>
                                <th class="border-bottom p-3" style="min-width: 220px;">Deskripsi</th>
                                <th class="border-bottom p-3" style="min-width: 220px;">Diskon</th>
                                <th class="border-bottom p-3" style="min-width: 220px;">Keterangan</th>
                                <th class="text-end border-bottom p-3" style="min-width: 100px;">Preview</th>
                            </tr>
                        </thead>
                        <tbody>
                            <style>

                            </style>
                            <!-- Start -->
                            @forelse ($price as $index => $harga)
                                <tr>
                                    <th class="p-3">{{ $index + 1 }}</th>
                                    <td class="p-3">
                                        {{ $harga->name_packet }}
                                    </td>
                                    <td class="p-3">
                                        {{ $harga->price }}
                                    </td>
                                    <td class="p-3">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#viewDeskripsi{{ $harga->id }}">Deskripsi</button>
                                        @include('admin.price.modal-viewDeskripsi')
                                    </td>
                                    <td class="p-3">
                                        @if ($harga->diskon->diskon > 0)
                                            {{ $harga->diskon->type == 'persen' ? $harga->diskon->diskon . '%' : 'Rp' . $harga->diskon->diskon }}
                                        @else
                                            <button class="btn btn-sm btn-secondary" disabled>Tidak Tersedia</button>
                                        @endif

                                    </td>
                                    <td class="p-3">
                                        @php
                                            $words = explode(' ', $harga->keterangan); // Pisahkan teks berdasarkan spasi
                                            $limitedWords = array_slice($words, 0, 3); // Ambil hanya 3 kata pertama
                                            $displayText = implode(' ', $limitedWords); // Gabungkan kembali menjadi string
                                        @endphp
                                        {{ $displayText }}{{ count($words) > 3 ? '...' : '' }}
                                    </td>
                                    <td class="text-end p-3 d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#editharga" data-id="{{ $harga->id }}"
                                            data-name="{{ $harga->name_packet }}" data-price="{{ $harga->price }}"
                                            data-type="{{ $harga->diskon->type }}"
                                            data-diskon="{{ $harga->diskon->diskon }}"
                                            data-keterangan="{{ $harga->keterangan }}"
                                            data-deskripsi="{{ $harga->deskripsi }}">
                                            
                                            Edit
                                        </button>

                                        <button class="deleteharga btn btn-sm btn-danger"
                                            data-delete="{{ route('admin.price.destroy', $harga->id) }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <div class=" alert  alert-info d-flex justify-content-center mx-auto" id="empty">

                                </div>
                            @endforelse
                            <!-- End -->
                        </tbody>
                    </table>
                    @include('admin.price.modal-Editharga')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
