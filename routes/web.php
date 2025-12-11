<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BulananController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TahunanController;
use App\Http\Controllers\PembayaranLainnyaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SiswaImportController;
use App\Http\Controllers\SppController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update-akun', [ProfileController::class, 'updateAkun'])->name('profile.update.akun');
    Route::patch('/profile/update-siswa', [ProfileController::class, 'updateSiswa'])->name('profile.update.siswa');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    
        Route::resource('siswa', SiswaController::class);
        Route::resource('pembayaran', PembayaranController::class);
        Route::resource('keuangan', KeuanganController::class);
        Route::resource('spp', SppController::class);
        Route::get('/pembayaran/data/{siswa_id}', [PembayaranController::class, 'getTagihan'])->name('getTagihan');
        Route::get('/keuangan/export/pdf', [KeuanganController::class, 'exportPdf'])->name('keuangan.export.pdf');
        Route::get('/pembayaran/export/pdf', [PembayaranController::class, 'exportPdf'])->name('pembayaran.export.pdf');


});

Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->group(function () {

    Route::get('/spp', [SiswaController::class, 'profile'])->name('siswas.index');
});

Route::middleware('auth')->group(function () {
        Route::get('/notifications', [NotificationController::class, 'list'])->name('notifications.list');
        Route::post('/notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.readAll');

});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::post('/siswa/import', [SiswaController::class, 'import'])->name('siswa.import.store');
    Route::post('/siswa/naikkelas', [SiswaController::class, 'naikkelas'])->name('siswa.naikkelas');

});


require __DIR__.'/auth.php';
