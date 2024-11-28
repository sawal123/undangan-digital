<div class="card border-0">
    {{-- <div id="alert-container"></div> --}}
    <div class="d-flex justify-content-between p-4 shadow rounded-top">
        <h6 class="fw-bold mb-0">Gift Pay</h6>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#giftPayForm">
            <i class="mdi mdi-folder-plus-outline"></i>
            Add Gift
        </button>
        @include('admin.setting.modal-gift')


    </div>
    <div class="table-responsive shadow rounded-bottom data-simplebar " style="height: 545px;">
        <table class="table table-center bg-white mb-0" id="gift-table">
            <thead>
                <tr>
                    <th class="border-bottom p-3">No.</th>
                    <th class="border-bottom p-3" style="min-width: 220px;">Nama Pay</th>
                    <th class="text-end border-bottom p-3" style="min-width: 100px;">Preview</th>
                </tr>
            </thead>
            <tbody>
                <style>

                </style>
                <!-- Start -->
                @forelse ($gifts as $index=>$gift)
                    <tr>
                        <th class="p-3">{{ $index + 1 }}</th>
                        <td class="p-3">
                            <a href="#" class="text-primary">
                                <div class="d-flex align-items-center">
                                    <img src="{{ Storage::url($gift->icon) }}" class="avatar avatar-ex-small  shadow"
                                        style="object-fit: contain" alt="">
                                    <span class="ms-2">{{ $gift->nama_pay }}</span>
                                </div>
                            </a>
                        </td>
                        <td class="text-end p-3 ">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#editGift{{ $gift->id }}">Edit</button>
                            @include('admin.setting.modal-EditGift')
                           
                            <button class="deleteGiftPay btn btn-sm btn-danger"
                                data-delete="{{ route('admin.giftpay.destroy', $gift->id) }}">
                                Delete
                            </button>
                            </div>
                          
                        </td>
                    </tr>

                @empty
                    <div class="alert  alert-info d-flex justify-content-center mx-auto" id="empty">
                        <strong>Gift Pay Masih Kosong!</strong>
                    </div>
                @endforelse
                <!-- End -->
            </tbody>
        </table>
    </div>
</div>
