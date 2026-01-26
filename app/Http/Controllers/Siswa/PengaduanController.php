<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Pengaduan;
use App\Models\KategoriSarana;
use App\Http\Requests\StorePengaduanRequest;
use Illuminate\Support\Facades\Storage;

class PengaduanController extends Controller
{
    public function index()
    {
        $siswaId = auth()->user()->siswa->id;
        $pengaduan = Pengaduan::where('siswa_id', $siswaId)
            ->with(['kategori', 'feedback'])
            ->latest()
            ->paginate(10);

        return view('siswa.pengaduan.index', compact('pengaduan'));
    }

    public function create()
    {
        $kategoris = KategoriSarana::all();
        return view('siswa.pengaduan.create', compact('kategoris'));
    }

    public function store(StorePengaduanRequest $request)
    {
        $siswa = auth()->user()->siswa;

        $pengaduan = Pengaduan::create([
            'siswa_id' => $siswa->id,
            'kategori_id' => $request->kategori_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'prioritas' => $request->prioritas,
            'tanggal_pengaduan' => now(),
        ]);

        // Upload foto pendukung jika ada
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $foto) {
                $path = $foto->store('pengaduan/foto', 'public');
                
                $pengaduan->fotoPendukung()->create([
                    'nama_file' => $foto->getClientOriginalName(),
                    'path' => $path,
                ]);
            }
        }

        return redirect()->route('siswa.pengaduan.index')
            ->with('success', 'Pengaduan berhasil dibuat!');
    }

    public function show(Pengaduan $pengaduan)
    {
        // Pastikan pengaduan milik siswa yang login
        if ($pengaduan->siswa_id !== auth()->user()->siswa->id) {
            abort(403);
        }

        $pengaduan->load(['kategori', 'fotoPendukung', 'feedback.admin']);
        
        return view('siswa.pengaduan.show', compact('pengaduan'));
    }
}