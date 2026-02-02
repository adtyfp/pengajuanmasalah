<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriSarana extends Model
{
    use HasFactory;

    // FIX 1: paksa nama tabel agar tidak jadi kategori_saranas
    protected $table = 'kategori_sarana';

    protected $fillable = [
        'nama_kategori', // FIX 2: typo diperbaiki
        'deskripsi',
    ];

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'kategori_id');
    }
}
