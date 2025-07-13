<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class laporan_penyedia extends Model
{
    protected $table = 'laporan_penyedia';

    protected $fillable = [
        'id_user',
        'id_penyedia',
        'alasan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function penyedia()
    {
        return $this->belongsTo(Penyedia_layanan::class, 'id_penyedia');
    }
}
