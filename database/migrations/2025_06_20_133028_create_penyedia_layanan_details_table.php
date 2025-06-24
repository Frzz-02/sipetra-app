<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penyedia_layanan_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_penyedia')
                ->constrained('penyedia_layanans')
                ->onDelete('cascade');

            $table->foreignId('id_layanan')
                ->constrained('layanans')
                ->onDelete('cascade');

            $table->string('tipe'); // contoh: "bawah", "VIP", "antar jemput area kota"
            $table->decimal('harga_dasar', 10, 2);

            $table->text('deskripsi')->nullable(); // penjelasan layanan/tambahan info

            $table->json('opsi')->nullable();
            // bisa menyimpan data custom, contoh:
            // {"jumlah_kandang":30, "waktu_grooming":"30menit", "jarak_max_km":10}

            $table->boolean('status_aktif')->default(true);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyedia_layanan_details');
    }
};
