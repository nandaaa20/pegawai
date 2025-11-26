<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboard;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\CutiController;


// Redirect ke login
Route::get('/', fn () => redirect('/login'));

Route::middleware('auth')->group(function () {

    // Dashboard otomatis sesuai role
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('pegawai.dashboard');
    })->name('dashboard');

    Route::middleware(['auth', 'role:admin'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            // CRUD Pegawai
            Route::resource('/pegawai', PegawaiController::class);

            // RESET PASSWORD (perhatikan: TIDAK pakai /admin dan TIDAK pakai admin. lagi)
            Route::post('/pegawai/{pegawai}/reset-password', [PegawaiController::class, 'resetPassword'])
                ->name('pegawai.reset-password');

            // Cuti (admin)
            Route::get('/cuti', [CutiController::class, 'index'])
                ->name('cuti.index');
            Route::get('/cuti/{cuti}', [CutiController::class, 'show'])
                ->name('cuti.show');
            Route::post('/cuti/{cuti}/status', [CutiController::class, 'updateStatus'])
                ->name('cuti.updateStatus');

            // Kehadiran (admin)
            Route::get('/kehadiran', [\App\Http\Controllers\Admin\KehadiranController::class, 'index'])
                ->name('kehadiran.index');
            Route::get('/kehadiran/create', [\App\Http\Controllers\Admin\KehadiranController::class, 'create'])
                ->name('kehadiran.create');
            Route::post('/kehadiran', [\App\Http\Controllers\Admin\KehadiranController::class, 'store'])
                ->name('kehadiran.store');
        });


    // Pegawai
    Route::middleware('role:pegawai')
        ->prefix('pegawai')
        ->name('pegawai.')
        ->group(function () {

            Route::get('/dashboard', [\App\Http\Controllers\Pegawai\DashboardController::class, 'index'])
                ->name('dashboard');

            // Cuti (pegawai)
            Route::get('/cuti', [\App\Http\Controllers\Pegawai\CutiController::class, 'index'])
                ->name('cuti.index');
            Route::get('/cuti/create', [\App\Http\Controllers\Pegawai\CutiController::class, 'create'])
                ->name('cuti.create');
            Route::post('/cuti', [\App\Http\Controllers\Pegawai\CutiController::class, 'store'])
                ->name('cuti.store');

            Route::view('/profile', 'pegawai.profile')->name('profile');
        });


    // Profile (bawaan Breeze, boleh dipakai semua role)
    Route::controller(ProfileController::class)
        ->prefix('profile')
        ->name('profile.')
        ->group(function () {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });
});

require __DIR__.'/auth.php';
