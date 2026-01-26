@extends('layouts.siswa')

@section('title', 'Buat Pengaduan Baru')
@section('header', 'Buat Pengaduan Baru')

@section('content')
<div class="bg-white rounded-lg shadow p-6">
    <form action="{{ route('siswa.pengaduan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kategori -->
            <div>
                <label class="block text-gray-700 mb-2">Kategori Sarana *</label>
                <select name="kategori_id" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Judul -->
            <div>
                <label class="block text-gray-700 mb-2">Judul Pengaduan *</label>
                <input type="text" name="judul" value="{{ old('judul') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Contoh: Kursi rusak di Lab Komputer">
                @error('judul')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Lokasi -->
            <div>
                <label class="block text-gray-700 mb-2">Lokasi *</label>
                <input type="text" name="lokasi" value="{{ old('lokasi') }}" required
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Contoh: Laboratorium Komputer, Ruang 101">
                @error('lokasi')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Prioritas -->
            <div>
                <label class="block text-gray-700 mb-2">Prioritas *</label>
                <select name="prioritas" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                    <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                    <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                </select>
            </div>
        </div>

        <!-- Deskripsi -->
        <div class="mt-6">
            <label class="block text-gray-700 mb-2">Deskripsi Lengkap *</label>
            <textarea name="deskripsi" rows="5" required
                      class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                      placeholder="Jelaskan masalah secara detail...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Upload Foto -->
        <div class="mt-6">
            <label class="block text-gray-700 mb-2">Foto Pendukung (Opsional)</label>
            <input type="file" name="foto[]" multiple accept="image/*"
                   class="w-full px-4 py-2 border rounded-lg">
            <p class="text-gray-500 text-sm mt-1">Maksimal 5 foto, ukuran maksimal 2MB per foto</p>
        </div>

        <!-- Buttons -->
        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('siswa.pengaduan.index') }}"
               class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                Batal
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300">
                <i class="fas fa-paper-plane mr-2"></i> Kirim Pengaduan
            </button>
        </div>
    </form>
</div>
@endsection