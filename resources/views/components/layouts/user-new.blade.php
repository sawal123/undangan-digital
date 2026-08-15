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
    <x-seo-meta :title="$title ?? 'Dashboard'" robots="noindex,nofollow" />

    <!-- Tailwind CSS (Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Google Fonts (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        * { font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #94a3b8; border-radius: 3px; }
        .dark ::-webkit-scrollbar-thumb { background: #475569; }
        .sidebar-transition { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .card-lift { transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .card-lift:hover { transform: translateY(-2px); }
        .btn-ripple { position: relative; overflow: hidden; }
        .sidebar-link.active {
            background-color: #4f46e5;
            color: white;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        }
        .dark .sidebar-link.active {
            background-color: #6366f1;
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        /* Dark Mode Compatibility for Legacy Bootstrap Components */
        .dark .modal-content {
            background-color: #0f172a;
            color: #f1f5f9;
            border: 1px solid #1e293b;
        }
        .dark .modal-header, .dark .modal-footer {
            border-color: #1e293b;
        }
        .dark .modal-title {
            color: white;
        }
        .dark .btn-close {
            filter: invert(1) grayscale(100%) brightness(200%);
        }
        .dark .form-control, .dark .form-select {
            background-color: #020617;
            border-color: #1e293b;
            color: #e2e8f0;
        }
        .dark .form-control:focus, .dark .form-select:focus {
            background-color: #020617;
            border-color: #4f46e5;
            color: white;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.2);
        }
        .dark .form-label {
            color: #94a3b8;
        }
        .dark .text-dark {
            color: #f1f5f9 !important;
        }
    </style>
    @livewireStyles
</head>

<body class="bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 h-screen overflow-hidden transition-colors duration-300">
    @php($sysSetting = \App\Models\SystemSetting::current())
    <div class="flex h-full">
        <!-- Sidebar Overlay (Mobile) -->
        <div x-show="sidebarOpen" x-cloak x-on:click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-40 lg:hidden transition-opacity" aria-hidden="true"></div>

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed lg:sticky top-0 left-0 z-50 w-64 h-full flex flex-col shadow-lg lg:shadow-none sidebar-transition transition-colors duration-300 border-r border-slate-200 dark:border-slate-800"
            :class="[
                sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
                darkMode ? 'bg-slate-900' : 'bg-white'
            ]">

            <!-- Logo -->
            <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-200 dark:border-slate-700 flex-shrink-0">
                <a href="/" class="flex items-center gap-2 w-full">
                    <img src="{{ $sysSetting->logo_url ?? asset('logo/logo.svg') }}" height="40" class="h-10 max-w-[160px] object-contain" alt="{{ $sysSetting->app_name ?? 'WayaeNikah' }}">
                </a>
                <button x-on:click="sidebarOpen = false"
                    class="lg:hidden p-1.5 rounded-md hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-500 transition-colors"
                    aria-label="Tutup Menu">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Menu Utama</p>
                <a href="{{ route('dashboard.index') }}" wire:navigate
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('dashboard.index') || request()->is('dashboard/kelola/*') ? 'active' : '' }}">
                    <i data-lucide="mail" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Undangan</span>
                </a>
                <a href="{{ route('dashboard.transaksi.index') }}" wire:navigate
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all {{ request()->routeIs('dashboard.transaksi.index') ? 'active' : '' }}">
                    <i data-lucide="shopping-cart" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Transaksi</span>
                </a>
                
                <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Bantuan</p>
                @php($waNumber = config('services.contact.whatsapp', '6282274677715'))
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $waNumber) }}" target="_blank" rel="noopener noreferrer"
                   class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    <i data-lucide="phone" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="text-sm font-medium">Customer Service</span>
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4 border-t border-slate-200 dark:border-slate-700 flex-shrink-0">
                <div class="flex items-center gap-3 px-2 py-2 rounded-lg bg-slate-100 dark:bg-slate-800">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-indigo-600 dark:text-indigo-400 font-semibold text-xs">{{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 2)) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs text-slate-700 dark:text-slate-200 font-medium truncate">
                            {{ auth()->user()->name ?? 'User' }}
                        </p>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400 truncate">
                            {{ auth()->user()->email ?? 'user@example.com' }}
                        </p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">
            <!-- Header -->
            <header class="sticky top-0 z-30 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-sm flex-shrink-0">
                <div class="flex items-center justify-between px-4 lg:px-6 py-3">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <button x-on:click="sidebarOpen = true"
                            class="lg:hidden p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition-colors"
                            aria-label="Buka Menu">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>
                        @php($currentInvitationId = request()->route('id'))
                        @if($currentInvitationId && request()->is('dashboard/kelola/*/acara', 'dashboard/kelola/*/pengantin', 'dashboard/kelola/*/birthday', 'dashboard/kelola/*/detail-event', 'dashboard/kelola/*/galeri', 'dashboard/kelola/*/musik', 'dashboard/kelola/*/ucapan', 'dashboard/kelola/*/tamu', 'dashboard/kelola/*/streaming', 'dashboard/kelola/*/kado', 'dashboard/kelola/*/kisah-cinta', 'dashboard/kelola/*/setting', 'dashboard/kelola/*/buku-tamu', 'dashboard/kelola/*/tema'))
                            <a href="{{ route('dashboard.undangan.kelola', $currentInvitationId) }}" wire:navigate
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-slate-600 dark:text-slate-300 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 rounded-xl transition-all">
                                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                                <span class="hidden sm:inline">Kembali</span>
                            </a>
                        @endif
                        <h2 class="text-lg font-bold text-slate-800 dark:text-white hidden sm:block">{{ $headerTitle ?? 'Dashboard' }}</h2>
                    </div>

                    <div class="flex items-center gap-2 flex-shrink-0">
                        <button x-on:click="toggleTheme()"
                            class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 transition-all"
                            aria-label="Beralih Mode Gelap/Terang">
                            <i x-show="!darkMode" data-lucide="moon" class="w-5 h-5"></i>
                            <i x-show="darkMode" x-cloak data-lucide="sun" class="w-5 h-5"></i>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative ml-1" x-data="{ open: false }" x-on:keydown.escape.window="open = false">
                            <button x-on:click="open = !open"
                                class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 transition-all"
                                aria-label="Menu Pengguna">
                                <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white font-semibold text-sm ring-2 ring-indigo-200 dark:ring-indigo-800">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'US', 0, 2)) }}
                                </div>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-200 hidden md:inline">{{ auth()->user()->name ?? 'User' }}</span>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400 hidden md:block transition-transform" :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <div x-show="open" x-cloak x-on:click.away="open = false"
                                class="absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg py-1 z-50">
                                <a href="{{ route('profile') }}"
                                    class="flex items-center gap-2 px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">
                                    <i data-lucide="user" class="w-4 h-4"></i> Profil Saya
                                </a>
                                <hr class="border-slate-200 dark:border-slate-700 my-1">
                                <form method="POST" action="{{ route('dashboard.logout') }}">
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
        (() => {
            // Inisialisasi Lucide terpusat untuk seluruh halaman dashboard.
            const initIcons = () => {
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            };

            // Initial render
            document.addEventListener('DOMContentLoaded', initIcons);
            document.addEventListener('livewire:navigated', initIcons);

            // Jalankan ulang Lucide setelah setiap Livewire DOM morph selesai
            // (submit, save/update, delete, toggle/switch, pagination, search,
            // modal yang dirender ulang, dan nested component seperti Pria/Wanita).
            const registerMorphHook = () => {
                if (!window.Livewire || window.__lucideMorphHookRegistered) {
                    return;
                }

                window.__lucideMorphHookRegistered = true;

                window.Livewire.hook('morphed', () => {
                    // Tunggu sampai DOM benar-benar stabil setelah morph.
                    requestAnimationFrame(() => requestAnimationFrame(initIcons));
                });
            };

            registerMorphHook();
            document.addEventListener('livewire:initialized', registerMorphHook);
        })();
    </script>
</body>
</html>
