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
        Schema::create('pembayaran_spps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_spp_id')->constrained('tagihan_spps')->onDelete('cascade');
            $table->decimal('nominal_bayar', 12, 2);
            $table->dateTime('tanggal_bayar');
            $table->string('bukti_pembayaran')->nullable();
            $table->enum('status', ['Menunggu Verifikasi', 'Disetujui', 'Ditolak'])->default('Menunggu Verifikasi');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_spps');
    }
};
