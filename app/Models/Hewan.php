<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Hewan extends Model
{
    /** @use HasFactory<\Database\Factories\HewanFactory> */
    use HasFactory;
    protected $guarded = [
        'id',
    ];

    protected $table = 'hewans'; // Nama tabel di database
    public $timestamps = false;
    public function getUmurAttribute()
    {
        if (!$this->tanggal_lahir) {
            return null;
        }

        return Carbon::parse($this->tanggal_lahir)->diffForHumans(null, true);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
