<x-dashboard-layout>

    <small>Transaksi Kamu, {{ Auth::user()->name }}</small>

    <div class="row my-5">
        <div class="col mx-2 my-2">
            <div class="card border border-info">
                <div class="card-body">
                    <ul class="list-group">
                        @forelse ($transaksi as $item)
                            <li class="list-group-item">
                                <div class="d-flex  justify-content-between align-items-center">
                                    <div class="d-flex flex-column">
                                        <small>{{ $item->data->title }}</small>
                                        <strong>{{ $item->invoice }}</strong>
                                        <small class="" style="font-size: 12px">Paket Premium</small>
                                        <small style="font-size: 12px">Tgl : {{ $item->created_at }}</small>
                                    </div>
                                    <div class="d-flex flex-column ">
                                        <strong>Rp {{ number_format($item->price, 0, ',', '.') }},-</strong>
                                        @if ($item->payment_status === 'SUCCESS')
                                            <button class="btn btn-sm btn-success" disabled>Pembayaran Success</button>
                                        @else
                                            <a href="{{ $item->link_snap }}" class="btn btn-sm btn-primary">Selesaikan
                                                Pembayaran</a>
                                        @endif
                                    </div>
                                </div>
                            </li>
                        @empty
                            <p class="text-center">Tidak Ada Transaksi</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

</x-dashboard-layout>
