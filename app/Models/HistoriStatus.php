<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriStatus extends Model
{
    use HasFactory;

    // 🔥 Tambahkan ini agar tidak jadi histori_statuses
    protected $table = 'histori_status';

    protected $fillable = [
        'pengaduan_id',
        'status_sebelum',
        'status_sesudah',
        'diubah_oleh',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'diubah_oleh');
    }
}