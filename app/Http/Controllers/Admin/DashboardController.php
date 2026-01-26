<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $totalPengaduan = Pengaduan::count();
        $baruCount = Pengaduan::where('status', 'baru')->count();
        $diprosesCount = Pengaduan::where('status', 'diproses')->count();
        $selesaiCount = Pengaduan::where('status', 'selesai')->count();
        
        $recentPengaduan = Pengaduan::with('siswa')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalPengaduan',
            'baruCount',
            'diprosesCount',
            'selesaiCount',
            'recentPengaduan'
        ));
    }
}