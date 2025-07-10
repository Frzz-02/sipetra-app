<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class layanan_detail extends Model
{
    /** @use HasFactory<\Database\Factories\PenyediaLayananDetailFactory> */
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
        'id_penyedia',
        'id_layanan',
        'nama_variasi',
        'harga_dasar',
        'deskripsi',
    ];
    public $timestamps = false;

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
    public function pesananDetails()
    {
        return $this->hasMany(Pesanan_detail::class, 'id_layanan', 'id');
    }
}
