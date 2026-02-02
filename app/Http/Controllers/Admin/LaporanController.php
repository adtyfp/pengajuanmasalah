<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\KategoriSarana;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class LaporanController extends Controller
{
    public function index()
    {
        $query = Pengaduan::query();
        
        // Filter berdasarkan request untuk preview
        if (request('start_date')) {
            $query->whereDate('tanggal_pengaduan', '>=', request('start_date'));
        } else {
            $query->whereDate('tanggal_pengaduan', '>=', now()->subMonth());
        }
        
        if (request('end_date')) {
            $query->whereDate('tanggal_pengaduan', '<=', request('end_date'));
        }
        
        if (request('status') && request('status') != 'all') {
            $query->where('status', request('status'));
        }
        
        if (request('kategori') && request('kategori') != 'all') {
            $query->where('kategori_id', request('kategori'));
        }
        
        $totalData = $query->count();
        $selesaiCount = $query->clone()->where('status', 'selesai')->count();
        $diprosesCount = $query->clone()->where('status', 'diproses')->count();
        $baruCount = $query->clone()->where('status', 'baru')->count();
        
        $kategoris = KategoriSarana::all();
        
        // Dummy recent reports
        $recentReports = collect([
            (object) [
                'name' => 'Laporan Bulanan ' . now()->format('F Y'),
                'date' => now(),
                'url' => '#'
            ],
            (object) [
                'name' => 'Laporan Mingguan',
                'date' => now()->subDays(3),
                'url' => '#'
            ],
        ]);
        
        return view('admin.laporan.index', compact(
            'kategoris',
            'totalData',
            'selesaiCount',
            'diprosesCount',
            'baruCount',
            'recentReports'
        ));
    }

    public function export(Request $request)
    {
        $query = Pengaduan::with(['siswa', 'kategori', 'feedback.admin', 'historiStatus'])
            ->withCount('feedback');

        // Filter tanggal
        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tanggal_pengaduan', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tanggal_pengaduan', '<=', $request->end_date);
        }

        // Filter status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Filter kategori
        if ($request->has('kategori') && $request->kategori != 'all') {
            $query->where('kategori_id', $request->kategori);
        }

        $pengaduan = $query->get();
        $total = $pengaduan->count();
        $selesai = $pengaduan->where('status', 'selesai')->count();
        $diproses = $pengaduan->where('status', 'diproses')->count();
        $baru = $pengaduan->where('status', 'baru')->count();

        // Generate PDF - Menggunakan facade yang benar
        $pdf = PDF::loadView('admin.laporan.export', compact(
            'pengaduan', 
            'total', 
            'selesai', 
            'diproses', 
            'baru'
        ));
        
        // Set paper size and orientation
        $pdf->setPaper('a4', 'landscape');
        
        // Set options
        $pdf->setOptions([
            'defaultFont' => 'helvetica',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true,
            'enable_php' => true,
        ]);
        
        // Generate filename
        $filename = 'laporan-pengaduan-' . date('Y-m-d-H-i-s') . '.pdf';
        
        // Return PDF for download
        return $pdf->download($filename);
    }
    
    public function preview(Request $request)
    {
        $query = Pengaduan::with(['siswa', 'kategori']);

        if ($request->has('start_date') && $request->start_date) {
            $query->whereDate('tanggal_pengaduan', '>=', $request->start_date);
        }

        if ($request->has('end_date') && $request->end_date) {
            $query->whereDate('tanggal_pengaduan', '<=', $request->end_date);
        }

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $data = $query->paginate(10);
        
        return response()->json([
            'total' => $data->total(),
            'data' => $data->items(),
            'stats' => [
                'total' => $data->total(),
                'selesai' => $query->clone()->where('status', 'selesai')->count(),
                'diproses' => $query->clone()->where('status', 'diproses')->count(),
                'baru' => $query->clone()->where('status', 'baru')->count(),
            ]
        ]);
    }
}