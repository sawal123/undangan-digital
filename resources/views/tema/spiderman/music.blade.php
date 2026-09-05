{{-- Tampilkan ikon play existing untuk state berhenti milik core. --}}
<style>
    #musicToggle .fa-music::before { content: '\f04b'; }
</style>
@include('tema.partials.music', ['data' => $data])
