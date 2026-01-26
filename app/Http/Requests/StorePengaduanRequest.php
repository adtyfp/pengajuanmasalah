<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePengaduanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isSiswa();
    }

    public function rules(): array
    {
        return [
            'kategori_id' => 'required|exists:kategori_sarana,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'lokasi' => 'required|string|max:255',
            'prioritas' => 'required|in:rendah,sedang,tinggi',
            'foto.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_id.required' => 'Kategori harus dipilih.',
            'judul.required' => 'Judul pengaduan harus diisi.',
            'deskripsi.required' => 'Deskripsi pengaduan harus diisi.',
            'lokasi.required' => 'Lokasi harus diisi.',
            'foto.*.image' => 'File harus berupa gambar.',
            'foto.*.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}