<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagihanSpp extends Model
{
    use HasFactory;

    protected $fillable = [
        'siswa_id',
        'tahun_ajaran',
        'nominal',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'nominal' => 'decimal:2',
    ];

    public function pembayaranSpps()
    {
        return $this->hasMany(PembayaranSpp::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
