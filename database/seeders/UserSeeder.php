<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $adminUser = User::create([
            'name' => 'Administrator',
            'email' => 'admin@sekolah.id',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        Admin::create([
            'user_id' => $adminUser->id,
            'nama' => 'Admin Sekolah',
            'email' => 'admin@sekolah.id',
            'no_telp' => '081234567890',
        ]);

        // Create Siswa
        $siswaUser = User::create([
            'name' => 'Andi Siswa',
            'email' => 'andi@siswa.id',
            'password' => Hash::make('password123'),
            'role' => 'siswa',
            'email_verified_at' => now(),
        ]);

        Siswa::create([
            'user_id' => $siswaUser->id,
            'nis' => '2024001',
            'nama' => 'Andi Siswa',
            'kelas' => 'XII IPA 1',
            'email' => 'andi@siswa.id',
        ]);

        // Create more siswa
        for ($i = 2; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'Siswa ' . $i,
                'email' => 'siswa' . $i . '@sekolah.id',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'email_verified_at' => now(),
            ]);

            Siswa::create([
                'user_id' => $user->id,
                'nis' => '202400' . $i,
                'nama' => 'Siswa ' . $i,
                'kelas' => 'XII IPA ' . $i,
                'email' => 'siswa' . $i . '@sekolah.id',
            ]);
        }
    }
}