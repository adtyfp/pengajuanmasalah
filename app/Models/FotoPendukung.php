<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FotoPendukung extends Model
{
    use HasFactory;

    // 🔥 Tambahkan ini agar tidak jadi foto_pendukungs
    protected $table = 'foto_pendukung';

    protected $fillable = [
        'pengaduan_id',
        'nama_file',
        'path',
    ];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'pengaduan_id');
    }
}