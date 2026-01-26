<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('histori_status', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengaduan_id')->constrained('pengaduan')->onDelete('cascade');
            $table->enum('status_sebelum', ['baru', 'diproses', 'selesai']);
            $table->enum('status_sesudah', ['baru', 'diproses', 'selesai']);
            $table->timestamp('tanggal_perubahan')->useCurrent();
            $table->foreignId('diubah_oleh')->constrained('admin')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('histori_status');
    }
};