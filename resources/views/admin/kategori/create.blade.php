@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('header', 'Tambah Kategori Baru')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf

            <!-- Nama Kategori -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori <span class="text-red-500">*</span>
                </label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" required
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Contoh: Laboratorium Komputer">
                @error('nama_kategori')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea name="deskripsi" rows="4"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                          placeholder="Deskripsi kategori...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t">
                <a href="{{ route('admin.kategori.index') }}"
                   class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition">
                    <i class="fas fa-save mr-2"></i> Simpan Kategori
                </button>
            </div>
        </form>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 text-xl mt-1 mr-3"></i>
            <div>
                <h4 class="font-medium text-blue-800">Informasi Kategori</h4>
                <ul class="text-blue-700 text-sm mt-2 space-y-1">
                    <li><i class="fas fa-check-circle mr-2"></i> Kategori digunakan untuk mengelompokkan jenis pengaduan</li>
                    <li><i class="fas fa-check-circle mr-2"></i> Pastikan nama kategori jelas dan mudah dipahami</li>
                    <li><i class="fas fa-check-circle mr-2"></i> Kategori tidak dapat dihapus jika sudah memiliki pengaduan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection