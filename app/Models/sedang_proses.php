<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sedang_proses extends Model
{
    use HasFactory;

    protected $table = 'sedang_proses';

    protected $fillable = [
        'id_pesanan',
        'catatan',
    ];

    // Relasi ke tabel pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan');
    }

    // Relasi ke petugas yang menangani
    public function petugas()
    {
        return $this->hasMany(petugas_yang_menangani::class, 'id_sedang_proses');
    }

    public function status_proses()
    {
        return $this->hasMany(status_proses::class, 'id_sedang_proses');
    }
}
