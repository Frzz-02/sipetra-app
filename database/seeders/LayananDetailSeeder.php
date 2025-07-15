<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayananDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penyediaLayanans = DB::table('penyedia_layanans')->get();

        foreach ($penyediaLayanans as $penyedia) {
            // Ambil semua layanan milik penyedia ini
            $layanans = DB::table('layanans')->where('id_user', $penyedia->id_user)->get();

            foreach ($layanans as $layanan) {
                DB::table('layanan_details')->insert([
                    [
                        'id_penyedia' => $penyedia->id,
                        'id_layanan' => $layanan->id,
                        'nama_variasi' => 'Reguler',
                        'harga_dasar' => 30000,
                        'deskripsi' => 'Layanan standar untuk hewan peliharaan.',
                    ],
                    [
                        'id_penyedia' => $penyedia->id,
                        'id_layanan' => $layanan->id,
                        'nama_variasi' => 'VIP',
                        'harga_dasar' => 60000,
                        'deskripsi' => 'Layanan premium dengan fasilitas lengkap.',
                    ],
                    [
                        'id_penyedia' => $penyedia->id,
                        'id_layanan' => $layanan->id,
                        'nama_variasi' => 'Antar Jemput Area Kota',
                        'harga_dasar' => 45000,
                        'deskripsi' => 'Layanan antar jemput hewan ke lokasi penyedia.',
                    ]
                ]);
            }
        }
    }
}
