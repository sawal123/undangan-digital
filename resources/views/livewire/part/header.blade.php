<div>
    <style>
        /* Default untuk desktop */
        .logo-light-mode {
            height: 50px;
        }

        /* Untuk mobile (dengan lebar layar lebih kecil dari 576px) */
        @media (max-width: 576px) {
            .logo-light-mode {
                height: 30px;
            }
        }
    </style>
    <header id="topnav" class="defaultscroll sticky">
        <div class="container ">
            <!-- Logo container-->
            <a class="logo" href="/" wire:navigate>
                <img src="{{ asset('logo/logo.svg') }}" height="30" class="logo-light-mode" alt="">
                {{-- <img src="{{asset('logo/logo.svg')}}" height="24" class="logo-dark-mode" alt=""> --}}
            </a>
            <!-- End Logo container-->

            {{-- <div class="menu-extras">
                <div class="menu-item">
                    <!-- Mobile menu toggle-->
                    <a class="navbar-toggle" id="isToggle" onclick="toggleMenu()">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                </div>
            </div> --}}

            <ul class="buy-button list-inline mb-0">

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

        </div><!--end container-->
    </header><!--end header-->
</div>
