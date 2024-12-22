<div class="relationship-photo" data-aos="fade-up" data-aos-duration="1000">
    <img src="{{ asset('storage/' . $data->wanita->image) }}"
        class="rounded-circle img-thumbnail object-fit-cover" alt="Pre-Wedding Photo">
    <h3>{{ $data ? $data->wanita->nama_lengkap : 'Ajeng Febian' }}</h3>
    <p class="relationship-info">
        {{ $data ? $data->wanita->deskripsi : 'Putri ke-2 Bpk. Samuel & Ibu Masuya' }}</p>
    {{-- <div class="social-icons" data-aos="fade-up" data-aos-duration="1000">
        <a href="#"><i class="fa-brands fa-facebook"></i></a>
        <a href="#"><i class="fa-brands fa-instagram"></i></a>
        <a href="#"><i class="fa-brands fa-twitter"></i></a>
        <a href="#"><i class="fa-brands fa-youtube"></i></a>
    </div> --}}
</div>

<h1 class="and-sign" data-aos="fade-up" data-aos-duration="1000">&</h1>

<div class="relationship-photo" data-aos="fade-up" data-aos-duration="1000">
    <img src="{{asset('storage/' . $data->pria->image)}}" class="rounded-circle object-fit-cover img-thumbnail"
        alt="Pre-Wedding Photo">
    <h3>{{ $data ? $data->pria->nama_lengkap : 'Teddy Prakarsa' }}</h3>
    <p class="relationship-info">{{ $data ? $data->pria->deskripsi : 'Putra ke-2 Bpk. Samuel & Ibu Masuya' }}</p>

</div>