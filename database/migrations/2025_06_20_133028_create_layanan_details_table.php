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
        Schema::create('layanan_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('id_penyedia')
                ->constrained('penyedia_layanans')
                ->onDelete('cascade');

            $table->foreignId('id_layanan')
                ->constrained('layanans')
                ->onDelete('cascade');

            $table->string('nama_variasi'); // contoh: "bawah", "VIP", "antar jemput area kota"
            $table->decimal('harga_dasar', 10, 2);

            $table->text('deskripsi')->nullable(); // penjelasan layanan/tambahan info

        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanan_detail');
    }
};
