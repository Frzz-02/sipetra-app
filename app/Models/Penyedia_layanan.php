<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Penyedia_layanan extends Model
{
    /** @use HasFactory<\Database\Factories\PenyediaLayananFactory> */
    use HasFactory;
    protected $guarded = [
            'id',
            'created_at',
            'updated_at',
        ],
    $table = 'penyedia_layanans';


    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

   public function layanans()
    {
        return $this->hasMany(\App\Models\Layanan::class, 'id_user', 'id_user');
    }

}
