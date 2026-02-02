<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    use HasFactory;

    // 🔥 TAMBAHKAN INI
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

    protected $casts = [
        'tanggal_pengaduan' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriSarana::class, 'kategori_id');
    }

    public function fotoPendukung()
    {
        return $this->hasMany(FotoPendukung::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function historiStatus()
    {
        return $this->hasMany(HistoriStatus::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'baru' => 'bg-blue-100 text-blue-800',
            'diproses' => 'bg-yellow-100 text-yellow-800',
            'selesai' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPrioritasColorAttribute()
    {
        return match($this->prioritas) {
            'rendah' => 'bg-green-100 text-green-800',
            'sedang' => 'bg-yellow-100 text-yellow-800',
            'tinggi' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }
}
