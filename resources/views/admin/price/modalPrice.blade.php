<!-- Modal Content Start -->
<div class="modal fade" id="priceForm" tabindex="-1" aria-labelledby="priceForm-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header border-bottom">
                <h5 class="modal-title" id="priceForm-title">Add Price</h5>
                <button type="button" class="btn btn-icon btn-close" data-bs-dismiss="modal" id="close-modal"><i
                        class="uil uil-times fs-4 text-dark"></i></button>
            </div>
            <form id="form-price" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="p-3 rounded box-shadow">
                        <div class="form-floating mb-2">
                            <input type="text" class="form-control" name="namaPaket" 
                                placeholder="Nama Paket">
                            <label for="paket">Nama Paket</label>
                            <div id="namaPaketMessage"></div>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="number" class="form-control" name="price" 
                                placeholder="Nama Paket">
                            <label for="price">Harga Paket</label>
                            <div id="priceMessage"></div>
                        </div>
                        <div class=" mb-2">
                            <div class="d-flex gap-4">
                                <div class="d-flex gap-5 my-auto">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" checked type="radio" value="rupiah" name="type"
                                                id="rupiah">
                                            <label class="form-check-label" for="rupiah">Rupiah</label>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <div class="form-check mb-0">
                                            <input class="form-check-input" checked type="radio" value="persen" name="type"
                                                id="persen">
                                            <label class="form-check-label" for="persen">Persen</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating ">
                                    <input type="number" class="form-control" name="diskon" id="disk"
                                        placeholder="Nama Paket">
                                    <label for="disk">Diskon</label>
                                    <div id="diskonMessage"></div>
                                </div>

                            </div>
                        </div>

                        <div class="form-floating mb-2">
                            <input type="text" class="d-flex rounded deskripsi" name="deskripsi" id="desk"
                                placeholder="Deskripsi Paket">
                            {{-- <label for="deskripsi">Deskripsi</label> --}}
                            <div id="deskripsiMessage"></div>
                        </div>
                        <div class="form-floating mb-2">
                            <textarea name="keterangan" class="form-control" id="ket" cols="30" rows="10"></textarea>
                            <label for="ket">Keterangan</label>
                            <div id="keteranganMessage"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal Content End -->
