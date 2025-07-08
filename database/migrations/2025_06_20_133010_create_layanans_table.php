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
        Schema::create('layanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_user')->constrained('users')->onDelete('cascade');
            $table->string('nama_layanan', 50);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_dasar', 10, 2);
            $table->enum('tipe_input', ['penitipan','antar jemput','lokasi kandang','lainnya' ])
                ->default('lainnya'); // Tipe layanan, default adalah "bawah"
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
