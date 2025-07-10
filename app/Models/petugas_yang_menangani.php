<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class petugas_yang_menangani extends Model
{
    use HasFactory;

    protected $table = 'petugas_yang_menangani';

    protected $fillable = [
        'id_sedang_proses',
        'id_karyawan',
    ];

    // Relasi ke model SedangProses
    public function sedangProses()
    {
        return $this->belongsTo(sedang_proses::class, 'id_sedang_proses');
    }

    // Relasi ke model Karyawan
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
