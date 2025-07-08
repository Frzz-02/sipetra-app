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
        Schema::create('pesanan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pesanan')
                ->constrained('pesanans')
                ->onDelete('cascade'); //->onDelete('cascade') ini akan menghapus data pesanan detail jika data pesanan dihapus

            $table->foreignId('id_hewan')
                ->nullable()
                ->constrained('hewans')
                ->onDelete('cascade'); //->onDelete('cascade') ini akan menghapus data pesanan detail jika data penyedia layanan detail dihapus

            $table->foreignId('id_layanan')
                ->constrained('layanans')
                ->onDelete('cascade'); //->onDelete('cascade') ini akan menghapus data pesanan detail jika data penyedia layanan detail dihapus

            $table->json('data_opsi_layanan');
            $table->decimal('subtotal_biaya', 10, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan_details');
    }
};
