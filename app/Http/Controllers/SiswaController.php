<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\SppSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Tampilkan semua siswa + relasi user
     */
    public function index()
    {
        $siswas = Siswa::with('user')->get();
        return view('admin.siswa.index', compact('siswas'));
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
            // Data siswa
            'nama' => 'required|string|max:255',
            'kelas' => 'required|string|max:50',
            'telp' => 'required|string|max:20',
            'nis' => 'required|string|unique:users,nis',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',

            // tambahan opsional
            'jenis_kelamin' => 'nullable|string|max:1',
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'telp_orangtua' => 'nullable|string|max:20',
            'angkatan' => 'nullable|string|max:10',
        ]);

        // 1️⃣ Simpan siswa
        $siswa = Siswa::create([
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'telp' => $request->telp,
            'status' => $request->status ?? 'aktif',
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'alamat' => $request->alamat,
            'telp_orangtua' => $request->telp_orangtua,
            'angkatan' => $request->angkatan,
        ]);

        // 2️⃣ Simpan user dan hubungkan ke siswa via siswa_id
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nis' => $request->nis,
            'siswa_id' => $siswa->id,
        ]);

        // 3️⃣ Tambahkan role Spatie
        $user->assignRole('siswa');

        return redirect()->route('siswa.index')
            ->with('success', 'Data siswa & akun berhasil ditambahkan');
    }

    /**
     * Detail siswa + relasi user + semua SPP siswa
     */
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

            'nis' => 'required|string|unique:users,nis,' . ($user->id ?? 0),
            'email' => 'required|email|unique:users,email,' . ($user->id ?? 0),
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
                'email' => $request->email,
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
