<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BulananController;
use App\Http\Controllers\TahunanController;
use App\Http\Controllers\PembayaranLainnyaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\SppController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    // Route::get('/dashboard', function () {
    //     $role = Auth::user()->role; 
        
    //     if ($role === 'admin') {
    //         return view('admin.dashboard'); // Pastikan view ini ada
    //     } elseif ($role === 'siswa') {
    //         return view('siswa.dashboard'); // Pastikan view ini ada
    //     }
        
    //     abort(403, 'Role tidak dikenali.');
    // })->name('dashboard');



    Route::prefix('admin')->group(function () {
        Route::resource('siswa', SiswaController::class);
        Route::resource('pembayaran', PembayaranController::class);
        Route::resource('keuangan', KeuanganController::class);
        Route::resource('spp', SppController::class);

        Route::get('/pembayaran/data/{siswa_id}', [PembayaranController::class, 'getTagihan'])->name('getTagihan');

    });


    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
        Route::get('/profil', [SiswaController::class, 'showMyProfile'])->name('profil');
        Route::get('/riwayat-pembayaran', [PembayaranController::class, 'historySiswa'])->name('pembayaran.history');
    });

});



require __DIR__.'/auth.php';
