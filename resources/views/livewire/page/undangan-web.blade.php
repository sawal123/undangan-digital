<div>
    <x-landing-layout>
        <style>
            /* Gallery styling */
            .gallery {
                display: flex;
                gap: 10px;
            }

            .gallery img {
                cursor: pointer;
                max-width: 350px;
                height: 310px;
                object-fit: contain;
                /* border-radius: 5px; */
                transition: transform 0.3s ease;
            }

            .gallery img:hover {
                transform: scale(1.1);
            }

            /* Lightbox modal styling */
            .lightbox-modal {
                display: none;
                /* Hidden by default */
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8);
                justify-content: center;
                align-items: center;
                z-index: 1000;
            }

            .lightbox-modal.active {
                display: flex;
                /* Show when active */
            }

            .lightbox-content {
                position: relative;
                max-width: 20%;
                max-height: 90%;
            }

            @media (max-width: 768px) {
                .lightbox-content {
                    max-width: 90%;
                }
            }

            .lightbox-content img {
                width: 100%;
                height: auto;
                border-radius: 5px;
            }

            .lightbox-close {
                position: absolute;
                top: 10px;
                right: 10px;
                font-size: 24px;
                color: white;
                cursor: pointer;
            }
        </style>
        <section class="section mt-4">
            <div class="container">
                <h1>Undangan Web</h1>
                <div class="row mt-5">
                    @foreach ($undanganWeb as $index=>$item)
                        <div class="col-lg-2 col-md-6 col-6 spacing " data-groups='["development"]'>
                            <div
                                class="card w border border-primary work-grid position-relative d-block overflow-hidden rounded">
                                <div class="card-body p-0">
                                    <div class="gallery">
                                        <a class="example-image-link" href="{{ asset('storage/' . $item->thumbnail) }}" data-lightbox="image-{{$index+1}}" data-title="{{$item->nama}}">
                                            <img src="{{ asset('storage/' . $item->thumbnail) }}" class="img-fluid"
                                                alt="Work Image">
                                        </a>
                                    </div>
                                    <div class="border p-3">
                                        <a href="{{ url('demo/' . $item->demo) }}">
                                            <h6 class="text-muted tag mb-0">{{ $item->nama }}</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    @endforeach
                </div>

            </div>
        </section><!--end section-->
        <section class="section mt-5" style="background: url('{{ asset('assets/images/nft/bg.jpg') }}') top center;">
            @include('landingpage.welcome.start2')
        </section>


    </x-landing-layout>
</div>
