<div>
    <style>
        .a {
            height: 250px !important;
            width: 100%;

            object-fit: cover;
            display: block;
        }

        .cursor {
            cursor: pointer;
        }
    </style>
    <x-landing-layout>
        <section class="section mt-4">
            <div class="container">
                <h1>Undangan Web</h1>
                <div class="row mt-5">
                    @foreach ($animasi as $item)
                        <div class="col-lg-2 col-md-6 col-6 spacing picture-item bird" data-groups='["development"]'>
                            <div
                                class="card work-container work-primary border border-primary  work-grid position-relative d-block overflow-hidden rounded">
                                <div class="card-body p-0  ">
                                    <div class="gallery" style="display: flex; justify-content: center; align-items: center; height: 100%; ">
                                        <iframe style="width: 100%; height: 240px"  src="{{$item->link}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                    

                                 
                                    <div class=" p-2">
                                        <h6 class="text-muted tag mb-0">{{ $item->nama }}</h6>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    @endforeach

                </div>

            </div>
        </section><!--end section-->



        </section>
        <section class="section" style="background: url('assets/images/nft/bg.jpg') top center;">
            @include('landingpage.welcome.start2')
        </section>
    </x-landing-layout>
</div>
