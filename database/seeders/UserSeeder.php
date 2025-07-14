<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penyediaUsers = [
            [
                'username'      => 'petcare_id',
                'email'         => 'petcare@example.com',
                'password'      => Hash::make('password'),
                'role'          => 'penyedia_jasa',
                'no_telephone'  => '081234567890',
                'alamat'        => 'Jl. Kucing No. 1, Jakarta',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'username'      => 'happy_paws',
                'email'         => 'happypaws@example.com',
                'password'      => Hash::make('password'),
                'role'          => 'penyedia_jasa',
                'no_telephone'  => '082233445566',
                'alamat'        => 'Jl. Anjing No. 2, Bandung',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'username'      => 'paw_corner',
                'email'         => 'pawcorner@example.com',
                'password'      => Hash::make('password'),
                'role'          => 'penyedia_jasa',
                'no_telephone'  => '083344556677',
                'alamat'        => 'Jl. Burung No. 3, Surabaya',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'username'      => 'meow_petshop',
                'email'         => 'meowpetshop@example.com',
                'password'      => Hash::make('password'),
                'role'          => 'penyedia_jasa',
                'no_telephone'  => '084455667788',
                'alamat'        => 'Jl. Ikan No. 4, Yogyakarta',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
        ];

        User::create([
            'email'         => 'feri02@gmail.com',
            'password'      => Hash::make('feriirawan'),
            'username'      => 'feri',
            'no_telephone'  => '089688433133',
            'role'          => 'user',
        ]);

        DB::table('users')->insert($penyediaUsers);
    }
}
