<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'siswa']);
    }

    public function index()
    {
        $siswa = auth()->user()->siswa;
        
        $totalPengaduan = Pengaduan::where('siswa_id', $siswa->id)->count();
        $baruCount = Pengaduan::where('siswa_id', $siswa->id)
            ->where('status', 'baru')->count();
        $diprosesCount = Pengaduan::where('siswa_id', $siswa->id)
            ->where('status', 'diproses')->count();
        $selesaiCount = Pengaduan::where('siswa_id', $siswa->id)
            ->where('status', 'selesai')->count();
            
        $recentPengaduan = Pengaduan::where('siswa_id', $siswa->id)
            ->with('kategori')
            ->latest()
            ->take(5)
            ->get();

        return view('siswa.dashboard', compact(
            'totalPengaduan',
            'baruCount',
            'diprosesCount',
            'selesaiCount',
            'recentPengaduan'
        ));
    }
}