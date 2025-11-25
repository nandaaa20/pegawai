<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Pegawai\DashboardController as PegawaiDashboard;
use App\Http\Controllers\Admin\PegawaiController;

// Redirect ke login
Route::get('/', fn () => redirect('/login'));

Route::middleware('auth')->group(function () {

    // Dashboard otomatis sesuai role
    Route::get('/dashboard', function () {
        return auth()->user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('pegawai.dashboard');
    })->name('dashboard');

    // Admin
    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('/pegawai', PegawaiController::class);
        });

    // Pegawai
    Route::middleware('role:pegawai')->group(function () {
        Route::get('/pegawai/dashboard', [PegawaiDashboard::class, 'index'])
            ->name('pegawai.dashboard');
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
