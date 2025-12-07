<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\SppMaster;
use App\Models\SppSiswa;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SppController extends Controller
{

    public function index(Request $request)
    {
        $query = Spp::query();

        if ($request->filled('bulan')) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $spp = $query->latest()->paginate(10)->withQueryString();

        return view('admin.spp.index', compact('spp'));
    }

    /**
     * Form create SPP Master (massal)
     */
    public function create()
    {
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas');
        return view('admin.spp.create', compact('kelasList'));
    }

    /**
     * Store SPP baru untuk seluruh siswa dalam suatu kelas
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'kelas' => 'required',
    //         'nama_spp' => 'required|string',
    //         'tipe' => 'required|in:bulanan,tahunan,lainnya',
    //         'nominal' => 'required|numeric|min:0',
    //         'tahun_ajaran' => 'nullable|string'
    //     ]);

    //     // 1. Simpan sebagai template
    //     $sppMaster = Spp::create([
    //         'nama_spp' => $request->nama_spp,
    //         'tipe' => $request->tipe,
    //         'nominal' => $request->nominal,
    //         'tahun_ajaran' => $request->tahun_ajaran,
    //         'kelas' => $request->kelas,
    //     ]);

    //     // 2. Ambil seluruh siswa terkait kelas
    //     $siswaList = Siswa::where('kelas', $request->kelas)->get();

    //     foreach ($siswaList as $siswa) {

    //         // 3. Simpan tagihan SPP siswa
    //         SppSiswa::create([
    //             'siswa_id' => $siswa->id,
    //             'nama_spp' => $request->nama_spp,
    //             'tipe' => $request->tipe,
    //             'total_tagihan' => $request->nominal,
    //             'sisa_tagihan' => $request->nominal,
    //             'status' => 'belum lunas',
    //             'tahun_ajaran' => $request->tahun_ajaran,
    //         ]);

    //         // 4. Kirim Whatsapp Fonnte
    //         if (!empty($siswa->telp)) {

    //             // pastikan format 62xxxx
    //             $nomor = preg_replace('/^0/', '62', $siswa->telp);

    //             $pesan = 
    //                 "Pemberitahuan Tagihan SPP 📢

    // Nama: *{$siswa->nama}*
    // Kelas: *{$siswa->kelas}*

    // Tagihan: *{$request->nama_spp} ({$request->tipe})*
    // Jumlah: *Rp " . number_format($request->nominal, 0, ',', '.') . "*
    // Status: *Belum Lunas*

    // Silakan melakukan pembayaran kepada pihak sekolah.
    // Terima kasih 🙏";

    //             $response = Http::withHeaders([
    //                 'Authorization' => 'L9PaGYokqbue5GHechJR',
    //             ])->post('https://api.fonnte.com/send', [
    //                 'target' => $nomor,
    //                 'message' => $pesan,
    //                 'countryCode' => '62',
    //             ]);

    //             // Log::info("Fonnte response siswa {$siswa->id}:", $response->json());
    //         }
    //     }

    //     return redirect()->route('spp.index')->with(
    //         'success',
    //         'SPP berhasil ditambahkan & pemberitahuan dikirim ke seluruh siswa kelas ' . $request->kelas
    //     );
    // }

    public function store(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'nama_spp' => 'required|string',
            'tipe' => 'required|in:bulanan,tahunan,lainnya',
            'nominal' => 'required|numeric|min:0',
            'tahun_ajaran' => 'nullable|string'
        ]);

        // 1. Simpan template SPP
        $sppMaster = Spp::create([
            'nama_spp' => $request->nama_spp,
            'tipe' => $request->tipe,
            'nominal' => $request->nominal,
            'tahun_ajaran' => $request->tahun_ajaran,
            'kelas' => $request->kelas,
        ]);

        // 2. Ambil seluruh siswa dalam kelas
        $siswaList = Siswa::where('kelas', $request->kelas)->get();

        foreach ($siswaList as $siswa) {

            // 3. Buat tagihan SPP siswa
            SppSiswa::create([
                'siswa_id' => $siswa->id,
                'nama_spp' => $request->nama_spp,
                'tipe' => $request->tipe,
                'total_tagihan' => $request->nominal,
                'sisa_tagihan' => $request->nominal,
                'status' => 'belum lunas',
                'tahun_ajaran' => $request->tahun_ajaran,
            ]);

            // 4. Buat notifikasi untuk siswa
            Notification::create([
                'user_id'   => $siswa->user_id, // pastikan field ini ada
                'aktivitas' => 'Tagihan SPP baru: ' . $request->nama_spp .
                            ' sebesar Rp ' . number_format($request->nominal, 0, ',', '.'),
                'waktu'     => now(),
                'read_at'   => null
            ]);
        }

        return redirect()->route('spp.index')->with(
            'success',
            'SPP berhasil ditambahkan & notifikasi dikirim ke seluruh siswa kelas ' . $request->kelas
        );
    }



    public function destroy($id)
    {
        // Ambil SPP Master berdasarkan ID
        $spp = Spp::findOrFail($id);

        // Hapus semua SPP siswa yang terkait (berdasarkan kesamaan field)
        SppSiswa::where('nama_spp', $spp->nama_spp)
            ->where('tipe', $spp->tipe)
            ->where('tahun_ajaran', $spp->tahun_ajaran)
            ->whereHas('siswa', function($q) use ($spp) {
                $q->where('kelas', $spp->kelas);
            })
            ->delete();

        // Hapus master SPP
        $spp->delete();

        return redirect()->route('spp.index')->with(
            'success',
            'Data SPP dan seluruh tagihan siswa terkait berhasil dihapus.'
        );
    }


}
