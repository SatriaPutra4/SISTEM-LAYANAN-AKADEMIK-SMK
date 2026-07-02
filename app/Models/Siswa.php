<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'nis', 'kelas_id', 'jurusan_id', 
        'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'no_hp', 'alamat', 'foto_profil'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function nilais()
    {
        return $this->hasMany(Nilai::class);
    }

    public function suratPengajuans()
    {
        return $this->hasMany(SuratPengajuan::class);
    }

    public function tagihanSpps()
    {
        return $this->hasMany(TagihanSpp::class);
    }
}
