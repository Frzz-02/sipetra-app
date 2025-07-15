<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PenyediaLayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tokoData = [];

        $users = DB::table('users')->where('role', 'penyedia_jasa')->get();

        foreach ($users as $user) {
            $tokoData[] = [
                'id_user'      => $user->id,
                'nama_toko'    => ucfirst($user->username).' Store',
                'alamat_toko'  => $user->alamat,
                'deskripsi'    => 'Tempat penitipan & perawatan hewan terpercaya.',
                'color_heading'      => null,
                'color_font_judul'   => null,
                'color_font'         => null,
                'color_button'       => null,
                'logo_toko'          => null,
                'status'       => 'aktif',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
            ];
        }

        DB::table('penyedia_layanans')->insert($tokoData);
    }
}
