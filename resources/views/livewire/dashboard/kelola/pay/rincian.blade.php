<ul class="list-group mb-3 border">

    <li class="d-flex justify-content-between lh-sm p-3 border-bottom">
        <div>
            <h6 class="my-0">Paket Premium</h6>
            <small class="text-muted">Deskripi tentang premium</small>
        </div>
        <span class="text-muted">Rp {{ number_format($harga, 0, ',', '.') }}</span>
    </li>
    <li class="d-flex justify-content-between bg-light p-3 border-bottom">
        <div class="text-success">
            <h6 class="my-0">Kode Promo</h6>
            <small>{{ $code }}</small>
        </div>
        <span class="text-success">- Rp {{number_format($promo, 0, ',', '.')  }}</span>
    </li>
    <li class="d-flex justify-content-between bg-light p-3 border-bottom">
        <div class="text-success">
            <h6 class="my-0">Internet Fee</h6>
        </div>
        <span class="text-success">+ Rp {{number_format($fee , 0, ',', '.')  }}</span>
    </li>
    <li class="d-flex justify-content-between p-3">
        <span>Total (Rp)</span>
        <strong>{{ number_format($total == 0 ? $harga : $total, 0, ',', '.') }}</strong>
    </li>
</ul>
