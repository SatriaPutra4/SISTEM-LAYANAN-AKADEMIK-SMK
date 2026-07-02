<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekeningSekolah extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bank',
        'nomor_rekening',
        'nama_pemilik',
        'logo_bank'
    ];
}
