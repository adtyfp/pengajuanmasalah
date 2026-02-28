<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    protected $table = 'pengaduan';

    protected $fillable = [
        'siswa_id',
        'kategori_id',
        'judul',
        'deskripsi',
        'tanggal_pengaduan',
        'status',
        'lokasi',
        'prioritas',
    ];

    // 🔥 Ubah ke datetime agar bisa pakai format('d M Y, H:i') dan addDay()
    protected $casts = [
        'tanggal_pengaduan' => 'datetime',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSarana::class, 'kategori_id');
    }

    // Relasi foto pendukung
    public function fotoPendukung()
    {
        return $this->hasMany(FotoPendukung::class, 'pengaduan_id');
    }

    // 🔥 Jika feedback hanya 1 per pengaduan, pakai hasOne
    public function feedback()
    {
        return $this->hasOne(Feedback::class, 'pengaduan_id');
    }

    public function historiStatus()
    {
        return $this->hasMany(HistoriStatus::class, 'pengaduan_id');
    }

    // Warna status
    public function getStatusColorAttribute()
    {
        return match ($this->status) {
            'baru' => 'bg-blue-100 text-blue-800',
            'diproses' => 'bg-yellow-100 text-yellow-800',
            'selesai' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    // Warna prioritas
    public function getPrioritasColorAttribute()
    {
        return match ($this->prioritas) {
            'rendah' => 'bg-green-100 text-green-800',
            'sedang' => 'bg-yellow-100 text-yellow-800',
            'tinggi' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}