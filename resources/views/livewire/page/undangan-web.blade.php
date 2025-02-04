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
                    @foreach ($undanganWeb as $item)
                        <div class="col-lg-2 col-md-6 col-6 spacing picture-item bird" data-groups='["development"]'>
                            <div
                                class="card work-container work-primary border border-primary  work-grid position-relative d-block overflow-hidden rounded">
                                <div class="card-body p-0  ">
                                    <div class="gallery">
                                        <a href="{{ asset('storage/'. $item->thumbnail) }}"
                                            class="lightbox-link" title="Work Image">
                                            <img src="{{ asset('storage/'. $item->thumbnail) }}"
                                                class="img-fluid" alt="Work Image">
                                        </a>
                                    </div>

                                    <!-- Lightbox Modal -->
                                    <div id="lightbox-modal" class="lightbox-modal">
                                        <div class="lightbox-content">
                                            <span id="lightbox-close" class="lightbox-close">&times;</span>
                                            <img id="lightbox-image" src="" alt="Lightbox Image">
                                        </div>
                                    </div>
                                    <div class="border p-3">
                                        <a href="{{url('demo/'.$item->demo)}}">
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
        <section class="section mt-5" style="background: url('{{asset("assets/images/nft/bg.jpg")}}') top center;">
            @include('landingpage.welcome.start2')
        </section>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const lightboxModal = document.getElementById('lightbox-modal');
                const lightboxImage = document.getElementById('lightbox-image');
                const lightboxClose = document.getElementById('lightbox-close');
                const lightboxLinks = document.querySelectorAll('.lightbox-link');

                // Open lightbox
                lightboxLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const imageUrl = link.getAttribute('href');
                        lightboxImage.src = imageUrl;
                        lightboxModal.classList.add('active');
                    });
                });

                // Close lightbox
                lightboxClose.addEventListener('click', () => {
                    lightboxModal.classList.remove('active');
                    lightboxImage.src = ''; // Clear image to avoid reloading issues
                });

                // Close lightbox when clicking outside the image
                lightboxModal.addEventListener('click', (e) => {
                    if (e.target === lightboxModal) {
                        lightboxModal.classList.remove('active');
                        lightboxImage.src = '';
                    }
                });
            });
        </script>
    </x-landing-layout>
</div>
