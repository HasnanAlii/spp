<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Siswa;
use App\Models\SppSiswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{

    public function index(Request $request)
    {
        $query = Pembayaran::with(['siswa', 'sppSiswa'])->latest();

        if (Auth::check() && Auth::user()->role === 'siswa') {
            $query->where('siswa_id', Auth::id());
        }

        if ($request->filled('tanggal')) {
            try {
                $date = Carbon::parse($request->tanggal)->startOfDay();
                $query->whereDate('created_at', $date);
            } catch (\Exception $e) {}
        } elseif ($request->filled('bulan')) {
            try {
                $parts = explode('-', $request->bulan);
                if (count($parts) === 2) {
                    $year = (int) $parts[0];
                    $month = (int) $parts[1];
                    $query->whereYear('created_at', $year)
                        ->whereMonth('created_at', $month);
                }
            } catch (\Exception $e) {}
        } elseif ($request->filled('tahun')) {
            try {
                $year = (int) $request->tahun;
                if ($year > 0) {
                    $query->whereYear('created_at', $year);
                }
            } catch (\Exception $e) {}
        } else {
            if ($request->filter === 'harian') {
                $query->whereDate('created_at', today());
            }

            if ($request->filter === 'bulanan') {
                $query->whereYear('created_at', date('Y'))
                    ->whereMonth('created_at', date('m'));
            }

            if ($request->filter === 'tahunan') {
                $query->whereYear('created_at', date('Y'));
            }
        }

        $summaryQuery = (clone $query);

        $total = $summaryQuery->sum('jumlah_bayar');

        $totalTransaksi = (clone $summaryQuery)->count();

        $pembayarans = $query->paginate(10)->withQueryString();

        return view('admin.pembayaran.index', compact('pembayarans', 'total', 'totalTransaksi'));
    }


    public function exportPdf(Request $request)
    {
        $query = Pembayaran::with(['siswa', 'sppSiswa'])->latest();

        // Terapkan filter yang sama seperti index
        if ($request->filter === 'harian') {
            $query->whereDate('created_at', today());
        }

        if ($request->filter === 'bulanan') {
            $query->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'));
        }

        if ($request->filter === 'tahunan') {
            $query->whereYear('created_at', date('Y'));
        }

        $pembayarans = $query->get();

        // Hitung total pemasukan pembayaran
        $total = $pembayarans->sum('jumlah_bayar');

        $pdf = Pdf::loadView('admin.pembayaran.pdf', [
            'pembayarans' => $pembayarans,
            'total'       => $total,
            'filter'      => $request->filter
        ])->setPaper('A4', 'portrait');

        return $pdf->download('laporan-pembayaran.pdf');
    }

    /**
     * FORM CREATE PEMBAYARAN
     */
    public function create()
    {
        return view('admin.pembayaran.create', [
            'siswas' => Siswa::with('user')->get()
        ]);
    }


    public function getTagihan($siswa_id)
    {
        $tagihan = SppSiswa::where('siswa_id', $siswa_id)
            ->where('sisa_tagihan', '>', 0)
            ->get();

        return response()->json([
            'tagihan' => $tagihan
        ]);
    }


    
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id'      => 'required|exists:siswas,id',
            'spp_siswa_id'  => 'required|exists:spp_siswas,id',
            'nominal_bayar' => 'required|numeric|min:1',
        ]);

        // Ambil data tagihan
        $tagihan = SppSiswa::findOrFail($request->spp_siswa_id);

        // Kurangi sisa tagihan
        $tagihan->sisa_tagihan -= $request->nominal_bayar;

        // Jika lunas
        if ($tagihan->sisa_tagihan <= 0) {
            $tagihan->sisa_tagihan = 0;
            $tagihan->status = 'lunas';
        }

        $tagihan->save();

        // Simpan transaksi pembayaran
        $pembayaran = Pembayaran::create([
            'siswa_id'      => $request->siswa_id,
            'spp_siswa_id'  => $request->spp_siswa_id,
            'jumlah_bayar'  => $request->nominal_bayar,
            'tanggal_bayar' => $request->tanggal ?? now(),
            'keterangan'    => $request->keterangan
        ]);

        // === TAMBAHKAN KE TABEL KEUANGAN ===
        Keuangan::create([
            'id_pembayaran' => $pembayaran->id,
            'jumlah'        => $request->nominal_bayar,
            'keterangan'    => "Pembayaran SPP - " . $tagihan->nama_spp,
            'arus_dana'     => 'masuk',
        ]);

        return redirect()->route('pembayaran.index')
            ->with('success', 'Pembayaran berhasil dicatat & dicatat ke laporan keuangan.');
    }

    /**
     * DETAIL PEMBAYARAN
     */
    public function show(Pembayaran $pembayaran)
    {
        $pembayaran->load(['siswa', 'sppSiswa']);
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    /**
     * EDIT PEMBAYARAN
     */
public function edit(Pembayaran $pembayaran)
{
    $pembayaran->load(['siswa', 'sppSiswa']);

    return view('admin.pembayaran.edit', [
        'pembayaran' => $pembayaran,
        'tagihans'   => SppSiswa::where('siswa_id', $pembayaran->siswa_id)->get()
    ]);
}


    /**
     * UPDATE DATA PEMBAYARAN
     */
public function update(Request $request, Pembayaran $pembayaran)
{
    $request->validate([
        'spp_siswa_id'  => 'required|exists:spp_siswas,id',
        'nominal_bayar' => 'required|numeric|min:1',
        'tanggal_bayar' => 'required|date',
        'keterangan'    => 'nullable|string'
    ]);

    DB::transaction(function () use ($request, $pembayaran) {

        /* ============================
           1. KEMBALIKAN TAGIHAN LAMA
        ============================ */
        $tagihanLama = SppSiswa::findOrFail($pembayaran->spp_siswa_id);
        $tagihanLama->sisa_tagihan += $pembayaran->jumlah_bayar;
        $tagihanLama->status = 'belum lunas';
        $tagihanLama->save();

        /* ============================
           2. TAGIHAN BARU
        ============================ */
        $tagihanBaru = SppSiswa::findOrFail($request->spp_siswa_id);
        $tagihanBaru->sisa_tagihan -= $request->nominal_bayar;

        if ($tagihanBaru->sisa_tagihan <= 0) {
            $tagihanBaru->sisa_tagihan = 0;
            $tagihanBaru->status = 'lunas';
        }

        $tagihanBaru->save();

        /* ============================
           3. UPDATE PEMBAYARAN
        ============================ */
        $pembayaran->update([
            'spp_siswa_id'  => $request->spp_siswa_id,
            'jumlah_bayar'  => $request->nominal_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'keterangan'    => $request->keterangan,
        ]);

        /* ============================
           4. UPDATE KEUANGAN
        ============================ */
        Keuangan::where('id_pembayaran', $pembayaran->id)->update([
            'jumlah'     => $request->nominal_bayar,
            'keterangan' => "Pembayaran SPP - " . $tagihanBaru->nama_spp,
            'arus_dana'  => 'masuk',
        ]);
    });

    return redirect()->route('pembayaran.index')
        ->with('success', 'Data pembayaran berhasil diperbarui.');
}


    /**
     * HAPUS PEMBAYARAN
     */
    public function destroy(Pembayaran $pembayaran)
    {
        $pembayaran->delete();

        return redirect()->route('pembayaran.index')
                         ->with('success', 'Transaksi pembayaran berhasil dihapus.');
    }

    /**
     * RIWAYAT PEMBAYARAN UNTUK SISWA
     */
    public function historySiswa()
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            abort(404, 'Data siswa tidak ditemukan');
        }

        $pembayarans = Pembayaran::with('sppSiswa')
                                 ->where('siswa_id', $siswa->id)
                                 ->latest()
                                 ->get();

        return view('siswa.pembayaran.index', compact('pembayarans'));
    }
}
