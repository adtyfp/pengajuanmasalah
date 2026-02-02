@extends('layouts.admin')

@section('title', 'Edit Pengaduan')
@section('header', 'Edit Pengaduan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6">
        <!-- Navigation -->
        <div class="mb-6">
            <a href="{{ route('admin.pengaduan.show', $pengaduan) }}" 
               class="text-blue-600 hover:text-blue-800 inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Detail
            </a>
        </div>

        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Edit Pengaduan #{{ str_pad($pengaduan->id, 6, '0', STR_PAD_LEFT) }}</h2>
            <p class="text-gray-600 mt-2">Perbarui informasi pengaduan dari siswa</p>
        </div>

        <!-- Quick Status -->
        <div class="mb-8 bg-gray-50 border border-gray-200 rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-700 mb-4">Status Saat Ini</h3>
            <div class="flex items-center space-x-6">
                <div>
                    <div class="text-sm text-gray-500">Status</div>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->status_color }}">
                        {{ ucfirst($pengaduan->status) }}
                    </span>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Prioritas</div>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $pengaduan->prioritas_color }}">
                        {{ ucfirst($pengaduan->prioritas) }}
                    </span>
                </div>
                <div>
                    <div class="text-sm text-gray-500">Dibuat</div>
                    <div class="font-medium">{{ $pengaduan->created_at->format('d/m/Y H:i') }}</div>
                </div>
            </div>
        </div>

        <!-- Edit Form -->
        <form action="{{ route('admin.pengaduan.update-status', $pengaduan) }}" method="POST">
            @csrf

            <div class="space-y-6">
                <!-- Basic Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Judul -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Judul Pengaduan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="judul" value="{{ old('judul', $pengaduan->judul) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               readonly>
                    </div>

                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Kategori <span class="text-red-500">*</span>
                        </label>
                        <input type="text" value="{{ $pengaduan->kategori->nama_kategori }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                    </div>

                    <!-- Lokasi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Lokasi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="lokasi" value="{{ old('lokasi', $pengaduan->lokasi) }}" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50"
                               readonly>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="baru" {{ $pengaduan->status == 'baru' ? 'selected' : '' }}>Baru</option>
                            <option value="diproses" {{ $pengaduan->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="selesai" {{ $pengaduan->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <!-- Prioritas -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Prioritas <span class="text-red-500">*</span>
                        </label>
                        <select name="prioritas" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="rendah" {{ $pengaduan->prioritas == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ $pengaduan->prioritas == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ $pengaduan->prioritas == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                    </div>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Lengkap <span class="text-red-500">*</span>
                    </label>
                    <textarea rows="6" readonly
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50">{{ $pengaduan->deskripsi }}</textarea>
                </div>

                <!-- Feedback -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tambahkan Feedback (Opsional)
                    </label>
                    <textarea name="isi_feedback" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Berikan feedback atau keterangan tentang penanganan pengaduan ini...">{{ old('isi_feedback') }}</textarea>
                    <p class="text-sm text-gray-500 mt-1">Feedback akan dikirim ke siswa dan disimpan dalam riwayat.</p>
                </div>

                <!-- Siswa Info (Readonly) -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h4 class="font-medium text-blue-800 mb-2">Informasi Siswa</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-blue-600">Nama:</span>
                            <span class="font-medium ml-2">{{ $pengaduan->siswa->nama }}</span>
                        </div>
                        <div>
                            <span class="text-blue-600">Kelas:</span>
                            <span class="font-medium ml-2">{{ $pengaduan->siswa->kelas }}</span>
                        </div>
                        <div>
                            <span class="text-blue-600">NIS:</span>
                            <span class="font-medium ml-2">{{ $pengaduan->siswa->nis }}</span>
                        </div>
                        <div>
                            <span class="text-blue-600">Total Pengaduan:</span>
                            <span class="font-medium ml-2">{{ $pengaduan->siswa->pengaduan->count() }}</span>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between pt-6 border-t">
                    <div>
                        <a href="{{ route('admin.pengaduan.show', $pengaduan) }}"
                           class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                            <i class="fas fa-times mr-2"></i> Batal
                        </a>
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition">
                            <i class="fas fa-save mr-2"></i> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Warning -->
    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-xl p-6">
        <div class="flex items-start">
            <i class="fas fa-exclamation-triangle text-yellow-500 text-xl mt-1 mr-3"></i>
            <div>
                <h4 class="font-medium text-yellow-800">Perhatian</h4>
                <ul class="text-yellow-700 text-sm mt-2 space-y-1">
                    <li><i class="fas fa-info-circle mr-2"></i> Perubahan status akan tercatat dalam riwayat</li>
                    <li><i class="fas fa-info-circle mr-2"></i> Feedback yang diberikan akan dikirim ke siswa</li>
                    <li><i class="fas fa-info-circle mr-2"></i> Informasi judul, deskripsi, dan lokasi tidak dapat diubah untuk menjaga keaslian laporan</li>
                </ul>
            </div>
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