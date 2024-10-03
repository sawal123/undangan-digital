<div>
    <header id="topnav" class="defaultscroll sticky">
        <div class="container">
            <!-- Logo container-->
            <a class="logo" href="index.html">
                <img src="assets/images/logo-dark.png" height="24" class="logo-light-mode" alt="">
                <img src="assets/images/logo-light.png" height="24" class="logo-dark-mode" alt="">
            </a>
            <!-- End Logo container-->

            <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </div>
            </div>

            <ul class="buy-button list-inline mb-0">
                <li class="list-inline-item mb-0">
                    <div class="dropdown">
                    </div>
                </li>

                @if (Auth::user())
                    <li class="list-inline-item ps-1 mb-0">
                        <a href="" class="btn btn-primary">logout</a>
                    </li>
                @else
                    <li class="list-inline-item ps-1 mb-0">
                        <a href="{{ route('login') }}" wire:navigate class="btn btn-primary">Login</a>
                    </li>
                @endif

            </ul><!--end login button-->

            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    <x-li-active  :link="route('home')" :active="request()->routeIs('home')" >
                        {{ __('Home') }}
                    </x-li-active>
                    <x-li-active  :link="route('explore')" :active="request()->routeIs('explore')" >
                        {{ __('Explore') }}
                    </x-li-active>







                </ul><!--end navigation menu-->
            </div><!--end navigation-->
        </div><!--end container-->
    </header><!--end header-->
</div>
