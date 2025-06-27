<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    /** @use HasFactory<\Database\Factories\PesananFactory> */
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $fillable = [
    'id_user',
    'id_penyedia_layanan',
    'tanggal_pesan',
    'tanggal_mulai',
    'tanggal_selesai',
    'tanggal_titip',
    'tanggal_ambil',
    'lokasi_awal',
    'lokasi_tujuan',
    'total_biaya',
    'status',
    ];
    protected $table = 'pesanans';

     public $timestamps = false;
}
