<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\ThemeController;
use App\Livewire\Page\Home;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Landing Page
Route::get('/', Home::class)->name('home');
Route::get('/explore', [ExploreController::class, 'explore'])->name('explore');

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login-auth', [LoginController::class, 'login'])->name('login.auth');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');

// Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::view('/signin', 'page.auth.login')->name('sigin');




Route::middleware(['auth','role:Owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');
    // Route::view('/theme', 'admin.theme')->name('theme');
    Route::resource('theme', ThemeController::class);

    
    Route::get('/setting', [CategoryController::class, 'index'])->name('setting');
    Route::resource('categories', CategoryController::class)->except('index');

    Route::resource('price', PriceListController::class)->except('destroy','update');
    Route::post('/price/update', [PriceListController::class, 'update'])->name('price.update');
    Route::delete('/price/{id}', [PriceListController::class, 'destroy'])->name('price.destroy');
    
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
