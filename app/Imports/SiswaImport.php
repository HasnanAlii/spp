<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Siswa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class SiswaImport implements ToModel, WithHeadingRow, WithChunkReading, WithValidation, SkipsOnFailure, SkipsOnError
{
    use Importable, SkipsFailures, SkipsErrors;

    public function model(array $row)
    {

        if (empty($row['nama']) || empty($row['angkatan'])) {
            return null;
        }

        $nis = isset($row['nis']) && $row['nis'] !== '' ? $row['nis'] : $this->generateNis($row['angkatan']);

        if (User::where('nis', $nis)->exists()) {
            return null;
        }

        DB::beginTransaction();
        try {
            $password = isset($row['password']) && $row['password'] !== '' ? $row['password'] : 'password';

            $user = User::create([
                'name' => $row['nama'],
                'nis' => $nis,
                'password' => Hash::make($password),
            ]);

        // try {
        //     $password = !empty($row['password']) ? $row['password'] : 'password';

        //     $user = User::create([
        //         'name'     => $row['nama'],
        //         'nis'      => $nis,
        //         'password' => Hash::make($password),
        //     ]);

            if (method_exists($user, 'assignRole')) {
                $user->assignRole('siswa');
            }

            Siswa::create([
                'nama' => $row['nama'],
                'kelas' => $row['kelas'] ?? null,
                'telp' => $row['telp'] ?? null,
                'jenis_kelamin' => $row['jenis_kelamin'] ?? null,
                'status' => $row['status'] ?? null,
                'tanggal_lahir' => $row['tanggal_lahir'] ?? null,
                'alamat' => $row['alamat'] ?? null,
                'gelombang' => $row['gelombang'] ?? null,
                'telp_orangtua' => $row['telp_orangtua'] ?? null,
                'angkatan' => $row['angkatan'],
                'user_id' => $user->id,
            ]);

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return null;
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string',
            'angkatan' => 'required',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    protected function generateNis($angkatan)
    {
        $prefix = preg_replace('/\D/', '', $angkatan) ?: substr($angkatan, 0, 4) ?: date('Y');
        $maxNis = User::where('nis', 'like', $prefix . '%')->max('nis');

        if ($maxNis) {
            $lastSeq = (int) substr($maxNis, strlen($prefix));
            $nextSeq = $lastSeq + 1;
        } else {
            $nextSeq = 1;
        }

        return $prefix . str_pad($nextSeq, 3, '0', STR_PAD_LEFT);
    }
}
