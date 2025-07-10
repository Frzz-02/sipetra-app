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
        'id_layanan_detail',
        'subtotal_biaya',

    ];
    public function hewan() {
        return $this->belongsTo(Hewan::class, 'id_hewan');
    }

    public function layanan() {
        return $this->belongsTo(Layanan::class, 'id_layanan');
    }
    public function layanan_detail()
    {
        return $this->belongsTo(Layanan_detail::class, 'id_layanan_detail');
    }






}
