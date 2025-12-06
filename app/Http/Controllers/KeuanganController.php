<?php

namespace App\Http\Controllers;

use App\Models\Keuangan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index()
    {
        $keuangans = Keuangan::latest()->get();
        
        // Contoh sederhana menghitung saldo
        $pemasukan = Keuangan::where('arus_dana', 'masuk')->sum('jumlah');
        $pengeluaran = Keuangan::where('arus_dana', 'keluar')->sum('jumlah');
        $saldo = $pemasukan - $pengeluaran;

        return view('admin.keuangan.index', compact('keuangans', 'saldo'));
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