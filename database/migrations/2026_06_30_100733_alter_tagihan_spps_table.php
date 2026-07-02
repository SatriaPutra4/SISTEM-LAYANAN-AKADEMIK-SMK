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
        Schema::table('tagihan_spps', function (Blueprint $table) {
            $table->dropColumn(['bulan', 'bukti_pembayaran', 'tanggal_pembayaran']);
            // Ubah enum status jika memungkinkan, namun lebih aman menambahkan status baru jika diperlukan
            // karena db/doctrine_dbal mungkin bermasalah dengan enum.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tagihan_spps', function (Blueprint $table) {
            $table->string('bulan')->nullable();
            $table->string('bukti_pembayaran')->nullable();
            $table->dateTime('tanggal_pembayaran')->nullable();
        });
    }
};
