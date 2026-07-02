<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nis')->unique();
            $table->foreignId('kelas_id')->constrained()->onDelete('cascade');
            $table->foreignId('jurusan_id')->constrained()->onDelete('cascade');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('no_hp')->nullable();
            $table->string('alamat')->nullable();
            $table->string('foto_profil')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
