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
            ->onDelete('cascade'); //->onDelete('cascade') ini akan menghapus data penyedia layanan detail jika data penyedia layanan dihapus


            $table->foreignId('id_layanan')
            ->constrained('layanans')
            ->onDelete('cascade'); //->onDelete('cascade') ini akan menghapus data penyedia layanan detail jika data layanan dihapus
            $table->string('tipe');

            $table->decimal('harga_dasar', 10, 2);
            // $table->timestamps();
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
