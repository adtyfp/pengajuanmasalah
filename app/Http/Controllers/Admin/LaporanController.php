<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function export(Request $request)
    {
        $query = Pengaduan::with(['siswa', 'kategori']);

        if ($request->has('start_date')) {
            $query->whereDate('tanggal_pengaduan', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->whereDate('tanggal_pengaduan', '<=', $request->end_date);
        }

        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        $pengaduan = $query->get();

        $pdf = PDF::loadView('admin.laporan.export', compact('pengaduan'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-pengaduan-' . date('Y-m-d') . '.pdf');
    }
}