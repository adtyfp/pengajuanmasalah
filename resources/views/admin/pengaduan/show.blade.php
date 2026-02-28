@extends('layouts.admin')

@section('title', 'Detail Pengaduan')
@section('header', 'Detail Pengaduan')

@section('content')
<div class="space-y-6">

    <!-- Navigation -->
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pengaduan.index') }}"
           class="text-blue-600 hover:text-blue-800 inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
        <div class="text-sm text-gray-500">
            ID: #{{ str_pad($pengaduan->id, 6, '0', STR_PAD_LEFT) }}
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- LEFT COLUMN -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Main Info -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">
                            {{ $pengaduan->judul }}
                        </h2>

                        <div class="flex items-center space-x-4 mt-2">
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->status_color }}">
                                {{ ucfirst($pengaduan->status) }}
                            </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->prioritas_color }}">
                                {{ ucfirst($pengaduan->prioritas) }}
                            </span>
                        </div>
                    </div>

                    <div class="text-right">
                        <div class="text-sm text-gray-500">Dibuat</div>
                        <div class="font-medium">
                            {{ optional($pengaduan->created_at)->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-3">Deskripsi Masalah</h3>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-line">
                            {{ $pengaduan->deskripsi }}
                        </p>
                    </div>
                </div>

                <!-- Detail Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Lokasi</h4>
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                            {{ $pengaduan->lokasi }}
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Kategori</h4>
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-tag mr-2 text-blue-500"></i>
                            {{ optional($pengaduan->kategori)->nama_kategori }}
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Tanggal Pengaduan</h4>
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                            {{ optional($pengaduan->tanggal_pengaduan)->format('d/m/Y') }}
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Terakhir Diperbarui</h4>
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-history mr-2 text-blue-500"></i>
                            {{ optional($pengaduan->updated_at)->format('d/m/Y H:i') }}
                        </div>
                    </div>

                </div>
            </div>

            <!-- FOTO PENDUKUNG -->
            @if($pengaduan->fotoPendukung && $pengaduan->fotoPendukung->isNotEmpty())
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">
                    <i class="fas fa-images mr-2"></i> Foto Pendukung
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($pengaduan->fotoPendukung as $foto)
                    <div class="relative group">
                        <a href="{{ asset('storage/' . $foto->path) }}" target="_blank"
                           class="block border border-gray-200 rounded-lg overflow-hidden hover:border-blue-400 transition">
                            <img src="{{ asset('storage/' . $foto->path) }}"
                                 alt="{{ $foto->nama_file }}"
                                 class="w-full h-32 object-cover">
                        </a>
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white text-xs p-2 opacity-0 group-hover:opacity-100 transition">
                            {{ $foto->nama_file }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        <!-- RIGHT COLUMN -->
        <div class="space-y-6">

            <!-- SISWA -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Informasi Siswa</h3>

                <div class="space-y-3">

                    <div class="font-medium text-gray-900">
                        {{ optional($pengaduan->siswa)->nama }}
                    </div>

                    <div class="text-sm text-gray-600">
                        Kelas: {{ optional($pengaduan->siswa)->kelas }}
                    </div>

                    <div class="text-sm text-gray-600">
                        NIS: {{ optional($pengaduan->siswa)->nis }}
                    </div>

                    <div class="text-sm text-gray-600">
                        Email: {{ optional($pengaduan->siswa)->email }}
                    </div>

                    <div class="text-sm text-gray-600">
                        Total Pengaduan:
                        {{ $pengaduan->siswa->pengaduan_count ?? 0 }}
                    </div>

                </div>
            </div>

            <!-- RIWAYAT STATUS -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Riwayat Status</h3>

                @forelse($pengaduan->historiStatus as $history)
                    <div class="mb-4">
                        <div class="text-sm font-medium">
                            {{ optional($history->admin)->nama ?? 'Admin' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ optional($history->created_at)->format('d/m/Y H:i') }}
                        </div>
                        <div class="text-sm mt-1">
                            {{ ucfirst($history->status_sebelum) }}
                            →
                            {{ ucfirst($history->status_sesudah) }}
                        </div>
                    </div>
                @empty
                    <div class="text-sm text-gray-500">
                        Belum ada riwayat perubahan
                    </div>
                @endforelse
            </div>

            <!-- FEEDBACK -->
            @if($pengaduan->feedback && $pengaduan->feedback->isNotEmpty())
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Feedback Sebelumnya</h3>

                @foreach($pengaduan->feedback as $feedback)
                    <div class="mb-4 p-3 bg-gray-50 rounded">
                        <div class="text-sm font-medium">
                            {{ optional($feedback->admin)->nama ?? 'Admin' }}
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ optional($feedback->created_at)->format('d/m/Y H:i') }}
                        </div>
                        <div class="text-sm mt-2 whitespace-pre-line">
                            {{ $feedback->isi_feedback }}
                        </div>
                    </div>
                @endforeach
            </div>
            @endif

        </div>

    </div>
</div>
@endsection