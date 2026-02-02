<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\HistoriStatus;
use App\Models\Feedback;
use App\Models\KategoriSarana;
use App\Http\Requests\UpdateStatusRequest;
use Illuminate\Http\Request;

class PengaduanController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengaduan::with(['siswa', 'kategori', 'feedback'])
            ->latest();

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by kategori
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter by search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                  });
            });
        }

        $pengaduan = $query->paginate(15);
        $kategoris = KategoriSarana::all();

        return view('admin.pengaduan.index', compact('pengaduan', 'kategoris'));
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load(['siswa', 'kategori', 'fotoPendukung', 'feedback.admin', 'historiStatus.admin']);
        
        // Count total pengaduan by siswa
        $pengaduan->siswa->loadCount('pengaduan');
        
        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function edit(Pengaduan $pengaduan)
    {
        $pengaduan->load(['siswa', 'kategori']);
        return view('admin.pengaduan.edit', compact('pengaduan'));
    }

    public function updateStatus(UpdateStatusRequest $request, Pengaduan $pengaduan)
    {
        $statusSebelum = $pengaduan->status;
        $statusSesudah = $request->status;

        // Update status pengaduan
        $pengaduan->update(['status' => $statusSesudah]);

        // Simpan histori perubahan status
        HistoriStatus::create([
            'pengaduan_id' => $pengaduan->id,
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => $statusSesudah,
            'diubah_oleh' => auth()->user()->admin->id,
        ]);

        // Jika ada feedback, simpan
        if ($request->isi_feedback) {
            Feedback::create([
                'pengaduan_id' => $pengaduan->id,
                'admin_id' => auth()->user()->admin->id,
                'isi_feedback' => $request->isi_feedback,
            ]);
        }

        return redirect()->route('admin.pengaduan.show', $pengaduan)
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }

public function destroy(Pengaduan $pengaduan)
{
    // pastikan hanya pemilik pengaduan
    if ($pengaduan->siswa_id !== auth()->user()->siswa->id) {
        abort(403, 'Akses ditolak');
    }

    // hanya boleh hapus jika status masih baru
    if ($pengaduan->status !== 'baru') {
        return back()->with('error', 'Pengaduan tidak dapat dihapus.');
    }

    $pengaduan->delete();

    return redirect()
        ->route('siswa.pengaduan.index')
        ->with('success', 'Pengaduan berhasil dihapus.');
}


}