<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    /** @use HasFactory<\Database\Factories\LayananFactory> */
    use HasFactory;


    protected $guarded = [
        'id',

    ];
    protected $fillable = [
        'id_user',
        'nama_layanan',
        'deskripsi',
        'tipe_input',
    ];
    public $timestamps = true;
    public function variasi()
    {
        return $this->hasMany(layanan_detail::class, 'id_layanan');
    }
     public function details()
    {
        return $this->hasMany(layanan_detail::class, 'id_layanan');
    }

}
