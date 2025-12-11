<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\Siswa;
use App\Models\SppSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SiswaController extends Controller
{
    /**
     * Tampilkan semua siswa + relasi user
     */
    public function index(Request $request)
    {
        $query = Siswa::with('user')->orderBy('nama', 'ASC');

        // FILTER KELAS
        if ($request->kelas && $request->kelas != '') {
            $query->where('kelas', $request->kelas);
        }

        // FILTER ANGKATAN
        if ($request->angkatan && $request->angkatan != '') {
            $query->where('angkatan', $request->angkatan);
        }

        // PENCARIAN (nama atau nis)
        if ($request->search && $request->search != '') {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'LIKE', "%$search%")
                ->orWhereHas('user', function ($u) use ($search) {
                    $u->where('nis', 'LIKE', "%$search%");
                });
            });
        }

        // PAGINATION
        $siswas = $query->paginate(10)->withQueryString();

        // Data dropdown untuk kelas & angkatan
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas');
        $angkatanList = Siswa::select('angkatan')->distinct()->pluck('angkatan');

        return view('admin.siswa.index', compact('siswas', 'kelasList', 'angkatanList'));
    }
    
    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,csv,xls|max:5120', // Max 5MB
        ]);

        try {
            // Proses import Excel
            Excel::import(new SiswaImport, $request->file('file'));

            return back()->with('success', 'Data siswa berhasil diimport!');
        } catch (\Throwable $e) {

            return back()->with('error', 'Gagal melakukan import: ' . $e->getMessage());
        }
    }

   
    public function create()
    {
        return view('admin.siswa.create');
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'telp' => 'required|string|max:20',
            'nis' => 'required|string|unique:users,nis',
            'password' => 'nullable|min:6',

            'jenis_kelamin' => 'nullable|string|max:1',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telp_orangtua' => 'nullable|string|max:20',
            'angkatan' => 'nullable|string|max:10',
        ]);

        $user = User::create([
            'name' => $request->nama,
            'password' => Hash::make($request->password),
            'nis' => $request->nis,    
            // 'id' => $siswa->id,
        ]);
        $siswa = Siswa::create([
            'nama' => $request->nama,
            'user_id' => $user->id,
            'kelas' => $request->kelas,
            'telp' => $request->telp,
            'status' => $request->status ?? 'aktif',
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'telp_orangtua' => $request->telp_orangtua,
            'angkatan' => $request->angkatan,
        ]);


        $user->assignRole('siswa');

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa & akun berhasil ditambahkan');
    }


    public function show(Siswa $siswa)
    {
        // load relasi user
        $siswa->load('user');

        // Ambil semua tagihan SPP siswa
        $sppSiswa = SppSiswa::with('master')
            ->where('siswa_id', $siswa->id)
            ->get();

        // Hitung total seluruh sisa tagihan
        $totalSisa = $sppSiswa->sum('sisa_tagihan');

        return view('admin.siswa.show', [
            'siswa' => $siswa,
            'user' => $siswa->user,
            'sppSiswa' => $sppSiswa,
            'totalSisa' => $totalSisa
        ]);
    }

    /**
     * Form edit siswa
     */
    public function edit(Siswa $siswa)
    {
        $siswa->load('user');

        return view('admin.siswa.edit', [
            'siswa' => $siswa,
            'user' => $siswa->user
        ]);
    }

    public function profile()
    {
        $user = Auth::user();

        $siswa = Siswa::where('user_id', $user->id)
            ->with('user')
            ->firstOrFail();

        $sppSiswa = SppSiswa::with('master')
            ->where('siswa_id', $siswa->id)
            ->get();

        $totalSisa = $sppSiswa->sum('sisa_tagihan');

        return view('siswa.profile', [
            'siswa' => $siswa,
            'user' => $user,
            'sppSiswa' => $sppSiswa,
            'totalSisa' => $totalSisa,
        ]);
    }


    /**
     * Update siswa + user
     */
    public function update(Request $request, Siswa $siswa)
    {
        $user = $siswa->user;

        $request->validate([
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'telp' => 'required|string|max:20',

            'name' => 'required|string|max:255',
            'nis' => 'required|string' ,
            'password' => 'nullable|min:6',

            'jenis_kelamin' => 'nullable|string|max:1',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telp_orangtua' => 'nullable|string|max:20',
            'angkatan' => 'nullable|string|max:10',
        ]);

        // Update data siswa
        $siswa->update([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'telp' => $request->telp,
            'status' => $request->status,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'telp_orangtua' => $request->telp_orangtua,
            'angkatan' => $request->angkatan,
        ]);

        // Update akun user
        if ($user) {
            $user->update([
                'name' => $request->nama,
                'nis' => $request->nis,
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
            }
        }

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa & akun berhasil diperbarui');
    }


    public function destroy(Siswa $siswa)
    {
        $user = $siswa->user;

        if ($user) {
            $user->syncRoles([]);
            $user->delete();
        }

        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa & akun berhasil dihapus');
    }


    public function naikKelas(Request $request)
    {
        $counters = [
            'x_to_xi' => 0,
            'xi_to_xii' => 0,
            'xii_to_alumni' => 0,
            'nonaktif' => 0,
            'skipped' => 0,
        ];

        DB::beginTransaction();

        try {
            $siswaList = Siswa::whereRaw("LOWER(kelas) NOT LIKE 'alumni'")->get();

            foreach ($siswaList as $siswa) {
                $current = (string) $siswa->kelas;
                $next = $this->getNextClass($current);

                if ($next === null || strtolower($current) === strtolower($next)) {
                    $counters['skipped']++;
                    continue;
                }

                $currentNormalized = strtolower(trim($current));

                if (preg_match('/^\s*(xii)\b/i', $currentNormalized) || preg_match('/^\s*12\b/i', $currentNormalized)) {
                    // XII -> Alumni
                    $counters['xii_to_alumni']++;
                } elseif (preg_match('/^\s*(xi)\b/i', $currentNormalized) || preg_match('/^\s*11\b/i', $currentNormalized)) {
                    // XI -> XII
                    $counters['xi_to_xii']++;
                } elseif (preg_match('/^\s*(x)\b(?!i)/i', $currentNormalized) || preg_match('/^\s*10\b/i', $currentNormalized)) {
                    // X -> XI
                    $counters['x_to_xi']++;
                } else {
                    // Kelas lain yang valid terdeteksi oleh getNextClass tetapi tidak masuk kategori di atas
                    // contoh: jika getNextClass menangani format lain, kita tetap hit promosi umum
                }

                $siswa->kelas = $next;

                if (strtolower($next) === 'alumni') {
                    $totalSisa = SppSiswa::where('siswa_id', $siswa->id)->sum('sisa_tagihan');

                    if ((float) $totalSisa === 0.0) {
                        if (array_key_exists('status', $siswa->getAttributes())) {
                            $siswa->status = 'nonaktif';
                            $counters['nonaktif']++;
                        }
                    }
                }

                $siswa->save();
            }

            DB::commit();

            $parts = [];
            if ($counters['x_to_xi'] > 0) $parts[] = "{$counters['x_to_xi']} siswa naik ke kelas XI";
            if ($counters['xi_to_xii'] > 0) $parts[] = "{$counters['xi_to_xii']} siswa naik ke kelas XII";
            if ($counters['xii_to_alumni'] > 0) $parts[] = "{$counters['xii_to_alumni']} siswa menjadi Alumni";

            $message = 'Tidak ada perubahan yang dilakukan.';
            if (!empty($parts)) {
                $message = 'Sebanyak ' . implode(', ', $parts);
                $message .= $counters['nonaktif'] > 0
                    ? ", dan {$counters['nonaktif']} alumni dinonaktifkan karena tidak memiliki tunggakan."
                    : '.';
            }

            return redirect()->back()->with('success', $message);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Error saat proses naik kelas: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses kenaikan kelas. Silakan coba lagi.');
        }
    }


    protected function getNextClass(string $kelas): ?string
    {
        $k = trim(strtolower($kelas));

        // Cek XII / 12 dulu
        if (preg_match('/^\s*(xii|12)\b/i', $k)) {
            return 'Alumni';
        }

        // Cek XI / 11
        if (preg_match('/^\s*(xi|11)\b/i', $k)) {
            return 'XII';
        }

        // Cek X / 10 (pastikan 'xi' tidak ter-capture)
        if (preg_match('/^\s*(x|10)\b(?!i)/i', $k)) {
            return 'XI';
        }

        // jika format lain misal 'kelas 10 ipa'
        if (preg_match('/\b10\b/i', $k)) return 'XI';
        if (preg_match('/\b11\b/i', $k)) return 'XII';
        if (preg_match('/\b12\b/i', $k)) return 'Alumni';

        return null;
    }
}
