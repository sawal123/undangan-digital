<div>
    <div class="row">
        <div class="col-md-5 col-lg-4  mt-4">
            <div class="card rounded shadow p-4 border-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="h5 mb-0">Rincian Nominal</span>
                    <span class="badge bg-primary rounded-pill">3</span>
                </div>
                <ul class="list-group mb-3 border">

                    <li class="d-flex justify-content-between lh-sm p-3 border-bottom">
                        <div>
                            <h6 class="my-0">Paket Premium</h6>
                            <small class="text-muted">Deskripi tentang premium</small>
                        </div>
                        <span class="text-muted">$5</span>
                    </li>
                    <li class="d-flex justify-content-between bg-light p-3 border-bottom">
                        <div class="text-success">
                            <h6 class="my-0">Kode Promo</h6>
                            <small>-</small>
                        </div>
                        <span class="text-success">−$5</span>
                    </li>
                    <li class="d-flex justify-content-between p-3">
                        <span>Total (Rp)</span>
                        <strong>$20</strong>
                    </li>
                </ul>

                <form>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Promo code">
                        <button type="submit" class="btn btn-secondary">Redeem</button>
                    </div>
                </form>
            </div>
        </div><!--end col-->

        <div class="col-md-7 col-lg-8 mt-4">
            <div class="card rounded shadow p-4 border-0">
                <h4 class="mb-3">Informasi Pembelian</h4>
                <form class="needs-validation" novalidate>
                    <div class="mb-3">
                        <label for="text" class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="text" placeholder="Hilgers">
                        <div class="invalid-feedback">
                            Please enter a valid text address for shipping updates.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" placeholder="you@example.com">
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="number" class="form-label">WhatsApp <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="number" placeholder="08327467****">
                        <div class="invalid-feedback">
                            Please enter a valid number address for shipping updates.
                        </div>
                    </div>

                    <h4 class="mb-3 mt-4 pt-4 border-top">Payment</h4>

                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Qris / E-Wallet
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Transfer Bank (Virtual Account)
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show"
                                data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <style>
                                        .rad:hover{
                                            background-color: rgb(243, 243, 243);
                                            border: 1px black solid !important
                                        }
                                        
                                    </style>
                                    <div class="border border-red rounded rad my-2" >
                                        <input type="radio" class="btn-check" name="channel" value="va|bri"
                                            id="bri" wire:model.lazy="channel">
                                        <label for="bri"
                                            class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center p-3 mb-0">
                                            <div class="symbol symbol-50px me-3  overflow-hidden  ">
                                                <img src="https://app.wevitation.com/img/banks/bri.svg" width="50"
                                                    class=" h-auto " alt="Logo BRI">
                                            </div>
                                            <div class="text-start">
                                                <span class="fw-bold text-dark fs-5">BRI</span>
                                                {{-- <span class="d-block text-muted fs-7">Bank Rakyat Indonesia</span> --}}
                                            </div>
                                        </label>
                                    </div>
                                    <div class="border border-red rounded rad my-2" >
                                        <input type="radio" class="btn-check" name="channel" value="va|bri"
                                            id="bri" wire:model.lazy="channel">
                                        <label for="bri"
                                            class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center p-3 mb-0">
                                            <div class="symbol symbol-50px me-3  overflow-hidden  ">
                                                <img src="https://app.wevitation.com/img/banks/bri.svg" width="50"
                                                    class=" h-auto " alt="Logo BRI">
                                            </div>
                                            <div class="text-start">
                                                <span class="fw-bold text-dark fs-5">BRI</span>
                                                {{-- <span class="d-block text-muted fs-7">Bank Rakyat Indonesia</span> --}}
                                            </div>
                                        </label>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    <button class="w-100 btn btn-primary mt-3" type="submit">Continue to checkout</button>
                </form>
            </div>
        </div><!--end col-->
    </div><!--end row-->
</div>
