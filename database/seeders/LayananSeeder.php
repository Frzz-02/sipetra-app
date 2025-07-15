<?php

namespace Database\Seeders;

use App\Models\Layanan;
use App\Models\Penyedia_layanan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penyediaList = Penyedia_layanan::all();

        foreach ($penyediaList as $penyedia) {
            Layanan::create([
                'id_user' => $penyedia->id_user,
                'nama_layanan' => 'Penitipan Hewan Harian',
                'deskripsi' => 'Layanan penitipan harian untuk hewan peliharaan seperti kucing dan anjing.',
                'tipe_input' => 'penitipan',
                'status' => 'tampilkan',
            ]);

            Layanan::create([
                'id_user' => $penyedia->id_user,
                'nama_layanan' => 'Grooming Kucing & Anjing',
                'deskripsi' => 'Layanan mandi dan potong kuku hewan peliharaan.',
                'tipe_input' => 'lainnya',
                'status' => 'tampilkan',
            ]);
        }
    }
}
