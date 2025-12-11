<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{

    public function index(Request $request)
    {
        $baseQuery = Keuangan::query();

        if ($request->filled('tanggal')) {
            try {
                $date = Carbon::parse($request->tanggal)->startOfDay();
                $baseQuery->whereDate('created_at', $date);
            } catch (\Exception $e) {
            }
        } elseif ($request->filled('bulan')) {
            try {
                $parts = explode('-', $request->bulan);
                if (count($parts) === 2) {
                    $year = (int) $parts[0];
                    $month = (int) $parts[1];
                    $baseQuery->whereYear('created_at', $year)
                            ->whereMonth('created_at', $month);
                }
            } catch (\Exception $e) {
            }
        } elseif ($request->filled('tahun')) {
            try {
                $year = (int) $request->tahun;
                if ($year > 0) {
                    $baseQuery->whereYear('created_at', $year);
                }
            } catch (\Exception $e) {
            }
        } else {
            if ($request->filter == 'harian') {
                $baseQuery->whereDate('created_at', today());
            } elseif ($request->filter == 'bulanan') {
                $baseQuery->whereYear('created_at', date('Y'))
                        ->whereMonth('created_at', date('m'));
            } elseif ($request->filter == 'tahunan') {
                $baseQuery->whereYear('created_at', date('Y'));
            }
        }

        $summaryQuery = clone $baseQuery;

        $keuangans = $baseQuery->latest()->paginate(10)->withQueryString();

        $pemasukan   = (clone $summaryQuery)->where('arus_dana', 'masuk')->sum('jumlah');
        $pengeluaran = (clone $summaryQuery)->where('arus_dana', 'keluar')->sum('jumlah');
        $saldo       = $pemasukan - $pengeluaran;

        return view('admin.keuangan.index', compact('keuangans', 'pemasukan', 'pengeluaran', 'saldo'));
    }



    public function exportPdf(Request $request)
    {
        $baseQuery = Keuangan::query();

        // Terapkan filter sama seperti index
        if ($request->filter == 'harian') {
            $baseQuery->whereDate('created_at', today());
        } elseif ($request->filter == 'bulanan') {
            $baseQuery->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
        } elseif ($request->filter == 'tahunan') {
            $baseQuery->whereYear('created_at', date('Y'));
        }

        $keuangans = $baseQuery->orderBy('created_at', 'DESC')->get();

        $pemasukan   = (clone $baseQuery)->where('arus_dana', 'masuk')->sum('jumlah');
        $pengeluaran = (clone $baseQuery)->where('arus_dana', 'keluar')->sum('jumlah');
        $saldo       = $pemasukan - $pengeluaran;

        // Render tampilan khusus untuk PDF
        $pdf = Pdf::loadView('admin.keuangan.pdf', [
            'keuangans'   => $keuangans,
            'pemasukan'   => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'saldo'       => $saldo,
            'filter'      => $request->filter
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-keuangan.pdf');
    }

    public function create()
    {
        return view('admin.keuangan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah'     => 'required|numeric',
            'keterangan' => 'nullable|string',
            'arus_dana'  => 'required|in:masuk,keluar',
        ]);

        Keuangan::create($request->all());

        return redirect()->route('keuangan.index')
                         ->with('success', 'Data Keuangan (Arus Kas) berhasil disimpan.');
    }

    public function show(Keuangan $keuangan)
    {
        return view('admin.keuangan.show', compact('keuangan'));
    }

    public function edit(Keuangan $keuangan)
    {
        return view('admin.keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, Keuangan $keuangan)
    {
        $request->validate([
            'jumlah'     => 'required|numeric',
            'keterangan' => 'nullable|string',
            'arus_dana'  => 'required|in:masuk,keluar',
        ]);

        $keuangan->update($request->all());

        return redirect()->route('keuangan.index')
                         ->with('success', 'Data Keuangan berhasil diperbarui.');
    }

    public function destroy(Keuangan $keuangan)
    {
        $keuangan->delete();
        return redirect()->route('keuangan.index')
                         ->with('success', 'Data Keuangan berhasil dihapus.');
    }
}