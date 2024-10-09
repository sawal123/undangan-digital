<!-- Modal Content Start -->
<div class="modal fade" id="editharga" tabindex="-1" aria-labelledby="editharga-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="editharga-title">Edit Price</h5>
                <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal">
                    <i class="uil uil-times fs-4 text-dark"></i>
                </button>
            </div>
            <form id="form-price" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="p-3 rounded box-shadow">
                        <!-- Nama Paket -->
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="namaPaket" id="namaPaket" placeholder="Nama Paket">
                            <label for="namaPaket">Nama Paket</label>
                            <div id="namaPaketMessage"></div>
                        </div>
                        <!-- Harga Paket -->
                        <div class="form-floating mb-2">
                            <input type="number" class="form-control" name="price" id="price" placeholder="Harga Paket">
                            <label for="price">Harga Paket</label>
                            <div id="priceMessage"></div>
                        </div>
                        <!-- Tipe Diskon (Rupiah / Persen) -->
                        <div class="mb-2">
                            <div class="d-flex gap-4">
                                <div class="d-flex gap-5 my-auto">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" value="rupiah" name="type" id="flexRadioDefault1">
                                        <label class="form-check-label" for="flexRadioDefault1">Rupiah</label>
                                    </div>
                                    <div class="form-check mb-0">
                                        <input class="form-check-input" type="radio" value="persen" name="type" id="flexRadioDefault2">
                                        <label class="form-check-label" for="flexRadioDefault2">Persen</label>
                                    </div>
                                </div>
                                <!-- Diskon -->
                                <div class="form-floating">
                                    <input type="number" class="form-control" name="diskon" id="diskon" placeholder="Diskon">
                                    <label for="diskon">Diskon</label>
                                    <div id="diskonMessage"></div>
                                </div>
                            </div>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="text" class="d-flex rounded deskripsiUp" name="deskripsi" id="deskripsiUp"
                                placeholder="Deskripsi Paket">
                            <div id="deskripsiMessage"></div>
                        </div>
                        <!-- Keterangan -->
                        <div class="form-floating mb-2">
                            <textarea name="keterangan" class="form-control" id="keterangan" cols="30" rows="10"></textarea>
                            <label for="keterangan">Keterangan</label>
                            <div id="keteranganMessage"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Content End -->
