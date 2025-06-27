<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan_detail extends Model
{
    /** @use HasFactory<\Database\Factories\PesananDetailFactory> */
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    public $timestamps = false;
    protected $table = 'pesanan_details';

    protected $fillable = [
        'id_pesanan',
        'id_hewan',
        'id_layanan',
        'data_opsi_layanan',
        'subtotal_biaya',
        'lokasi_awal',
        'lokasi_tujuan',
    ];


}
