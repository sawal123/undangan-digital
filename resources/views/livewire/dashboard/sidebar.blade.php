<nav id="sidebar" class="sidebar-wrapper sidebar-dark">
    <div class="sidebar-content" data-simplebar style="height: calc(100% - 60px);">
        <div class="sidebar-brand">
            <a href="index.html">
                <img src="{{ asset('logo/logo.svg') }}" height="50" class="logo-light-mode"
                    alt="">
                <img src="{{ asset('logo/logo.svg') }}" height="50" class="logo-dark-mode"
                    alt="">
                <span class="sidebar-colored">
                    <img src="{{ asset('logo/logo.svg') }}" height="50" alt="">
                </span>
            </a>
        </div>

        <ul class="sidebar-menu">
            {{-- <x-admin.menu :link="route('dashboard.dashboard')" :icon="'ti ti-home'" :active="request()->routeIs('dashboard.dashboard')">
                {{ __('Dashboard') }}
            </x-admin.menu> --}}
            <x-admin.menu :link="route('dashboard.index')" :icon="'ti ti-mail'" :active="request()->routeIs('dashboard.index')">
                {{ __('Undangan') }}
            </x-admin.menu>
            <x-admin.menu :link="route('dashboard.transaksi.index')" :icon="'ti ti-shopping-cart'" :active="request()->routeIs('dashboard.transaksi.index')">
                {{ __('Transaksi') }}
            </x-admin.menu>
            @php
                $classes = $active ?? false ? 'active' : '';
            @endphp
            <li class="{{ $classes }}">
                <a href="https://wa.me/6282274677715" target="_blank">
                    <i class="ti ti-phone me-2"></i>
                    {{ __('Costumer Service') }}
                </a>
            </li>


            {{-- <x-admin.menu :link="route('admin.logout')" :icon="'mdi mdi-power'">
                {{ __('Log Out') }}
            </x-admin.menu> --}}
            <li>
                <form id="logout-form" action="{{ route('dashboard.logout') }}" method="POST">
                    @csrf
                    <a href="#">
                        <button type="submit" class="btn-unstyled">
                            <i class="mdi mdi-power me-2"></i>Logout
                        </button>
                    </a>
                </form>
            </li>
            <style>
                .btn-unstyled {
                    background: none;
                    border: none;
                    padding: 0;
                    margin: 0;
                    color: inherit;
                    font: inherit;
                    cursor: pointer;
                    /* text-decoration: underline; */
                    /* Tambahkan garis bawah seperti link */
                }
            </style>




        </ul>
        <!-- sidebar-menu  -->
    </div>

</nav>
