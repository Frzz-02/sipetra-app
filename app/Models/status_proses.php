<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class status_proses extends Model
{
    use HasFactory;

    protected $table = 'status_proses';

    protected $fillable = [
        'id_sedang_proses',
        'status',
        'waktu',
    ];

    // Relasi ke sedang_proses
    public function sedangProses()
    {
        return $this->belongsTo(Sedang_proses::class, 'id_sedang_proses');
    }
}
