<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $halaman = session('halaman', 'Default Title');
            $view->with('halaman', $halaman);
        });

        // Livewire Component Aliases
        Livewire::component('dashboard-demo.kelola.pay.pay', \App\Livewire\DashboardDemo\Kelola\Pay\Pay::class);
        Livewire::component('dashboard.kelola.pay.pay', \App\Livewire\DashboardDemo\Kelola\Pay\Pay::class);
    }
}
