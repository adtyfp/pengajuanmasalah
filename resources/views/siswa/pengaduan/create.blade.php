@extends('layouts.siswa')

@section('title', 'Buat Pengaduan Baru')
@section('header', 'Buat Pengaduan Baru')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">
                Form Pengaduan Baru
            </h3>
            <p class="mt-1 text-sm text-gray-600">
                Isi semua informasi yang diperlukan untuk membuat pengaduan baru
            </p>
        </div>
        
        <form method="POST" action="{{ route('siswa.pengaduan.store') }}" enctype="multipart/form-data" class="px-6 py-5">
            @csrf
            
            <div class="space-y-6">
                <!-- Judul -->
                <div>
                    <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">
                        Judul Pengaduan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="judul" id="judul" 
                           value="{{ old('judul') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('judul') border-red-300 @enderror"
                           placeholder="Contoh: Kursi rusak di kelas 12 IPA 1" required>
                    @error('judul')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kategori dan Prioritas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Kategori Sarana <span class="text-red-500">*</span>
                        </label>
                        <select name="kategori_id" id="kategori_id" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('kategori_id') border-red-300 @enderror" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="prioritas" class="block text-sm font-medium text-gray-700 mb-1">
                            Tingkat Prioritas
                        </label>
                        <select name="prioritas" id="prioritas" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('prioritas') border-red-300 @enderror">
                            <option value="">Pilih Prioritas</option>
                            <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                            <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                            <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                        </select>
                        @error('prioritas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Lokasi -->
                <div>
                    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">
                        Lokasi Kejadian <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="lokasi" id="lokasi" 
                           value="{{ old('lokasi') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('lokasi') border-red-300 @enderror"
                           placeholder="Contoh: Kelas 12 IPA 1, Ruang Lab Komputer 2, Lapangan Basket" required>
                    @error('lokasi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 mb-1">
                        Deskripsi Masalah <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi" id="deskripsi" rows="5"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500 @error('deskripsi') border-red-300 @enderror"
                              placeholder="Jelaskan secara detail masalah yang Anda temukan, kondisi saat ini, dan dampaknya..." required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Foto Pendukung -->
                <div>
                    <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">
                        Foto Pendukung (Opsional)
                    </label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md @error('foto.*') border-red-300 @enderror">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="foto" class="relative cursor-pointer bg-white rounded-md font-medium text-green-600 hover:text-green-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-green-500">
                                    <span>Upload file</span>
                                    <input type="file" name="foto[]" id="foto" multiple accept="image/*" class="sr-only">
                                </label>
                                <p class="pl-1">atau drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">
                                PNG, JPG, GIF hingga 2MB per file (maksimal 5 file)
                            </p>
                        </div>
                    </div>
                    @error('foto.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    
                    <!-- Preview Container -->
                    <div id="previewContainer" class="mt-4 grid grid-cols-2 md:grid-cols-3 gap-4 hidden">
                        <!-- Preview akan ditampilkan di sini -->
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="pt-6 border-t border-gray-200">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('siswa.pengaduan.index') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-arrow-left mr-2"></i> Kembali
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            <i class="fas fa-paper-plane mr-2"></i> Kirim Pengaduan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('foto').addEventListener('change', function(e) {
    const previewContainer = document.getElementById('previewContainer');
    previewContainer.innerHTML = '';
    
    const files = e.target.files;
    
    if (files.length > 0) {
        previewContainer.classList.remove('hidden');
        
        for (let i = 0; i < Math.min(files.length, 5); i++) {
            const file = files[i];
            
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const preview = document.createElement('div');
                    preview.className = 'relative';
                    
                    preview.innerHTML = `
                        <div class="relative group">
                            <img src="${e.target.result}" alt="Preview" class="w-full h-32 object-cover rounded-lg">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center">
                                <span class="text-white opacity-0 group-hover:opacity-100 text-sm">Preview</span>
                            </div>
                            <span class="absolute top-2 right-2 bg-gray-800 text-white text-xs rounded-full w-6 h-6 flex items-center justify-center">
                                ${i + 1}
                            </span>
                        </div>
                        <p class="mt-1 text-xs text-gray-500 truncate">${file.name}</p>
                    `;
                    
                    previewContainer.appendChild(preview);
                };
                
                reader.readAsDataURL(file);
            }
        }
    } else {
        previewContainer.classList.add('hidden');
    }
});
</script>
@endpush
@endsection