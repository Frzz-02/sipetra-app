<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyedia_layanan_detail extends Model
{
    /** @use HasFactory<\Database\Factories\PenyediaLayananDetailFactory> */
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id_penyedia',
        'id_layanan',
        'tipe',
        'harga_dasar',
        'deskripsi',
        'opsi',
    ];
    public $timestamps = false;

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
}
