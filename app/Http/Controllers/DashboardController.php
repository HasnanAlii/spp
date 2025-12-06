<?php

namespace App\Http\Controllers;

use App\Models\SppSiswa;
use App\Models\Pembayaran;
use App\Models\Keuangan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $user = Auth::user();


        if ($user->hasRole('admin')) {

            $siswaBelumBayar = SppSiswa::where('sisa_tagihan', '>', 0)
                ->distinct('siswa_id')
                ->count('siswa_id');

            $totalPembayaranBulanIni = Pembayaran::whereMonth('tanggal_bayar', $now->month)
                ->whereYear('tanggal_bayar', $now->year)
                ->count('id');

            $arusMasuk = Keuangan::where('arus_dana', 'masuk')
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->sum('jumlah');

            $arusKeluar = Keuangan::where('arus_dana', 'keluar')
                ->whereMonth('created_at', $now->month)
                ->whereYear('created_at', $now->year)
                ->sum('jumlah');

            return view('dashboard', compact(
                'siswaBelumBayar',
                'totalPembayaranBulanIni',
                'arusMasuk',
                'arusKeluar'
            ));
        }

        if ($user->hasRole('siswa')) {

            $siswaId = $user->id;

            $sisaTagihan = SppSiswa::where('siswa_id', $siswaId)->sum('sisa_tagihan');

            $pembayaranBulanIni = Pembayaran::where('siswa_id', $siswaId)
                ->whereMonth('tanggal_bayar', $now->month)
                ->whereYear('tanggal_bayar', $now->year)
                ->exists();

            $totalDibayar = Pembayaran::where('siswa_id', $siswaId)->sum('jumlah_bayar');

            $riwayat = Pembayaran::where('siswa_id', $siswaId)
                ->latest()
                ->take(10)
                ->get();

            return view('dashboard_siswa', compact(
                'sisaTagihan',
                'pembayaranBulanIni',
                'totalDibayar',
                'riwayat'
            ));
        }

        abort(403, 'Role tidak dikenali');
    }
}
