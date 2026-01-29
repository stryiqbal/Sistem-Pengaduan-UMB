<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PengaduanController as AdminPengaduanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [LandingController::class, 'index'])
    ->name('landing');

Route::get('/fasilitas', [FasilitasController::class, 'index'])
    ->name('fasilitas.index');

/*
|--------------------------------------------------------------------------
| Pengaduan Routes
|--------------------------------------------------------------------------
*/

// Redirect jika akses /pengaduan tanpa parameter
Route::get('/pengaduan', function () {
    return redirect()->route('fasilitas.index');
});

// Form pengaduan berdasarkan kategori
Route::get('/pengaduan/{id}', [PengaduanController::class, 'create'])
    ->name('pengaduan.form');

// Simpan pengaduan
Route::post('/pengaduan', [PengaduanController::class, 'store'])
    ->name('pengaduan.store');

// Halaman sukses
Route::get('/pengaduan-sukses/{id}', [PengaduanController::class, 'success'])
    ->name('pengaduan.sukses');

/*
|--------------------------------------------------------------------------
| Tracking Pengaduan
|--------------------------------------------------------------------------
*/

Route::get('/tracking', [PengaduanController::class, 'trackingForm'])
    ->name('pengaduan.tracking.form');

Route::post('/tracking', [PengaduanController::class, 'trackingResult'])
    ->name('pengaduan.tracking.result');

Route::get('/pengaduan', [PengaduanController::class, 'index'])
    ->name('pengaduan.index');

Route::get('/pengaduan/{id}/detail', [PengaduanController::class, 'show'])
    ->name('pengaduan.show');

Route::prefix('admin')->group(function () {

    // login
    Route::get('/login', [AuthController::class, 'login'])
        ->name('admin.login');

    Route::post('/login', [AuthController::class, 'authenticate']);

    Route::middleware('admin')->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/pengaduan', [AdminPengaduanController::class, 'index'])
            ->name('admin.pengaduan.index');

        Route::get('/pengaduan/{id}', [AdminPengaduanController::class, 'show'])
            ->name('admin.pengaduan.show');

        Route::post('/pengaduan/{id}/status', [AdminPengaduanController::class, 'updateStatus'])
            ->name('admin.pengaduan.status');

        Route::post('/logout', [AuthController::class, 'logout'])
            ->name('admin.logout');
    });
});