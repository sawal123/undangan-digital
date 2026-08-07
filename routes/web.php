<?php

use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\DataController;
use App\Http\Controllers\Dashboard\KelolaUndangan\Pay\PayController;
use App\Http\Controllers\Dashboard\SetupController;
use App\Http\Controllers\ExploreController;
use App\Http\Controllers\FilePreviewController;
use App\Http\Controllers\Pay\MidtransController;
use App\Http\Controllers\TemaController;
use App\Livewire\Page\Cetak;
use App\Livewire\Page\Home;
use App\Livewire\Page\UndanganAnimasi;
use App\Livewire\Page\UndanganWeb;
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
Route::get('/undangan/cetak', Cetak::class)->name('cetak');
Route::get('/undangan/web', UndanganWeb::class)->name('web');
Route::get('/demo/{demo}', [TemaController::class, 'temademo']);
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
Route::post('u/savedoa', [TemaController::class, 'saveDoa'])->middleware('throttle:10,1')->name('savedoa');

// Role User
Route::middleware(['auth', 'not.suspended', 'role:User', 'setup.complete'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/setup', [SetupController::class, 'index'])->name('setup');
    Route::get('/add-undangan/{id}', [SetupController::class, 'add'])->name('add');
    Route::resource('data', DataController::class)->only(['store']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/', \App\Livewire\DashboardDemo\Index::class)->name('index');
    Route::get('/transaksi', \App\Livewire\DashboardDemo\Transaksi::class)->name('transaksi.index');

    // Kelola Undangan
    Route::get('/kelola/{id}', \App\Livewire\DashboardDemo\Kelola\Index::class)->name('undangan.kelola');
    Route::get('/kelola/{id}/pengantin', \App\Livewire\DashboardDemo\Kelola\Pengantin::class)->name('undangan.pengantin');
    Route::get('/kelola/{id}/birthday', \App\Livewire\DashboardDemo\Kelola\Birthday::class)->name('undangan.birthday');
    Route::get('/kelola/{id}/detail-event', \App\Livewire\DashboardDemo\Kelola\EventDetail::class)->name('undangan.event-detail');
    Route::get('/kelola/{id}/acara', \App\Livewire\DashboardDemo\Kelola\Acara::class)->name('undangan.acara');
    Route::get('/kelola/{id}/galeri', \App\Livewire\DashboardDemo\Kelola\Galery::class)->name('undangan.galery');
    Route::get('/kelola/{id}/musik', \App\Livewire\DashboardDemo\Kelola\Sound::class)->name('undangan.musik');
    Route::get('/kelola/{id}/ucapan', \App\Livewire\DashboardDemo\Kelola\Ucapan::class)->name('undangan.ucapan');
    Route::get('/kelola/{id}/tamu', \App\Livewire\DashboardDemo\Kelola\Tamu::class)->name('undangan.tamu');
    Route::get('/kelola/{id}/streaming', \App\Livewire\DashboardDemo\Kelola\Streaming::class)->name('undangan.streaming');
    Route::get('/kelola/{id}/kado', \App\Livewire\DashboardDemo\Kelola\Kado::class)->name('undangan.kado');
    Route::get('/kelola/{id}/kisah-cinta', \App\Livewire\DashboardDemo\Kelola\Kisah::class)->name('undangan.kisah');
    Route::get('/kelola/{id}/setting', \App\Livewire\DashboardDemo\Kelola\Setting::class)->name('undangan.setting');
    Route::get('/kelola/{id}/buku-tamu', \App\Livewire\DashboardDemo\Kelola\BukuTamu::class)->name('undangan.bukutamu');
    Route::get('/kelola/{id}/tema', \App\Livewire\DashboardDemo\Kelola\Tema::class)->name('undangan.tema');
    Route::get('/demo/{token}', [TemaController::class, 'demo'])->name('demo');
    Route::get('/pay/{id}', [PayController::class, 'index'])->name('pay');

    Route::get('/midtrans/finish', [MidtransController::class, 'finishRedirect']);
    Route::get('/midtrans/unfinished', [MidtransController::class, 'unfinishRedirect']);
    Route::get('/midtrans/failed', [MidtransController::class, 'errorRedirect']);

    Route::get('/finishtunai/{id}', [PayController::class, 'tunai'])->name('tunai');
});
Route::post('/midtrans/callback', [MidtransController::class, 'notificationHandler']);

// Role Admin
Route::middleware(['auth', 'not.suspended', 'security.admin.access', 'role:Owner'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', \App\Livewire\AdminDemo\DashboardDemo::class)->name('admin');
    Route::get('/theme', \App\Livewire\AdminDemo\ThemeDemo::class)->name('theme');
    Route::get('/setting', \App\Livewire\AdminDemo\CategoryDemo::class)->name('setting');
    Route::get('/price', \App\Livewire\AdminDemo\HargaDemo::class)->name('price');
    Route::get('/harga', \App\Livewire\AdminDemo\HargaDemo::class)->name('harga');
    Route::get('/pay-setting', \App\Livewire\AdminDemo\PaySettingDemo::class)->name('pay.setting');
    Route::get('/transaksi', \App\Livewire\AdminDemo\TransaksiDemo::class)->name('transaksi');
    Route::get('/user', \App\Livewire\AdminDemo\UserDemo::class)->name('user');
    Route::get('/security', \App\Livewire\AdminDemo\SecurityMonitoringDemo::class)->name('security');
    Route::get('/animation', \App\Livewire\AdminDemo\AnimationDemo::class)->name('animation');
    Route::get('/fonts', \App\Livewire\AdminDemo\FontsDemo::class)->name('fonts');
    Route::get('/cetak', \App\Livewire\AdminDemo\CetakDemo::class)->name('cetak');
    Route::get('/system-setting', \App\Livewire\AdminDemo\SystemSettingDemo::class)->name('system.setting');
    Route::get('/demo/{demo}', [TemaController::class, 'temademo'])->name('temademo');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';
