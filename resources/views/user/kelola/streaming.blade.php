<x-dashboard-layout>
    <a href="/dashboard/kelola/{{ Crypt::encryptString($data->id) }}" class="btn btn-secondary btn-sm" wire:navigate><i
            class="mdi mdi-arrow-left-bold"></i>
        Kembali</a>
    <livewire:dashboard.kelola.streaming :data-id="$data->id"/>
</x-dashboard-layout>
