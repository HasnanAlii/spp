<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\PermissionRegistrar;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ROLES
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleSiswa = Role::firstOrCreate(['name' => 'siswa']);

        /**
         * ==========================
         * ADMIN (Masih pakai Email)
         * ==========================
         * Karena admin biasanya pakai login email
         */
        $admin = User::firstOrCreate(
            ['name' => 'Administrator'], // gunakan name sebagai unique
            [
                'nis' => '5599',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $admin->assignRole($roleAdmin);

        /**
         * ==========================
         * SISWA (Login pakai NIS)
         * ==========================
         */
        $siswa = User::firstOrCreate(
            ['nis' => '2024001'], // contoh nis
            [
                'name' => 'Andi Siswa',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        $siswa->assignRole($roleSiswa);
    }
}
