<x-dashboard-layout>

    {{-- <livewire:dashboard.kelola.pay.pay :data-id="$data->id" /> --}}
    <div class="row my-5 justify-content-center">
        <div class="col-12 col-md-4 my-2">
            <div class="card border border-info">
                <div class="card-body text-center">
                    <img src="{{ asset('assets/images/illustrator/finish.svg') }}" alt="" class="img-fluid mb-3"
                        style="max-height: 150px;">
                    <p class="fs-5 fw-bold">Harap Tunggu</p>
                    <p class="fs-6">Jika Status Belum Aktif Segera Hubungi Admin</p>
                    <div class="d-grid gap-2">
                        <a href="/dashboard" class="btn btn-primary">Dashboard</a>
                        <a href="https://wa.me/6282274677715" class="btn btn-success">Hubungi Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-dashboard-layout>
