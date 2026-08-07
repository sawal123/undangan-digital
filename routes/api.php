<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UndanganCetakController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| API Undangan Cetak (Protected by API Key)
|--------------------------------------------------------------------------
*/
Route::middleware(['api.key'])->prefix('v1')->name('api.v1.')->group(function () {
    // Undangan Cetak CRUD
    Route::apiResource('undangan-cetak', UndanganCetakController::class);

    // Hapus gambar tertentu dari undangan cetak
    Route::delete('undangan-cetak/{id}/gambar/{imageIndex}', [UndanganCetakController::class, 'deleteImage'])
        ->name('undangan-cetak.delete-image');
});
