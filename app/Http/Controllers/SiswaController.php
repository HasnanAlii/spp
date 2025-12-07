<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\SppSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        // Untuk dropdown kelas
        $kelasList = Siswa::select('kelas')->distinct()->pluck('kelas');

        return view('admin.siswa.index', compact('siswas', 'kelasList'));
    }

    /**
     * Form tambah siswa
     */
    public function create()
    {
        return view('admin.siswa.create');
    }

    /**
     * Simpan siswa + user + role spatie
     */
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
        // pastikan user login punya relasi siswa
        $siswa = Siswa::where('id', Auth::user()->id)
            ->with('user')
            ->firstOrFail();

        // Ambil semua tagihan SPP siswa ini
        $sppSiswa = SppSiswa::with('master')
            ->where('siswa_id', $siswa->id)
            ->get();

        // Hitung total seluruh sisa tagihan
        $totalSisa = $sppSiswa->sum('sisa_tagihan');

        return view('siswa.profile', [
            'siswa' => $siswa,
            'user' => $siswa->user,
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

    /**
     * Hapus siswa + user + role
     */
    public function destroy(Siswa $siswa)
    {
        $user = $siswa->user;

        if ($user) {
            $user->syncRoles([]); // hapus semua role Spatie
            $user->delete();
        }

        $siswa->delete();

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa & akun berhasil dihapus');
    }
}
