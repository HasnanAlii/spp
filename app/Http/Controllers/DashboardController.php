<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\SppSiswa;
use App\Models\Pembayaran;
use App\Models\Keuangan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $user = Auth::user();

        $selectedMonth = (int) $request->get('month', $now->month);
        $selectedYear  = (int) $request->get('year', $now->year);

        // data untuk dropdown bulan (1..12) -> label bahasa Indonesia
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        // data untuk dropdown tahun (mis. rentang sekarang -5 sampai sekarang +1)
        $currentYear = (int) $now->year;
        $startYear = $currentYear - 5;
        $endYear = $currentYear + 1;
        $years = range($startYear, $endYear);

        if ($user->hasRole('admin')) {

            // $siswaBelumBayar = SppSiswa::where('sisa_tagihan', '>', 0)
            //     ->whereMonth('updated_at', $selectedMonth)
            //     ->whereYear('updated_at', $selectedYear)
            //     ->distinct()
            //     ->count('siswa_id');
            $oneMonthAgo = now()->subMonth();
            $oneYearAgo  = now()->subYear();

            $siswaBelumBayar = SppSiswa::where('sisa_tagihan', '>', 0)
                ->where(function ($q) use ($oneMonthAgo, $oneYearAgo) {

                    // BULANAN → menunggak jika >1 bulan
                    $q->where(function ($sub) use ($oneMonthAgo) {
                        $sub->where('tipe', 'bulanan')
                            ->where('created_at', '<=', $oneMonthAgo);
                    })

                    // TAHUNAN → menunggak jika >1 tahun
                    ->orWhere(function ($sub) use ($oneYearAgo) {
                        $sub->where('tipe', 'tahunan')
                            ->where('created_at', '<=', $oneYearAgo);
                    })

                    // LAINNYA → perlakuan sama seperti tahunan (>1 tahun)
                    ->orWhere(function ($sub) use ($oneYearAgo) {
                        $sub->where('tipe', 'lainnya')
                            ->where('created_at', '<=', $oneYearAgo);
                    });
                })
                ->distinct()
                ->count('siswa_id');

            $totalPembayaranBulanIni = Pembayaran::whereMonth('tanggal_bayar', $selectedMonth)
                ->whereYear('tanggal_bayar', $selectedYear)
                ->count('id');

            $totalPembayaran = Pembayaran::whereMonth('tanggal_bayar', $selectedMonth)
                ->whereYear('tanggal_bayar', $selectedYear)
                ->sum('jumlah_bayar');

            $arusMasuk = Keuangan::where('arus_dana', 'masuk')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->sum('jumlah');

            $arusKeluar = Keuangan::where('arus_dana', 'keluar')
                ->whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->sum('jumlah');

            $logs = Keuangan::whereMonth('created_at', $selectedMonth)
                ->whereYear('created_at', $selectedYear)
                ->latest()
                ->take(5)
                ->get();

            // $totalSisaTunggakan = SppSiswa::where('sisa_tagihan', '>', 0)
            //     ->whereMonth('updated_at', $selectedMonth)
            //     ->whereYear('updated_at', $selectedYear)
            //     ->sum('sisa_tagihan');
            
            $totalSisaTunggakan = SppSiswa::where('sisa_tagihan', '>', 0)
            ->where(function ($q) use ($oneMonthAgo, $oneYearAgo) {
                // BULANAN -> overdue bila dibuat > 1 bulan lalu
                $q->where(function ($sub) use ($oneMonthAgo) {
                    $sub->where('tipe', 'bulanan')
                        ->where('created_at', '<=', $oneMonthAgo);
                });

                // TAHUNAN -> overdue bila dibuat > 1 tahun lalu
                $q->orWhere(function ($sub) use ($oneYearAgo) {
                    $sub->where('tipe', 'tahunan')
                        ->where('created_at', '<=', $oneYearAgo);
                });

                // LAINNYA -> perlakuan sama seperti tahunan (> 1 tahun)
                $q->orWhere(function ($sub) use ($oneYearAgo) {
                    $sub->where('tipe', 'lainnya')
                        ->where('created_at', '<=', $oneYearAgo);
                });
            })
            ->sum('sisa_tagihan');

            return view('dashboard', compact(
                'siswaBelumBayar',
                'totalPembayaranBulanIni',
                'totalPembayaran',
                'arusMasuk',
                'arusKeluar',
                'months',
                'totalSisaTunggakan',
                'years',
                'selectedMonth',
                'selectedYear',
                'logs'
            ));
        }

        if ($user->hasRole('siswa')) {

            $siswa = Siswa::where('user_id', $user->id)->first();

            if (! $siswa) {
                abort(404, 'Data siswa tidak ditemukan untuk user ini.');
            }

            $siswaId = $siswa->id;

            $sisaTagihan = SppSiswa::where('siswa_id', $siswaId)->sum('sisa_tagihan');

            $pembayaranBulanIni = Pembayaran::where('siswa_id', $siswaId)
                ->whereMonth('tanggal_bayar', $selectedMonth)
                ->whereYear('tanggal_bayar', $selectedYear)
                ->exists();

            $totalDibayar = Pembayaran::where('siswa_id', $siswaId)->sum('jumlah_bayar');

            $riwayat = Pembayaran::where('siswa_id', $siswaId)
                ->whereMonth('tanggal_bayar', $selectedMonth)
                ->whereYear('tanggal_bayar', $selectedYear)
                ->latest()
                ->take(10)
                ->get();

            return view('dashboard_siswa', compact(
                'sisaTagihan',
                'pembayaranBulanIni',
                'totalDibayar',
                'riwayat',
                'months',
                'years',
                'selectedMonth',
                'selectedYear'
            ));
        }

        abort(403, 'Role tidak dikenali');
    }
}
