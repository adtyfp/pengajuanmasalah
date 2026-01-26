<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'pengaduan_id',
        'status_sebelum',
        'status_sesudah',
        'diubah_oleh',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'diubah_oleh');
    }
}