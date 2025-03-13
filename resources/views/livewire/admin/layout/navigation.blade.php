<nav id="sidebar" class="sidebar-wrapper sidebar-dark">
    <div class="sidebar-content" data-simplebar style="height: calc(100% - 60px);">
        <div class="sidebar-brand">
            <a href="/">
                <img src="{{ asset('assetDashboard/images/logo-dark.png') }}" height="24" class="logo-light-mode"
                    alt="">
                <img src="{{ asset('assetDashboard/images/logo-light.png') }}" height="24" class="logo-dark-mode"
                    alt="">
                <span class="sidebar-colored">
                    <img src="{{ asset('assetDashboard/images/logo-light.png') }}" height="24" alt="">
                </span>
            </a>
        </div>

        <ul class="sidebar-menu">
            <x-admin.menu :link="route('admin.admin')" :icon="'ti ti-home'" :active="request()->routeIs('admin.admin')">
                {{ __('Dashboard') }}
            </x-admin.menu>
            <x-admin.menu :link="route('admin.theme.index')" :icon="'mdi mdi-svg'" :active="request()->routeIs('admin.theme.index')">
                {{ __('Theme') }}
            </x-admin.menu>
            <x-admin.menu :link="route('admin.animation')" :icon="'mdi mdi-google-nearby'" :active="request()->routeIs('admin.animation')">
                {{ __('Undangan Animasi') }}
            </x-admin.menu>
            <x-admin.menu :link="route('admin.cetak')" :icon="'mdi mdi-book'" :active="request()->routeIs('admin.cetak')">
                {{ __('Undangan Cetak') }}
            </x-admin.menu>
            {{-- <x-admin.menu :link="route('admin.price.index')" :icon="'mdi mdi-cash-multiple'" :active="request()->routeIs('admin.price.index')">
                {{ __('Price') }}
            </x-admin.menu> --}}
            <x-admin.menu :link="route('admin.harga')" :icon="'mdi mdi-cash-multiple'" :active="request()->routeIs('admin.harga')">
                {{ __('Harga') }}
            </x-admin.menu>
            <x-admin.menu :link="route('admin.transaksi')" :icon="'mdi mdi-cube-send'" :active="request()->routeIs('admin.transaksi')">
                {{ __('Transaksi') }}
            </x-admin.menu>
            <x-admin.menu :link="route('admin.user')" :icon="'mdi mdi-account'" :active="request()->routeIs('admin.user')">
                {{ __('User') }}
            </x-admin.menu>
            <x-admin.menu :link="route('admin.setting')" :icon="'mdi mdi-cog'" :active="request()->routeIs('admin.setting')">
                {{ __('Setting') }}
            </x-admin.menu>
           
            <x-admin.menu :link="route('admin.pay.setting')" :icon="'mdi mdi-cog'" :active="request()->routeIs('admin.pay.setting')">
                {{ __('Gift Pay Setting') }}
            </x-admin.menu>
            {{-- <x-admin.menu :link="route('admin.logout')" :icon="'mdi mdi-power'">
                {{ __('Log Out') }}
            </x-admin.menu> --}}
            <li>
                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST">
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
