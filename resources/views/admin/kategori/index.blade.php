@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('header', 'Kelola Kategori Sarana')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Create Button -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Kategori</h2>
            <p class="text-gray-600 mt-1">Kelola kategori sarana untuk pengelompokan pengaduan</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-medium transition">
            <i class="fas fa-plus mr-2"></i> Tambah Kategori
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <i class="fas fa-list text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Kategori</p>
                    <h3 class="text-2xl font-bold">{{ $kategoris->total() }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <i class="fas fa-file-alt text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Kategori Aktif</p>
                    <h3 class="text-2xl font-bold">{{ $kategoris->where('pengaduan_count', '>', 0)->count() }}</h3>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                    <i class="fas fa-exclamation-circle text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-gray-500 text-sm">Total Pengaduan</p>
                    <h3 class="text-2xl font-bold">{{ $kategoris->sum('pengaduan_count') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Pengaduan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($kategoris as $kategori)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ ($kategoris->currentPage() - 1) * $kategoris->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $kategori->nama_kategori }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $kategori->deskripsi ?: '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $kategori->pengaduan_count > 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $kategori->pengaduan_count }} pengaduan
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $kategori->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-3">
                                <a href="{{ route('admin.kategori.edit', $kategori) }}" 
                                   class="text-blue-600 hover:text-blue-900 transition"
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                @if($kategori->pengaduan_count == 0)
                                <form action="{{ route('admin.kategori.destroy', $kategori) }}" 
                                      method="POST" 
                                      class="inline"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="text-red-600 hover:text-red-900 transition"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <span class="text-gray-400 cursor-not-allowed" title="Tidak dapat dihapus karena memiliki pengaduan">
                                    <i class="fas fa-trash"></i>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-inbox text-4xl text-gray-300 mb-4"></i>
                                <p class="text-lg font-medium text-gray-700 mb-2">Belum ada kategori</p>
                                <p class="text-gray-600 mb-4">Mulai dengan menambahkan kategori pertama Anda</p>
                                <a href="{{ route('admin.kategori.create') }}" 
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                                    <i class="fas fa-plus mr-2"></i> Tambah Kategori
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($kategoris->hasPages())
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $kategoris->links() }}
        </div>
        @endif
    </div>

    <!-- Warning Card -->
    @if($kategoris->where('pengaduan_count', '>', 0)->count() > 0)
    <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl mt-1 mr-3"></i>
            <div>
                <h4 class="font-medium text-yellow-800">Perhatian</h4>
                <p class="text-yellow-700 text-sm mt-2">
                    Kategori yang sudah memiliki pengaduan tidak dapat dihapus. 
                    Hal ini untuk menjaga konsistensi data pengaduan yang sudah tercatat.
                </p>
            </div>
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    .truncate {
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    @media (max-width: 768px) {
        .truncate {
            max-width: 150px;
        }
    }
</style>
@endpush
@endsection