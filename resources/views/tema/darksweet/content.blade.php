<div id="content" class="relative">
  <!-- Jumbotron -->
  <section class="relative z-10 flex justify-center mx-auto inset-0">
    @include('tema.darksweet.content.jumbotron')
  </section>
  <!-- Jumbotron -->

  <div class="container relative px-0 mx-auto w-full min-h-screen invisible z-0" id="home"></div>

  <!-- Content -->
  <section class="z-10 relative w-full md:w-2/4 lg:w-1/3 flex flex-col justify-center  mx-auto ">
    <!--  -->

    <!--  -->
    <div class="container relative px-0 mx-auto flex flex-row w-full z-20 bg-transparent ">
      <div class=" border-white left-0 bg-transparent w-full h-0 border-b-[30px] border-l-[10px] border-r-[30px] border-r-transparent rounded-none">
      </div>
      <div
        class=" border-white left-0 bg-transparent w-full h-0 border-b-[30px] border-l-[30px] border-r-[10px] border-l-transparent rounded-none ">
      </div>
    </div>

    @include('tema.darksweet.content.pengantin')


  </section>
  <!-- Content -->

@include('tema.darksweet.nav')

  
</div>