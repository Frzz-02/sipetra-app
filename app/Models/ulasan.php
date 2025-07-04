<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ulasan extends Model
{
    use HasFactory;

    protected $table = 'ulasan'; // Nama tabel di database

    protected $fillable = [
        'id_user',
        'id_penyedia',
        'rating',
        'komentar',
    ];

    /**
     * Relasi ke model User (yang memberi ulasan)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Relasi ke model PenyediaLayanan (yang diulas)
     */
    public function penyedia()
    {
        return $this->belongsTo(Penyedia_layanan::class, 'id_penyedia');
    }
}
