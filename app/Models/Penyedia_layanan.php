<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Penyedia_layanan extends Model
{
    use HasFactory;

    protected $table = 'penyedia_layanans';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'id_user', 'nama_toko', 'alamat_toko', 'deskripsi',
        'color_heading', 'color_font_judul', 'color_font', 'color_button',
        'logo_toko', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function layanans()
    {
        return $this->hasMany(\App\Models\Layanan::class, 'id_user', 'id_user');
    }

    public function ulasan()
    {
        return $this->hasMany(\App\Models\Ulasan::class, 'id_penyedia');
    }

    public function fotos()
    {
        return $this->hasMany(\App\Models\Foto_penyedia::class, 'id_penyedia_layanan');
    }
}
