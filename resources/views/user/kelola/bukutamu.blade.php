<x-dashboard-layout>
    <a href="/dashboard/kelola/{{ Crypt::encryptString($data->id) }}" class="btn btn-secondary btn-sm"><i
            class="mdi mdi-arrow-left-bold"></i>
        Kembali</a>
    <section class="bg-home d-flex ">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-12 text-center">
                    <img src="{{asset('assets/images/404.svg')}}" style="max-width: 500px;" alt="">
                    <div class="text-uppercase mt-4 display-5 fw-semibold">Fitur Ini Belum Tersedia</div>
                    <div class="text-capitalize text-dark mb-4 error-page"></div>
                    {{-- <p class="text-muted para-desc mx-auto">Our design projects are fresh and simple and will benefit
                        your business greatly. Learn more about our work!</p> --}}
                </div><!--end col-->
            </div><!--end row-->

           
        </div><!--end container-->
    </section><!--end section-->
</x-dashboard-layout>
