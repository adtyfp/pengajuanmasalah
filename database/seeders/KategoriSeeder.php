<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriSarana;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Laboratorium Komputer',
                'deskripsi' => 'Masalah terkait fasilitas laboratorium komputer',
            ],
            [
                'nama_kategori' => 'Perpustakaan',
                'deskripsi' => 'Pengaduan mengenai perpustakaan sekolah',
            ],
            [
                'nama_kategori' => 'Ruang Kelas',
                'deskripsi' => 'Masalah di ruang kelas seperti kursi, meja, papan tulis',
            ],
            [
                'nama_kategori' => 'Toilet/WC',
                'deskripsi' => 'Pengaduan mengenai fasilitas toilet',
            ],
            [
                'nama_kategori' => 'Lapangan Olahraga',
                'deskripsi' => 'Masalah di lapangan olahraga',
            ],
            [
                'nama_kategori' => 'Kantin',
                'deskripsi' => 'Pengaduan terkait kantin sekolah',
            ],
            [
                'nama_kategori' => 'Jaringan Internet',
                'deskripsi' => 'Masalah koneksi internet sekolah',
            ],
        ];

        foreach ($kategoris as $kategori) {
            KategoriSarana::create($kategori);
        }
    }
}