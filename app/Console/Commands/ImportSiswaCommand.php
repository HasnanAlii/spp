<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SiswaImport;

class ImportSiswaCommand extends Command
{
    protected $signature = 'siswa:import {file : path ke file xlsx/csv}';
    protected $description = 'Import data siswa dari file Excel/CSV';

    public function handle()
    {
        $file = $this->argument('file');

        if (!file_exists($file)) {
            $this->error("File tidak ditemukan: {$file}");
            return 1;
        }

        try {
            $this->info("Starting import from {$file} ...");

            // jika ingin queueable: Excel::queueImport(new SiswaImport, $file);
            Excel::import(new SiswaImport, $file);

            $this->info("Import selesai.");
            return 0;
        } catch (\Throwable $e) {
            $this->error("Import gagal: " . $e->getMessage());
            return 1;
        }
    }
}
