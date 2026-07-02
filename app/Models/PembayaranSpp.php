<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembayaranSpp extends Model
{
    use HasFactory;

    protected $fillable = [
        'tagihan_spp_id',
        'nominal_bayar',
        'tanggal_bayar',
        'bukti_pembayaran',
        'status',
        'catatan'
    ];

    protected $casts = [
        'tanggal_bayar' => 'datetime',
        'nominal_bayar' => 'decimal:2',
    ];

    public function tagihanSpp()
    {
        return $this->belongsTo(TagihanSpp::class);
    }
}
