<?php

use App\Models\Category;
use App\Livewire\Page\Home;
use App\Livewire\Page\Cetak;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TemaController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\GiftPayController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Dashboard\Transaksi;
use App\Http\Controllers\PriceListController;
use App\Http\Controllers\viewAdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\FilePreviewController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Pay\MidtransController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\DataController;
use App\Http\Controllers\Dashboard\SetupController;
use App\Http\Controllers\Landing\LandingController;
use App\Http\Controllers\Dashboard\UndanganController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Dashboard\KelolaUndangan\AcaraController;
use App\Http\Controllers\Dashboard\KelolaUndangan\Pay\PayController;
use App\Http\Controllers\Dashboard\KelolaUndangan\PengantinController;
use App\Http\Controllers\Dashboard\KelolaUndangan\ViewKelolaUndanganController;
use App\Livewire\Page\UndanganAnimasi;
use App\Livewire\Page\UndanganWeb;

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
Route::get('/undangan/cetak', Cetak::class)->name('cetak');
Route::get('/undangan/web', UndanganWeb::class)->name('web');
Route::get('/undangan/animasi', UndanganAnimasi::class)->name('animasi');
Route::get('/explore', [ExploreController::class, 'explore'])->name('explore');
// Route::get('/cetak', [ExploreController::class, 'explore'])->name('explore');

// Route::get('/preview-file/{filename}', [FilePreviewController::class, 'show'])
//     ->name('preview-file');

Route::post('/auth-api', [ApiAuthController::class, 'login']);

Route::prefix('')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login-auth', [LoginController::class, 'login'])->name('login.auth');
    Route::get('/forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot.password');
});
Route::resource('register', RegisterController::class);
Route::post('/check-name', [SetupController::class, 'checkName'])->name('checkName');


// Route::get('/{slug}', [TemaController::class, 'index'])->name('tema');

Route::get('/u/{slug}/{tamu?}', [TemaController::class, 'visit'])->name('visit');
Route::post('u/savedoa', [TemaController::class, 'saveDoa'])->name('savedoa');

// Role User
Route::middleware(['auth', 'role:User', 'setup.complete'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/setup', [SetupController::class, 'index'])->name('setup');
    // Route::view('/', 'user.dashboard')->name('dashboard');
    Route::resource('data', DataController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('/', UndanganController::class);
    Route::resource('transaksi', Transaksi::class);


    // Kelola Undangan
    Route::get('/kelola/{id}', [UndanganController::class, 'kelola'])->name('undangan.kelola');
    Route::get('/kelola/{id}/pengantin', [ViewKelolaUndanganController::class, 'pengantin'])->name('undangan.pengantin');
    Route::get('/kelola/{id}/acara', [ViewKelolaUndanganController::class, 'acara'])->name('undangan.acara');
    Route::get('/kelola/{id}/galeri', [ViewKelolaUndanganController::class, 'galery'])->name('undangan.galery');
    Route::get('/kelola/{id}/musik', [ViewKelolaUndanganController::class, 'sound'])->name('undangan.musik');
    Route::get('/kelola/{id}/ucapan', [ViewKelolaUndanganController::class, 'ucapan'])->name('undangan.ucapan');
    Route::get('/kelola/{id}/tamu', [ViewKelolaUndanganController::class, 'tamu'])->name('undangan.tamu');
    Route::get('/kelola/{id}/streaming', [ViewKelolaUndanganController::class, 'streaming'])->name('undangan.streaming');
    Route::get('/kelola/{id}/kado', [ViewKelolaUndanganController::class, 'kado'])->name('undangan.kado');
    Route::get('/kelola/{id}/kisah-cinta', [ViewKelolaUndanganController::class, 'kisah'])->name('undangan.kisah');
    Route::get('/kelola/{id}/setting', [ViewKelolaUndanganController::class, 'setting'])->name('undangan.setting');
    Route::get('/kelola/{id}/buku-tamu', [ViewKelolaUndanganController::class, 'bukutamu'])->name('undangan.bukutamu');
    Route::get('/kelola/{id}/tema', [ViewKelolaUndanganController::class, 'tema'])->name('undangan.tema');
    Route::get('/demo/{demo}/{id}', [TemaController::class, 'demo'])->name('demo');
    Route::get('/pay/{id}', [PayController::class, 'index'])->name('pay');

    
    Route::get('/midtrans/finish', [MidtransController::class, 'finishRedirect']);
    Route::get('/midtrans/unfinished', [MidtransController::class, 'unfinishRedirect']);
    Route::get('/midtrans/failed', [MidtransController::class, 'errorRedirect']);
});
Route::post('/midtrans/callback', [MidtransController::class, 'notificationHandler']);

// Role Admin
Route::middleware(['auth', 'role:Owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.admin')->name('admin');
    Route::resource('theme', ThemeController::class);
    Route::get('/setting', [CategoryController::class, 'index'])->name('setting');
    Route::resource('categories', CategoryController::class)->except('index');
    Route::resource('price', PriceListController::class)->except('destroy', 'update');
    Route::post('/price/update', [PriceListController::class, 'update'])->name('price.update');
    Route::delete('/price/{id}', [PriceListController::class, 'destroy'])->name('price.destroy');
    Route::resource('giftpay', GiftPayController::class)->except('index');
    Route::get('/pay-setting/', [viewAdminController::class, 'index'])->name('pay.setting');
    Route::get('/harga', [viewAdminController::class, 'harga'])->name('harga');
    Route::get('/animation', [viewAdminController::class, 'animation'])->name('animation');
    Route::get('/cetak', [viewAdminController::class, 'undangancetak'])->name('cetak');
    Route::get('/demo/{demo}', [TemaController::class, 'temademo'])->name('temademo');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';
