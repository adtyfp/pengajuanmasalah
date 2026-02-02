<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriSarana;
use App\Http\Requests\StoreKategoriRequest;
use App\Http\Requests\UpdateKategoriRequest;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the kategori.
     */
    public function index(Request $request)
    {
        $query = KategoriSarana::query();

        // Search by nama kategori
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('nama_kategori', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
        }

        $kategoris = $query->latest()->paginate(10);
        
        $totalKategori = KategoriSarana::count();

        return view('admin.kategori.index', compact('kategoris', 'totalKategori'));
    }

    /**
     * Show the form for creating a new kategori.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * Store a newly created kategori in storage.
     */
    public function store(StoreKategoriRequest $request)
    {
        $validated = $request->validated();

        KategoriSarana::create($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified kategori.
     */
    public function edit(KategoriSarana $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update the specified kategori in storage.
     */
    public function update(UpdateKategoriRequest $request, KategoriSarana $kategori)
    {
        $validated = $request->validated();

        $kategori->update($validated);

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified kategori from storage.
     */
    public function destroy(KategoriSarana $kategori)
    {
        // Check if kategori has related pengaduan
        if ($kategori->pengaduan()->count() > 0) {
            return redirect()->route('admin.kategori.index')
                ->with('error', 'Kategori tidak dapat dihapus karena memiliki pengaduan terkait.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategori.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}