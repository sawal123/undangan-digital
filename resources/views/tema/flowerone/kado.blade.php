<div class="pt-5 mt-1">
    <!-- Gift Options -->
    <h3 data-aos="fade-up" data-aos-duration="1000">Kado</h3>
    <p class="gift-info" data-aos="fade-up" data-aos-duration="1000">Berikut adalah
        informasi
        untuk mengirimkan kado atau hadiah secara
        online
        atau melalui pengiriman fisik.</p>

    @foreach ($data->kado as $kado)
        <div class="bank-info" data-aos="fade-up" data-aos-duration="1000">
            <div>
                <img src="{{ asset('storage/' . $kado->giftPay->icon) }}" class="object-fit-cover img-thumbnail"
                    alt="QRIS Bank BCA" style="width: auto%; height: 50px; " />
            </div>
            <p style="font-size: 20px; font-weight: 800;">{{ $kado->giftPay->nama_pay }}
            </p>
            <p>Nama Akun/Rekening <br> <span>{{ $kado->namaPay }}</span></p>
            <p class="" style="margin: 0px">
                Nomor Akun/Rekening <br>
                <span id="nomor-rekening">{{ $kado->nomorPay }}</span>
            </p>
            <button class="btn btn-sm btn-info" onclick="salinTeks()">Salin</button>
            <script>
                function salinTeks() {
                    // Ambil elemen teks
                    const teks = document.getElementById('nomor-rekening').textContent;

                    // Salin teks ke clipboard
                    navigator.clipboard.writeText(teks).then(() => {
                        alert('Nomor rekening berhasil disalin!');
                    }).catch(err => {
                        alert('Gagal menyalin teks: ' + err);
                    });
                }
            </script>
        </div>
        @if ($kado->qris)
            <!-- Bank Details -->
            <div class="bank-details d-flex flex-column align-items-center" data-aos="fade-up" data-aos-duration="1000">
                <p><strong>Transfer Pakai QRIS Bank BCA:</strong></p>
                <div class="bank-card mb-3 text-center">
                    <img src="{{asset('storage/'. $kado->qris)}}" class="object-fit-cover img-thumbnail" alt="QRIS Bank BCA"
                        style="max-width: 75%; min-width: 50%;" />
                </div>
            </div>
        @endif
    @endforeach



</div>
<!-- Flower Divider -->
<div class="flower-divider text-center" id="message">
    <img src="{{ asset('tema/flowerone/img/flower-pembatas.png') }}" class="img-fluid" data-aos="fade-up"
        data-aos-duration="1000">
</div>
