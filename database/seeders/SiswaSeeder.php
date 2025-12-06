<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $datas = [
            [
                'nama' => 'Andi Saputra',
                'kelas' => 'XII',
                'telp' => '081234567001',
                'jenis_kelamin' => 'L',
                'status' => 'aktif',
                'tanggal_lahir' => '2007-01-10',
                'alamat' => 'Cianjur',
                'telp_orangtua' => '08123450001',
                'angkatan' => '2025'
            ],
            [
                'nama' => 'Budi Rahman',
                'kelas' => 'XII',
                'telp' => '081234567002',
                'jenis_kelamin' => 'L',
                'status' => 'aktif',
                'tanggal_lahir' => '2007-02-12',
                'alamat' => 'Cianjur',
                'telp_orangtua' => '08123450002',
                'angkatan' => '2025'
            ],
            [
                'nama' => 'Citra Lestari',
                'kelas' => 'XII',
                'telp' => '081234567003',
                'jenis_kelamin' => 'P',
                'status' => 'aktif',
                'tanggal_lahir' => '2007-03-03',
                'alamat' => 'Cianjur',
                'telp_orangtua' => '08123450003',
                'angkatan' => '2025'
            ],
            [
                'nama' => 'Dewi Kurnia',
                'kelas' => 'XII',
                'telp' => '081234567004',
                'jenis_kelamin' => 'P',
                'status' => 'aktif',
                'tanggal_lahir' => '2007-04-05',
                'alamat' => 'Cianjur',
                'telp_orangtua' => '08123450004',
                'angkatan' => '2025'
            ],
            [
                'nama' => 'Eko Pratama',
                'kelas' => 'XII',
                'telp' => '081234567005',
                'jenis_kelamin' => 'L',
                'status' => 'aktif',
                'tanggal_lahir' => '2007-05-07',
                'alamat' => 'Cianjur',
                'telp_orangtua' => '08123450005',
                'angkatan' => '2025'
            ],
        ];

        $counter = 1;

        foreach ($datas as $data) {

            // Generate NIS otomatis contoh: 2025001, 2025002, dst.
            $nis = "2025" . str_pad($counter, 3, "0", STR_PAD_LEFT);

            // Buat User login siswa
            $user = User::create([
                'name' => $data['nama'],
                'nis' => $nis,
                'password' => Hash::make('password'), // password default
            ]);

            // Assign role siswa
            $user->assignRole('siswa');

            // Simpan ke tabel siswa
            Siswa::create([
                'nama' => $data['nama'],
                'kelas' => $data['kelas'],
                'telp' => $data['telp'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'status' => $data['status'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'alamat' => $data['alamat'],
                'telp_orangtua' => $data['telp_orangtua'],
                'angkatan' => $data['angkatan'],
                // 'user_id' => $user->id, // relasi user
            ]);

            $counter++;
        }
    }
}
