<div class="container ">
    {{-- <div class="row justify-content-center">
        <div class="col-12">
            <div class="section-title mb-4 pb-2 text-center">
                <h4 class="title mb-4">Best Creators</h4>
                <p class="text-muted para-desc mb-0 mx-auto">Start working with <span
                        class="text-primary fw-bold">Landrick</span> that can provide everything you need to generate
                    awareness, drive traffic, connect.</p>
            </div>
        </div><!--end col-->
    </div><!--end row--> --}}

    <div class="row">
        <div class="col-12 mt-4 pt-2">
            <div class="tiny-five-item">
               @for($i = 0; $i < 10; $i++)
               <div class="tiny-slide">
                <div class="card mx-2 nft nft-item nft-primary rounded shadow overflow-hidden">
                    <div class="nft-image position-relative overflow-hidden">
                        <img src="{{asset('assets/images/digital/invitation4.webp')}}" class="img-fluid item-img" alt="">
                       
                        <div class="position-absolute top-0 end-0 m-2">
                            <a href="" class="badge rounded-md bg-light shadow"><i
                                    class="mdi mdi-heart align-middle text-danger"></i> <span
                                    class="text-dark">{{ rand(100, 1000) }}</span></a>
                        </div>
                    </div>
        
                  
                </div>
            </div><!--end tiny-slide-->
               @endfor

                
            </div>
        </div><!--end col-->
    </div><!--end row-->
</div><!--end container-->