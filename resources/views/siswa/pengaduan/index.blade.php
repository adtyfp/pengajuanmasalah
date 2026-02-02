@extends('layouts.siswa')

@section('title', 'Pengaduan Saya')
@section('header', 'Pengaduan Saya')

@php
$statusColors = [
    'baru' => 'yellow',
    'diproses' => 'blue', 
    'selesai' => 'green'
];

$prioritasColors = [
    'rendah' => 'gray',
    'sedang' => 'yellow',
    'tinggi' => 'red'
];
@endphp

@section('content')
<div class="space-y-6">
    <!-- Header dengan Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 p-3 rounded-lg">
                    <i class="fas fa-list text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Total Pengaduan</p>
                    <p class="text-2xl font-semibold">{{ $pengaduan->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-lg">
                    <i class="fas fa-clock text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Dalam Proses</p>
                    <p class="text-2xl font-semibold">{{ $pengaduan->where('status', 'diproses')->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-green-100 p-3 rounded-lg">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm text-gray-500">Selesai</p>
                    <p class="text-2xl font-semibold">{{ $pengaduan->where('status', 'selesai')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tombol Buat Pengaduan -->
    <div class="flex justify-end mb-4">
        <a href="{{ route('siswa.pengaduan.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
            <i class="fas fa-plus-circle mr-2"></i>
            Buat Pengaduan Baru
        </a>
    </div>

    <!-- Daftar Pengaduan -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        @if($pengaduan->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada pengaduan</h3>
                <p class="text-gray-500 mb-6">Mulai dengan membuat pengaduan pertama Anda</p>
                <a href="{{ route('siswa.pengaduan.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Buat Pengaduan Pertama
                </a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Judul
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($pengaduan as $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $item->judul }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-map-marker-alt text-xs mr-1"></i>
                                            {{ $item->lokasi }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $item->kategori->nama_kategori }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    bg-{{ $statusColors[$item->status] }}-100 text-{{ $statusColors[$item->status] }}-800">
                                    @if($item->status == 'baru')
                                        <i class="fas fa-clock mr-1"></i>
                                    @elseif($item->status == 'diproses')
                                        <i class="fas fa-cogs mr-1"></i>
                                    @else
                                        <i class="fas fa-check-circle mr-1"></i>
                                    @endif
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->tanggal_pengaduan->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('siswa.pengaduan.show', $item) }}" 
                                   class="text-green-600 hover:text-green-900 mr-3">
                                    <i class="fas fa-eye"></i> Lihat
                                </a>
                                @if($item->status == 'baru')
                                <form action="{{ route('siswa.pengaduan.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($pengaduan->hasPages())
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <div class="flex items-center justify-between">
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700">
                                Menampilkan
                                <span class="font-medium">{{ $pengaduan->firstItem() }}</span>
                                sampai
                                <span class="font-medium">{{ $pengaduan->lastItem() }}</span>
                                dari
                                <span class="font-medium">{{ $pengaduan->total() }}</span>
                                hasil
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                @if($pengaduan->onFirstPage())
                                <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                                @else
                                <a href="{{ $pengaduan->previousPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                                @endif

                                @foreach(range(1, $pengaduan->lastPage()) as $i)
                                    @if($i == $pengaduan->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 border border-green-500 bg-green-50 text-sm font-medium text-green-600">
                                        {{ $i }}
                                    </span>
                                    @else
                                    <a href="{{ $pengaduan->url($i) }}" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                        {{ $i }}
                                    </a>
                                    @endif
                                @endforeach

                                @if($pengaduan->hasMorePages())
                                <a href="{{ $pengaduan->nextPageUrl() }}" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                                @else
                                <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-300">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                                @endif
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endif
    </div>
</div>
@endsection