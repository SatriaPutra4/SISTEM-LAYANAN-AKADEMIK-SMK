<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;
    protected $table = 'pengumumans';
    protected $fillable = ['judul', 'konten', 'status_publish', 'target_role', 'author_id'];

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
