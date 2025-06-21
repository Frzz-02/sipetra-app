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
}
