@if ($data->FiturUcapan->isActive)

        <livewire:ucapan.ucapan :data="$data" :tamu="$tamu" :kode="$kode" />

@endif
