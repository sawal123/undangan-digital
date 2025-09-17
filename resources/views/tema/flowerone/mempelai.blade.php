<div class="relationship-photo" data-aos="fade-up" data-aos-duration="1000">
    <img src="{{ asset('storage/' . $data->pria->image) }}" class="rounded-circle object-fit-cover img-thumbnail"
        alt="Pre-Wedding Photo">
    <h3>{{ $data ? $data->pria->nama_lengkap : 'Teddy Prakarsa' }}</h3>
    <p class="relationship-info">{{ $data->pria->deskripsi }}</p>
</div>
<h1 class="" data-aos="fade-up" data-aos-duration="1000">&</h1>
<div class="relationship-photo" data-aos="fade-up" data-aos-duration="1000">
    <img src="{{ asset('storage/' . $data->wanita->image) }}" class="rounded-circle img-thumbnail object-fit-cover"
        alt="Pre-Wedding Photo">
    <h3>{{ $data->wanita->nama_lengkap }}</h3>
    <p class="relationship-info">
        {{ $data ? $data->wanita->deskripsi : 'Putri ke-2 Bpk. Samuel & Ibu Masuya' }}</p>
</div>
