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
        $query = Pengaduan::with([
            'siswa',
            'kategori',
            'feedback'
        ])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('lokasi', 'like', "%{$search}%")
                  ->orWhereHas('siswa', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('nis', 'like', "%{$search}%");
                  });
            });
        }

        return view('admin.pengaduan.index', [
            'pengaduan' => $query->paginate(15),
            'kategoris' => KategoriSarana::all()
        ]);
    }

    public function show(Pengaduan $pengaduan)
    {
        $pengaduan->load([
            'siswa',
            'kategori',
            'fotoPendukung',
            'feedback.admin',
            'historiStatus.admin'
        ]);

        // aman tanpa null
        if ($pengaduan->siswa) {
            $pengaduan->siswa->loadCount('pengaduan');
        }

        return view('admin.pengaduan.show', compact('pengaduan'));
    }

    public function updateStatus(UpdateStatusRequest $request, Pengaduan $pengaduan)
    {
        $statusSebelum = $pengaduan->status;
        $statusSesudah = $request->status;

        $pengaduan->update([
            'status' => $statusSesudah
        ]);

        // Simpan histori
        HistoriStatus::create([
            'pengaduan_id' => $pengaduan->id,
            'status_sebelum' => $statusSebelum,
            'status_sesudah' => $statusSesudah,
            'diubah_oleh' => auth()->user()->admin->id ?? null,
        ]);

        // Simpan feedback jika ada
        if ($request->filled('isi_feedback')) {
            Feedback::create([
                'pengaduan_id' => $pengaduan->id,
                'admin_id' => auth()->user()->admin->id ?? null,
                'isi_feedback' => $request->isi_feedback,
            ]);
        }

        return redirect()
            ->route('admin.pengaduan.show', $pengaduan)
            ->with('success', 'Status pengaduan berhasil diperbarui.');
    }

    public function destroy(Pengaduan $pengaduan)
    {
        // ADMIN boleh hapus tanpa cek siswa
        $pengaduan->delete();

        return redirect()
            ->route('admin.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dihapus.');
    }
}