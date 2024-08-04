<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="section-title mb-4 pb-2 text-center">
                <h4 class="title mb-4">Fitur Apa Saja Yang Kamu Dapat?</h4>
                <p class="text-muted para-desc mb-0 mx-auto">Dengan Fitur Lengkap Kamu Bisa Atur Sendiri!</p>
            </div>
        </div><!--end col-->
    </div><!--end row-->

    @php
        $fitur = ['Aktif Selamanya', 'Bebas Music', 'Ucapan & Doa', 'Kado', 'Kirim WA', 'Galeri Foto & Video'];
        $icon = ['paint-bucket.png', 'wave.png', 'domain.png', 'chatbot.png', 'mail.png', 'cubes.png'];
    @endphp
    <div class="row">

        @for ($i = 0; $i < count($fitur); $i++)
            <div class="col-lg-2 col-md-4 col-6 mt-4 pt-2">
                <div class="card features feature-primary explore-feature shadow rounded text-center">
                    <div class="card-body">
                        <div class="icons rounded-circle shadow-lg d-inline-block">
                            <img src={{ asset('assets/images/icon/' . $icon[$i]) }} class="avatar avatar-md-sm" alt="">
                        </div>
                        <div class="content mt-3">
                            <h6 class="mb-0"><a href="javascript:void(0)"
                                    class="title text-dark">{{ $fitur[$i] }}</a>
                            </h6>
                        </div>
                    </div>
                </div>
            </div><!--end col-->
        @endfor




    </div><!--end row-->
</div><!--end container-->

