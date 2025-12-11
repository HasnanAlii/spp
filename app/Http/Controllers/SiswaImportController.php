<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class SiswaImportController extends Controller
{
    /**
     * Import data siswa dari file Excel
     */
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
}
