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
        Schema::table('siswas', function (Blueprint $table) {
            $table->string('tempat_lahir')->nullable()->after('jenis_kelamin');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
        });

        Schema::table('surat_pengajuans', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('keperluan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            $table->dropColumn(['tempat_lahir', 'tanggal_lahir']);
        });

        Schema::table('surat_pengajuans', function (Blueprint $table) {
            $table->dropColumn('deskripsi');
        });
    }
};
