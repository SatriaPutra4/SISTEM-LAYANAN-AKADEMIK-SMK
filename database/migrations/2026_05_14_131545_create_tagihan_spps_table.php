<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tagihan_spps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
            $table->string('bulan');
            $table->string('tahun_ajaran');
            $table->decimal('nominal', 12, 2);
            $table->enum('status', ['Belum Bayar', 'Menunggu Verifikasi', 'Lunas'])->default('Belum Bayar');
            $table->string('bukti_pembayaran')->nullable();
            $table->dateTime('tanggal_pembayaran')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_spps');
    }
};
