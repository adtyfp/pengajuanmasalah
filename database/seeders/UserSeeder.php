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
        // ===== ADMIN =====
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@sekolah.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        Admin::updateOrCreate(
            ['user_id' => $adminUser->id],
            [
                'nama' => 'Admin Sekolah',
                'email' => 'admin@sekolah.id',
                'no_telp' => '081234567890',
            ]
        );

        // ===== SISWA UTAMA =====
        $siswaUser = User::updateOrCreate(
            ['email' => 'andi@siswa.id'],
            [
                'name' => 'Andi Siswa',
                'password' => Hash::make('password123'),
                'role' => 'siswa',
                'email_verified_at' => now(),
            ]
        );

        Siswa::updateOrCreate(
            ['user_id' => $siswaUser->id],
            [
                'nis' => '2024001',
                'nama' => 'Andi Siswa',
                'kelas' => 'XII IPA 1',
                'email' => 'andi@siswa.id',
            ]
        );

        // ===== SISWA LAIN =====
        for ($i = 2; $i <= 5; $i++) {

            $user = User::updateOrCreate(
                ['email' => "siswa{$i}@sekolah.id"],
                [
                    'name' => "Siswa {$i}",
                    'password' => Hash::make('password123'),
                    'role' => 'siswa',
                    'email_verified_at' => now(),
                ]
            );

            Siswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nis' => '202400' . $i,
                    'nama' => "Siswa {$i}",
                    'kelas' => "XII IPA {$i}",
                    'email' => "siswa{$i}@sekolah.id",
                ]
            );
        }
    }
}
