<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hewan extends Model
{
    /** @use HasFactory<\Database\Factories\HewanFactory> */
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    protected $table = 'hewans'; // Nama tabel di database
    public $timestamps = false;
}
