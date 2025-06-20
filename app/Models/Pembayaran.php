<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    /** @use HasFactory<\Database\Factories\PembayaranFactory> */
    use HasFactory;

    // jika tabel pembayaran tidak memiliki kolom updated_at, maka bisa kita menonaktifkan timestamp updated_at
    public $timestamps = true;
    const UPDATED_AT = NULL; // Disable updated_at timestamp
}
