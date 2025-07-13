<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class foto_penyedia extends Model
{
    use HasFactory;

    protected $table = 'foto_penyedia_layanans';

    protected $fillable = [
        'id_penyedia_layanan',
        'foto',
    ];

    /**
     * Relasi ke model PenyediaLayanan
     */
    public function penyediaLayanan()
    {
        return $this->belongsTo(Penyedia_layanan::class, 'id_penyedia_layanan');
    }
}
