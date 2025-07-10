<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawans'; // opsional, jika sesuai konvensi Laravel bisa dihapus

    protected $fillable = [
        'id_penyedia_layanan',
        'nama',
        'email',
        'no_telephone',
        'alamat',
        'tipe_karyawan',
        'status',
        'foto_karyawan',
    ];

    // Relasi ke penyedia layanan
    public function penyediaLayanan()
    {
        return $this->belongsTo(penyedia_layanan::class, 'id_penyedia_layanan');
    }

    // Relasi ke penanganan (petugas_yang_menangani)
    public function penanganan()
    {
        return $this->hasMany(petugas_yang_menangani::class, 'id_karyawan');
    }
}

