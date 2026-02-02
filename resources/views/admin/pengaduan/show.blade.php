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
        <!-- Left Column: Pengaduan Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Main Info Card -->
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $pengaduan->judul }}</h2>
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
                        <div class="font-medium">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <h3 class="text-lg font-medium text-gray-700 mb-3">Deskripsi Masalah</h3>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <p class="text-gray-700 whitespace-pre-line">{{ $pengaduan->deskripsi }}</p>
                    </div>
                </div>

                <!-- Details Grid -->
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
                            {{ $pengaduan->kategori->nama_kategori }}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Tanggal Pengaduan</h4>
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                            {{ $pengaduan->tanggal_pengaduan->format('d/m/Y') }}
                        </div>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Terakhir Diperbarui</h4>
                        <div class="flex items-center text-gray-800">
                            <i class="fas fa-history mr-2 text-blue-500"></i>
                            {{ $pengaduan->updated_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback Form -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Update Status & Berikan Feedback</h3>
                <form action="{{ route('admin.pengaduan.update-status', $pengaduan) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <!-- Status Update -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Ubah Status <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50
                                    {{ $pengaduan->status == 'baru' ? 'border-blue-500 bg-blue-50' : '' }}">
                                    <input type="radio" name="status" value="baru" 
                                           {{ $pengaduan->status == 'baru' ? 'checked' : '' }}
                                           class="mr-3 text-blue-600 focus:ring-blue-500">
                                    <div>
                                        <div class="font-medium">Baru</div>
                                        <div class="text-xs text-gray-500">Belum diproses</div>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50
                                    {{ $pengaduan->status == 'diproses' ? 'border-yellow-500 bg-yellow-50' : '' }}">
                                    <input type="radio" name="status" value="diproses" 
                                           {{ $pengaduan->status == 'diproses' ? 'checked' : '' }}
                                           class="mr-3 text-yellow-600 focus:ring-yellow-500">
                                    <div>
                                        <div class="font-medium">Diproses</div>
                                        <div class="text-xs text-gray-500">Sedang ditangani</div>
                                    </div>
                                </label>
                                
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50
                                    {{ $pengaduan->status == 'selesai' ? 'border-green-500 bg-green-50' : '' }}">
                                    <input type="radio" name="status" value="selesai" 
                                           {{ $pengaduan->status == 'selesai' ? 'checked' : '' }}
                                           class="mr-3 text-green-600 focus:ring-green-500">
                                    <div>
                                        <div class="font-medium">Selesai</div>
                                        <div class="text-xs text-gray-500">Sudah selesai</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Feedback Input -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Feedback untuk Siswa (Opsional)
                            </label>
                            <textarea name="isi_feedback" rows="4"
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Berikan feedback atau keterangan tentang penanganan pengaduan ini..."></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-4">
                            <button type="submit"
                                    class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition">
                                <i class="fas fa-save mr-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Photos -->
            @if($pengaduan->fotoPendukung->count() > 0)
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">
                    <i class="fas fa-images mr-2"></i> Foto Pendukung
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($pengaduan->fotoPendukung as $foto)
                    <div class="relative group">
                        <a href="{{ asset('storage/' . $foto->path) }}" 
                           target="_blank"
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

        <!-- Right Column: Side Info -->
        <div class="space-y-6">
            <!-- Siswa Info -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Informasi Siswa</h3>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-600"></i>
                        </div>
                        <div>
                            <div class="font-medium text-gray-900">{{ $pengaduan->siswa->nama }}</div>
                            <div class="text-sm text-gray-500">{{ $pengaduan->siswa->kelas }}</div>
                        </div>
                    </div>
                    
                    <div class="space-y-2 text-sm">
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-id-card mr-3 w-5"></i>
                            NIS: {{ $pengaduan->siswa->nis }}
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-envelope mr-3 w-5"></i>
                            Email: {{ $pengaduan->siswa->email }}
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-phone mr-3 w-5"></i>
                            Total Pengaduan: {{ $pengaduan->siswa->pengaduan->count() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status History -->
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Riwayat Status</h3>
                <div class="space-y-4">
                    @forelse($pengaduan->historiStatus as $history)
                    <div class="relative pl-8 pb-4 border-l-2 border-blue-200 last:border-l-0">
                        <div class="absolute left-[-9px] top-0 w-4 h-4 bg-blue-500 rounded-full"></div>
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">
                                {{ $history->admin->nama }}
                            </div>
                            <div class="text-gray-600 text-xs">
                                {{ $history->tanggal_perubahan->format('d/m/Y H:i') }}
                            </div>
                            <div class="mt-1 flex items-center">
                                <span class="px-2 py-1 text-xs rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($history->status_sebelum) }}
                                </span>
                                <i class="fas fa-arrow-right mx-2 text-gray-400 text-xs"></i>
                                <span class="px-2 py-1 text-xs rounded-full {{ 
                                    $history->status_sesudah == 'baru' ? 'bg-blue-100 text-blue-800' :
                                    ($history->status_sesudah == 'diproses' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800')
                                }}">
                                    {{ ucfirst($history->status_sesudah) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-gray-500 py-4">
                        <i class="fas fa-history text-2xl mb-2"></i>
                        <p>Belum ada riwayat perubahan</p>
                    </div>
                    @endforelse
                    
                    <!-- Initial Status -->
                    <div class="relative pl-8 pb-4 border-l-2 border-blue-200">
                        <div class="absolute left-[-9px] top-0 w-4 h-4 bg-blue-500 rounded-full"></div>
                        <div class="text-sm">
                            <div class="font-medium text-gray-900">Sistem</div>
                            <div class="text-gray-600 text-xs">
                                {{ $pengaduan->created_at->format('d/m/Y H:i') }}
                            </div>
                            <div class="mt-1">
                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                    Status awal: Baru
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback History -->
            @if($pengaduan->feedback->count() > 0)
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Feedback Sebelumnya</h3>
                <div class="space-y-4">
                    @foreach($pengaduan->feedback as $feedback)
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div class="font-medium text-gray-900">{{ $feedback->admin->nama }}</div>
                            <div class="text-xs text-gray-500">{{ $feedback->tanggal_feedback->format('d/m/Y H:i') }}</div>
                        </div>
                        <p class="text-sm text-gray-700 whitespace-pre-line">{{ $feedback->isi_feedback }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-resize textarea
    document.addEventListener('DOMContentLoaded', function() {
        const textarea = document.querySelector('textarea[name="isi_feedback"]');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });
        }
    });
</script>
@endpush
@endsection