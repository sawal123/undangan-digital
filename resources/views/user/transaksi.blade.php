<x-dashboard-layout>

    <small>Transaksi Kamu, {{ Auth::user()->name }}</small>

    <div class="row my-5">
        <div class="col mx-2 my-2">
            <div class="card border border-info">
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                           <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex flex-column">
                                <strong>INV-12343433</strong>
                                <small style="font-size: 12px">Paket Premium</small>
                                <small style="font-size: 12px">Tgl : 05/12/2024</small>
                            </div>
                            <div class="d-flex flex-column ">
                                <strong>Rp 50.000,-</strong>
                                <button class="btn btn-sm btn-primary">Bayar</button>
                            </div>
                           </div>
                        </li>
                      </ul>
                </div>
            </div>
        </div>
    </div>

</x-dashboard-layout>
