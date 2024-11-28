<x-dashboard-layout>
    <a href="/dashboard/kelola/{{ Crypt::encryptString($data->id) }}/tema" class="btn btn-secondary btn-sm" ><i
            class="mdi mdi-arrow-left-bold"></i>
        Kembali</a>
    <livewire:dashboard.kelola.pay.pay :data-id="$data->id" />
</x-dashboard-layout>
