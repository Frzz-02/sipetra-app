<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    /** @use HasFactory<\Database\Factories\HewanFactory> */
    use HasFactory;
    protected $table = 'hewans'; // Nama tabel di database
    protected $fillable = [
        'id_user',
        'nama_hewan',
        'jenis_hewan',
        'foto_hewan',
        'umur',
        'deskripsi',
        'berat',
    ];
    public $timestamps = false;
}
