<?php

use App\Models\Category;
use App\Livewire\Page\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\GiftPayController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Auth\ForgotPasswordController;
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
// Route::view('/signin', 'page.auth.login')->name('sigin');
Route::post('/check-name', [SetupController::class, 'checkName'])->name('checkName');
Route::middleware(['auth', 'role:User', 'setup.complete'])->prefix('dashboard')->name('dashboard.')->group(function(){
    Route::get('/setup', [SetupController::class, 'index'])->name('setup');
    Route::view('/', 'user.dashboard')->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});




Route::middleware(['auth','role:Owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.admin')->name('admin');
    Route::resource('theme', ThemeController::class);
    Route::get('/setting', [CategoryController::class, 'index'])->name('setting');
    Route::resource('categories', CategoryController::class)->except('index');
    Route::resource('price', PriceListController::class)->except('destroy','update');
    Route::post('/price/update', [PriceListController::class, 'update'])->name('price.update');
    Route::delete('/price/{id}', [PriceListController::class, 'destroy'])->name('price.destroy');
    Route::resource('giftpay', GiftPayController::class)->except('index');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
