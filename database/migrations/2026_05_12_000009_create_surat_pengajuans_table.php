<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_pengajuans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->string('jenis_surat'); // Surat Izin, Keterangan Siswa, PKL
            $table->text('keperluan');
            $table->string('dokumen_pendukung')->nullable();
            $table->enum('status', ['Diproses', 'Disetujui', 'Ditolak'])->default('Diproses');
            $table->text('keterangan_admin')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_pengajuans');
    }
};
