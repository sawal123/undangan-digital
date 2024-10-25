<nav id="sidebar" class="sidebar-wrapper sidebar-dark">
    <div class="sidebar-content" data-simplebar style="height: calc(100% - 60px);">
        <div class="sidebar-brand">
            <a href="index.html">
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
            <x-admin.menu :link="route('admin.theme.index')" :icon="'mdi mdi-format-color-fill'" :active="request()->routeIs('admin.theme.index')">
                {{ __('Theme') }}
            </x-admin.menu>
            <x-admin.menu :link="route('admin.price.index')" :icon="'mdi mdi-cash-multiple'" :active="request()->routeIs('admin.price.index')">
                {{ __('Price') }}
            </x-admin.menu>
            <x-admin.menu :link="route('admin.setting')" :icon="'mdi mdi-cog'" :active="request()->routeIs('admin.setting')">
                {{ __('Setting') }}
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



            {{-- <li class="{{ request()->routeIs('admin.dashboard') ?? false ? 'active' : ''}}">
                <a href="{{route('admin.dashboard')}}" wire:navigate><i class="ti ti-apps me-2"></i>Dashboard</a>
            </li>
            <li class="{{ request()->routeIs('admin.theme') ?? false ? 'active' : ''}}">
                <a href="{{route('admin.theme')}}" wire:navigate><i class="ti ti-apps me-2"></i>Theme</a>
            </li> --}}

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-browser me-2"></i>Layouts</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="index-dark.html">Dark Dashboard</a></li>
                        <li><a href="index-rtl.html">RTL Dashboard</a></li>
                        <li><a href="index-rtl-dark.html">Dark RTL Dashboard</a></li>
                        <li><a href="index-sidebar-light.html">Light Sidebar</a></li>
                        <li><a href="index-sidebar-colored.html">Colored Sidebar</a></li>
                    </ul>
                </div>
            </li>

            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-user me-2"></i>User Profile</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="profile-setting.html">Profile Setting</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-brand-gravatar me-2"></i>Blog</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="blog.html">Blogs</a></li>
                        <li><a href="blog-detail.html">Blog Detail</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-shopping-cart me-2"></i>E-Commerce</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="shop.html">Shop</a></li>
                        <li><a href="product-detail.html">Shop Detail</a></li>
                        <li><a href="shop-cart.html">Shopcart</a></li>
                        <li><a href="checkout.html">Checkout</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-camera me-2"></i>Gallery</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="gallery-one.html">Gallary One</a></li>
                        <li><a href="gallery-two.html">Gallery Two</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-file-info me-2"></i>Pages</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="faqs.html">FAQs</a></li>
                        <li><a href="pricing.html">Pricing</a></li>
                        <li><a href="timeline.html">Timeline</a></li>
                        <li><a href="team.html">Team</a></li>
                        <li><a href="blank-page.html">Blank Page</a></li>
                        <li><a href="privacy.html">Privacy Policy</a></li>
                        <li><a href="terms.html">Term & Condition</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-file-info me-2"></i>UI Components</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="ui-button.html">Buttons</a></li>
                        <li><a href="ui-badges.html">Badges</a></li>
                        <li><a href="ui-alert.html">Alert</a></li>
                        <li><a href="ui-dropdown.html">Dropdowns</a></li>
                        <li><a href="ui-typography.html">Typography</a></li>
                        <li><a href="ui-background.html">Background</a></li>
                        <li><a href="ui-text.html">Text Color</a></li>
                        <li><a href="ui-tooltip-popover.html">Tooltips & Popovers</a></li>
                        <li><a href="ui-shadow.html">Shadows</a></li>
                        <li><a href="ui-border.html">Border</a></li>
                        <li><a href="ui-form.html">Form Elements</a></li>
                        <li><a href="ui-pagination.html">Pagination</a></li>
                        <li><a href="ui-avatar.html">Avatars</a></li>
                        <li><a href="ui-modals.html">Modals</a></li>
                        <li><a href="ui-icons.html">Icons</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-mail-opened me-2"></i>Email Template</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="email-confirmation.html">Confirmation</a></li>
                        <li><a href="email-password-reset.html">Reset Password</a></li>
                        <li><a href="email-alert.html">Alert</a></li>
                        <li><a href="email-invoice.html">Invoice</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-file-invoice me-2"></i>Invoice</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="invoice-list.html">Invoice List</a></li>
                        <li><a href="invoice.html">Invoice Preview</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-login me-2"></i>Authentication</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="login.html">Login</a></li>
                        <li><a href="login-cover.html">Login Two</a></li>
                        <li><a href="signup.html">Signup</a></li>
                        <li><a href="signup-cover.html">Signup Two</a></li>
                        <li><a href="reset-password.html">Reset Password</a></li>
                        <li><a href="reset-password-cover.html">Reset Password Two</a></li>
                        <li><a href="lock-screen.html">Lockscreen</a></li>
                    </ul>
                </div>
            </li>
            <li class="sidebar-dropdown">
                <a href="javascript:void(0)"><i class="ti ti-license me-2"></i>Miscellaneous</a>
                <div class="sidebar-submenu">
                    <ul>
                        <li><a href="comingsoon.html">Comingsoon</a></li>
                        <li><a href="maintenance.html">Maintenance</a></li>
                        <li><a href="error.html">Error</a></li>
                        <li><a href="thankyou.html">Thank You</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <!-- sidebar-menu  -->
    </div>

</nav>
