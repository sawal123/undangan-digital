<x-landing-layout>
    @include('page.welcome.hero')


    @include('page.welcome.best-creator')

    <!-- Start -->
    <section class="section">
        @include('page.welcome.fitur')
        <div class="mt-5">
            <h4 class="text-center">Kategori</h4>
        </div>
        @include('page.welcome.kategori')
        @include('page.welcome.explore')
    </section><!--end section-->
    <!-- End -->

    <!-- Start -->
    <section class="section" style="background: url('assets/images/nft/bg.jpg') top center;">
        @include('page.welcome.start2')
    </section>
    <!-- End -->

</x-landing-layout>
