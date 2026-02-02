@extends('layouts.siswa')

@section('title', 'Detail Pengaduan')
@section('header', 'Detail Pengaduan')

@php
$statusColors = [
    'baru' => 'yellow',
    'diproses' => 'blue',
    'selesai' => 'green'
];

$statusIcons = [
    'baru' => 'fa-clock',
    'diproses' => 'fa-cogs',
    'selesai' => 'fa-check-circle'
];
@endphp

@section('content')
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">{{ $pengaduan->judul }}</h2>
                <div class="mt-2 flex flex-wrap gap-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-tag mr-1"></i> {{ $pengaduan->kategori->nama_kategori }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        bg-{{ $statusColors[$pengaduan->status] }}-100 text-{{ $statusColors[$pengaduan->status] }}-800">
                        <i class="fas {{ $statusIcons[$pengaduan->status] }} mr-1"></i> {{ ucfirst($pengaduan->status) }}
                    </span>
                    @if($pengaduan->prioritas)
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                        @if($pengaduan->prioritas == 'tinggi') bg-red-100 text-red-800
                        @elseif($pengaduan->prioritas == 'sedang') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        <i class="fas fa-exclamation-circle mr-1"></i> {{ ucfirst($pengaduan->prioritas) }}
                    </span>
                    @endif
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">ID Pengaduan</p>
                <p class="text-lg font-mono text-gray-900">#{{ str_pad($pengaduan->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Detail Pengaduan -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informasi Detail -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-info-circle mr-2 text-green-600"></i> Informasi Detail
                    </h3>
                </div>
                <div class="px-6 py-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Lokasi</h4>
                            <div class="flex items-center">
                                <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                <p class="text-gray-900">{{ $pengaduan->lokasi }}</p>
                            </div>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-2">Tanggal</h4>
                            <div class="flex items-center">
                                <i class="fas fa-calendar text-gray-400 mr-2"></i>
                                <p class="text-gray-900">{{ $pengaduan->tanggal_pengaduan->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Deskripsi Masalah</h4>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-700 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Foto Pendukung -->
            @if($pengaduan->fotoPendukung->isNotEmpty())
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-images mr-2 text-green-600"></i> Foto Pendukung
                    </h3>
                </div>
                <div class="px-6 py-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($pengaduan->fotoPendukung as $foto)
                        <div class="relative group">
                            <a href="{{ Storage::url($foto->path) }}" target="_blank" class="block">
                                <img src="{{ Storage::url($foto->path) }}" 
                                     alt="{{ $foto->nama_file }}"
                                     class="w-full h-48 object-cover rounded-lg shadow-sm group-hover:opacity-90 transition-opacity">
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-opacity rounded-lg"></div>
                            </a>
                            <p class="mt-2 text-sm text-gray-600 truncate">{{ $foto->nama_file }}</p>
                            <p class="text-xs text-gray-400">{{ $foto->tanggal_upload->format('d M Y') }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Sidebar -->
        <div class="space-y-6">
            <!-- Status Timeline -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-history mr-2 text-green-600"></i> Timeline Status
                    </h3>
                </div>
                <div class="px-6 py-5">
                    <ol class="relative border-l border-gray-200">
                        <!-- Status Baru -->
                        <li class="mb-6 ml-4">
                            <div class="absolute w-3 h-3 bg-green-600 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400">
                                {{ $pengaduan->tanggal_pengaduan->format('d M Y') }}
                            </time>
                            <h4 class="text-lg font-semibold text-gray-900">Dibuat</h4>
                            <p class="text-sm font-normal text-gray-500">Pengaduan berhasil dibuat</p>
                        </li>
                        
                        <!-- Status Diproses -->
                        @if(in_array($pengaduan->status, ['diproses', 'selesai']))
                        <li class="mb-6 ml-4">
                            <div class="absolute w-3 h-3 bg-blue-600 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400">
                                {{ $pengaduan->tanggal_pengaduan->addDay()->format('d M Y') }}
                            </time>
                            <h4 class="text-lg font-semibold text-gray-900">Diproses</h4>
                            <p class="text-sm font-normal text-gray-500">Sedang ditangani oleh admin</p>
                        </li>
                        @endif
                        
                        <!-- Status Selesai -->
                        @if($pengaduan->status == 'selesai')
                        <li class="ml-4">
                            <div class="absolute w-3 h-3 bg-green-600 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                            <time class="mb-1 text-sm font-normal leading-none text-gray-400">
                                {{ $pengaduan->tanggal_pengaduan->addDays(2)->format('d M Y') }}
                            </time>
                            <h4 class="text-lg font-semibold text-gray-900">Selesai</h4>
                            <p class="text-sm font-normal text-gray-500">Pengaduan telah selesai</p>
                        </li>
                        @endif
                    </ol>
                </div>
            </div>

            <!-- Feedback Admin -->
            @if($pengaduan->feedback)
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 bg-green-50">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-comment-dots mr-2 text-green-600"></i> Feedback Admin
                    </h3>
                </div>
                <div class="px-6 py-5">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                <i class="fas fa-user-tie text-green-600"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $pengaduan->feedback->admin->nama ?? 'Admin Sekolah' }}
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $pengaduan->feedback->tanggal_feedback->format('d M Y H:i') }}
                            </div>
                            <div class="mt-2 text-sm text-gray-700 bg-gray-50 rounded-lg p-3">
                                <p class="whitespace-pre-line">{{ $pengaduan->feedback->isi_feedback }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-comment-dots mr-2 text-gray-400"></i> Feedback
                    </h3>
                </div>
                <div class="px-6 py-5 text-center">
                    <i class="fas fa-clock text-gray-300 text-4xl mb-3"></i>
                    <p class="text-gray-600">Belum ada feedback dari admin</p>
                    <p class="text-sm text-gray-500 mt-1">Admin akan memberikan feedback setelah meninjau pengaduan</p>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        <i class="fas fa-bolt mr-2 text-green-600"></i> Aksi Cepat
                    </h3>
                </div>
                <div class="px-6 py-5">
                    <div class="space-y-3">
                        <a href="{{ route('siswa.pengaduan.index') }}" 
                           class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
                        </a>
                        
                        @if($pengaduan->status == 'baru')
                        <form action="{{ route('siswa.pengaduan.destroy', $pengaduan) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                                <i class="fas fa-trash mr-2"></i> Hapus Pengaduan
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection