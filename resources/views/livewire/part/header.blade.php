<div>
    <header id="topnav" class="defaultscroll sticky">
        <div class="container">
            <!-- Logo container-->
            <a class="logo" href="/">
                <img src="{{asset('logo/logo.svg')}}" height="50" class="logo-light-mode" alt="">
                {{-- <img src="{{asset('logo/logo.svg')}}" height="24" class="logo-dark-mode" alt=""> --}}
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
                        <a href="
                        @if (Auth::user()->hasRole('Owner')) {{ route('admin.admin') }}
                        @elseif(Auth::user()->hasRole('User'))
                            {{ route('dashboard.index') }} @endif
                    "
                            class="btn btn-info"><i class="mdi mdi-kodi me-2"></i>Dashboard</a>
                    </li>
                    <li class="list-inline-item ps-1 mb-0">
                        <form id="logout-form"
                            action="
                            @if (Auth::user()->hasRole('Owner')) {{ route('admin.logout') }}
                            @elseif(Auth::user()->hasRole('User'))
                                {{ route('dashboard.logout') }} @endif"
                            method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="mdi mdi-power me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li class="list-inline-item ps-1 mb-0">
                        <a href="{{ route('login') }}" wire:navigate class="btn btn-primary">Buat Undangan Disini!</a>
                    </li>
                @endif

            </ul><!--end login button-->

            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">

                    {{-- <x-li-active :link="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-li-active> --}}
                    {{-- <x-li-active :link="route('explore')" :active="request()->routeIs('explore')">
                        {{ __('Explore') }}
                    </x-li-active> --}}


                </ul><!--end navigation menu-->
            </div><!--end navigation-->
        </div><!--end container-->
    </header><!--end header-->
</div>
