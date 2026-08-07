<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches),
    sidebarOpen: false,
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
    }
}" :class="{ 'dark': darkMode }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- SEO & Metadata -->
    <x-seo-meta :title="$title ?? 'Admin Panel'" robots="noindex,nofollow" />

    <!-- Tailwind CSS (Vite or CDN as fallback) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            // Custom colors if needed
                        }
                    }
                }
            }
        </script>
    @endif

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        [x-cloak] {
            display: none !important;
        }

        * {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 3px;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #475569;
        }

        .sidebar-transition {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card-lift:hover {
            transform: translateY(-2px);
        }

        .btn-ripple {
            position: relative;
            overflow: hidden;
        }

        .sidebar-link.active {
            background-color: rgba(99, 102, 241, 0.1);
            color: #4f46e5;
            font-weight: 500;
        }

        .dark .sidebar-link.active {
            background-color: rgba(99, 102, 241, 0.2);
            color: #a5b4fc;
        }
    </style>
    @livewireStyles
</head>

<body class="bg-slate-50 dark:bg-slate-900 text-slate-800 dark:text-slate-200 h-screen overflow-hidden">
    <div class="flex h-full">
        <!-- Sidebar Overlay (Mobile) -->
        <div x-show="sidebarOpen" x-cloak x-on:click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity" aria-hidden="true"></div>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed lg:sticky top-0 left-0 z-50 w-64 h-full flex flex-col shadow-lg lg:shadow-none sidebar-transition transition-colors duration-300 border-r border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">

            <!-- Logo -->
            @php $currentSetting = \App\Models\SystemSetting::current(); @endphp
            <div
                class="flex items-center gap-3 px-5 py-5 border-b border-slate-200 dark:border-slate-700 flex-shrink-0">
                @if ($currentSetting->logo_url)
                    <img src="{{ $currentSetting->logo_url }}" class="w-9 h-9 object-contain rounded-lg flex-shrink-0"
                        alt="Logo">
                @else
                    <div class="w-9 h-9 bg-indigo-500 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i data-lucide="layers" class="w-5 h-5 text-white"></i>
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <h1 class="text-slate-900 dark:text-white font-bold text-lg leading-tight truncate">
                        {{ $currentSetting->app_name }}
                    </h1>
                    <p class="text-slate-500 dark:text-slate-400 text-xs">Admin Panel</p>
                </div>
                <button x-on:click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-500 transition-colors">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>
                <a href="{{ route('admin.admin') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.admin') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.theme') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.theme') ? 'active' : '' }}">
                    <i data-lucide="palette" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Theme</span>
                </a>
                <a href="{{ route('admin.fonts') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.fonts') ? 'active' : '' }}">
                    <i data-lucide="type" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Fonts</span>
                </a>
                <a href="{{ route('admin.music') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.music') ? 'active' : '' }}">
                    <i data-lucide="music" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Musik</span>
                </a>
                <a href="{{ route('admin.animation') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.animation') ? 'active' : '' }}">
                    <i data-lucide="video" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Undangan Animasi</span>
                </a>
                <a href="{{ route('admin.cetak') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.cetak') ? 'active' : '' }}">
                    <i data-lucide="package" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Undangan Cetak</span>
                </a>
                <a href="{{ route('admin.harga') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.harga') ? 'active' : '' }}">
                    <i data-lucide="banknote" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Harga</span>
                </a>
                <a href="{{ route('admin.transaksi') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.transaksi') ? 'active' : '' }}">
                    <i data-lucide="credit-card" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Transaksi</span>
                </a>
                <a href="{{ route('admin.user') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.user') ? 'active' : '' }}">
                    <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">User</span>
                </a>
                <a href="{{ route('admin.security') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.security') ? 'active' : '' }}">
                    <i data-lucide="shield-alert" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Keamanan</span>
                </a>
                <a href="{{ route('admin.setting') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.setting') ? 'active' : '' }}">
                    <i data-lucide="settings" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Setting</span>
                </a>
                <a href="{{ route('admin.system.setting') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.system.setting') ? 'active' : '' }}">
                    <i data-lucide="sliders" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Setting System</span>
                </a>
                <a href="{{ route('admin.pay.setting') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('admin.pay.setting') ? 'active' : '' }}">
                    <i data-lucide="wallet" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Gift Pay Setting</span>
                </a>
                <!-- Add more links as needed -->
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-700 flex-shrink-0">
                <div class="flex items-center gap-3 px-2 py-2 rounded-lg bg-slate-100 dark:bg-slate-800">
                    <div
                        class="w-8 h-8 bg-slate-300 dark:bg-slate-600 rounded-full flex items-center justify-center flex-shrink-0">
                        <i data-lucide="user" class="w-4 h-4 text-slate-600 dark:text-slate-300"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-slate-700 dark:text-slate-200 font-medium truncate">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </p>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">
                            {{ auth()->user()->role ?? 'Administrator' }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Header -->
            <header
                class="sticky top-0 z-30 bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 shadow-sm flex-shrink-0">
                <div class="flex items-center justify-between px-4 lg:px-6 py-3">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <button x-on:click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition-colors">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        <div class="relative max-w-md w-full hidden sm:block">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                            </div>
                            <input type="text" placeholder="Cari apa saja..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-800 dark:text-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all">
                        </div>
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0">
                        <button
                            class="relative p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition-all">
                            <i data-lucide="bell" class="w-5 h-5"></i>
                            <span
                                class="absolute top-1.5 right-1.5 w-2 h-2 bg-rose-500 rounded-full ring-2 ring-white dark:ring-slate-800"></span>
                        </button>

                        <button x-on:click="toggleTheme()"
                            class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition-all">
                            <i x-show="!darkMode" data-lucide="moon" class="w-5 h-5"></i>
                            <i x-show="darkMode" x-cloak data-lucide="sun" class="w-5 h-5"></i>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative ml-1" x-data="{ open: false }">
                            <button x-on:click="open = !open"
                                class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-all">
                                <div
                                    class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white font-semibold text-sm ring-2 ring-indigo-200 dark:ring-indigo-800">
                                    {{ substr(auth()->user()->name ?? 'AD', 0, 2) }}
                                </div>
                                <span
                                    class="text-sm font-medium text-slate-700 dark:text-slate-200 hidden md:inline">{{ auth()->user()->name ?? 'Admin' }}</span>
                                <i data-lucide="chevron-down"
                                    class="w-4 h-4 text-slate-400 hidden md:block transition-transform"
                                    :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open" x-cloak x-on:click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg py-1 z-50">
                                <a href="{{ route('profile') }}" wire:navigate
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                    <i data-lucide="user" class="w-4 h-4"></i> Profil Saya
                                </a>
                                <hr class="border-slate-200 dark:border-slate-700 my-1">
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="w-full flex items-center gap-2 px-4 py-2 text-sm text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/30 transition-colors text-left">
                                        <i data-lucide="log-out" class="w-4 h-4"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content -->
            <main class="flex-1 p-4 lg:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('livewire:navigated', () => {
            lucide.createIcons();
        });
        document.addEventListener('DOMContentLoaded', () => {
            lucide.createIcons();
        });
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', ({
                el,
                component
            }) => {
                lucide.createIcons();
            });
        });
        // Initial call for the first load
        lucide.createIcons();
    </script>
</body>

</html>
