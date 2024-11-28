<x-dashboard-layout>
    <a href="/dashboard/kelola/{{ Crypt::encryptString($data->id) }}" class="btn btn-secondary btn-sm" ><i
            class="mdi mdi-arrow-left-bold"></i>
        Kembali</a>
    <div class="row my-2">
        <div class="col-lg-6 col-md-12 col-md-6">
            <livewire:dashboard.kelola.pria :data-id="$data->id" />
        </div>
        <div class="col-lg-6 col-md-12 col-md-6">
            <livewire:dashboard.kelola.wanita :data-id="$data->id" />
        </div>
    </div>
</x-dashboard-layout>
