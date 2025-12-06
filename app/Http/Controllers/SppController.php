<?php

namespace App\Http\Controllers;

use App\Models\SppMaster;
use App\Models\SppSiswa;
use App\Models\Siswa;
use App\Models\Spp;
use Illuminate\Http\Request;

class SppController extends Controller
{
    /**
     * List semua SPP siswa
     */
    public function index()
    {
      $spp = Spp::all();
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
public function store(Request $request)
{
    $request->validate([
        'kelas' => 'required',
        'nama_spp' => 'required|string',
        'tipe' => 'required|in:bulanan,tahunan,lainnya',
        'nominal' => 'required|numeric|min:0',
        'tahun_ajaran' => 'nullable|string'
    ]);

    // 1. Simpan SEBAGAI TEMPLATE ke spp_master
    $sppMaster = Spp::create([
        'nama_spp' => $request->nama_spp,
        'tipe' => $request->tipe,
        'nominal' => $request->nominal,
        'tahun_ajaran' => $request->tahun_ajaran,
        'kelas' => $request->kelas,
    ]);

    // 2. Ambil semua siswa di kelas tersebut
    $siswaList = Siswa::where('kelas', $request->kelas)->get();

    // 3. Loop setiap siswa & buat SPP siswa
    foreach ($siswaList as $siswa) {

        SppSiswa::create([
            'siswa_id' => $siswa->id,
            // 'spp_master_id' => $sppMaster->id,
            'nama_spp' => $request->nama_spp,
            'tipe' => $request->tipe,
            'total_tagihan' => $request->nominal,
            'sisa_tagihan' => $request->nominal,
            'status' => 'belum lunas',
            'tahun_ajaran' => $request->tahun_ajaran,
        ]);
    }

    return redirect()->route('spp.index')->with(
        'success',
        'SPP berhasil ditambahkan untuk seluruh siswa kelas ' . $request->kelas
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
