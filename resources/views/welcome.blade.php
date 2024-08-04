<x-landing-layout>
    <!-- Navbar Start -->
    @include('page.part.header')
    <!-- Navbar End -->

    <!-- Hero Start -->
    @include('page.welcome.hero')
    <!-- Hero End -->

    <!-- Start -->
    <section class="section">
        @include('page.welcome.start')
    </section><!--end section-->
    <!-- End -->

    <!-- Start -->
    <section class="section" style="background: url('assets/images/nft/bg.jpg') top center;">
        @include('page.welcome.start2')
    </section>
    <!-- End -->

    <!-- Footer Start -->
    <!-- Footer Start -->
    @include('page.part.footer')
    <!-- Footer End -->
    <!-- Footer End -->
</x-landing-layout>
