<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Penyedia_layanan extends Model
{
    /** @use HasFactory<\Database\Factories\PenyediaLayananFactory> */
    use HasFactory;
     protected $fillable = ['id_user', 'nama_toko', 'alamat_toko', 'deskripsi'];
    protected $table = 'penyedia_layanans';
    public function user()
{
    return $this->belongsTo(User::class, 'id_user');
}

}
