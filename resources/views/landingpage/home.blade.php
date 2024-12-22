<div>
    <x-landing-layout>
        @include('landingpage.welcome.hero')
    
    
        {{-- @include('landingpage.welcome.best-creator') --}}
    
        <!-- Start -->
        <section class="section">
            @include('landingpage.welcome.fitur')
            {{-- <div class="mt-5">
                <h4 class="text-center">Kategori </h4>
            </div> --}}
            {{-- @include('landingpage.welcome.kategori') --}}
            {{-- @include('landingpage.welcome.explore') --}}
        </section><!--end section-->
        <!-- End -->
    
        <!-- Start -->
        <section class="section" style="background: url('assets/images/nft/bg.jpg') top center;">
            @include('landingpage.welcome.start2')
        </section>
        <!-- End -->
    
    </x-landing-layout>
    
</div>